<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Product;
use App\Models\SaleOrderDetail;
use App\Models\SaleReturn;
use function Brick\Math\sum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleOrder;
use App\Http\Requests\SaleOrders\Index;
use App\Http\Requests\SaleOrders\Show;
use App\Http\Requests\SaleOrders\Create;
use App\Http\Requests\SaleOrders\Store;
use App\Http\Requests\SaleOrders\Edit;
use App\Http\Requests\SaleOrders\Update;
use App\Http\Requests\SaleOrders\Destroy;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

/**
 * Description of SaleOrderController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class SaleReturnController extends Controller
{

    /*
     * Display a listing of the resource.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if ($req->ajax()) {

            $strt = $req->start;
            $length = $req->length;

            $customers = Customer::join('sale_returns', 'sale_returns.customer_id', '=', 'customers.id')
                ->join('products', 'sale_returns.product_id', '=', 'products.id')
                ->where('sale_returns.deleted', 0);

            if ($req->customer_name != null) {
                $customers->where('customers.customer_name', $req->customer_name);
            }


            $total = $customers->count();
            $customers = $customers->select('sale_returns.customer_id', 'sale_returns.return_date', 'products.uuid', 'sale_returns.qty', 'sale_returns.unit_price')
                ->offset($strt)
                ->limit($length)
                ->get();

            return DataTables::of($customers)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->make(true);
        }

        return view('pages.sale_return.index');
    }

    public function create(Request $request)
    {

        $customers = Customer::join('sale_orders', 'sale_orders.customer_id', '=', 'customers.id')
            ->where('customers.status', 1)
            ->select(['customers.id', 'customers.customer_name'])
            ->groupBy('customers.id','customers.customer_name')
            ->get();

        $products = Product::where('deleted', 0)
            ->where('status', 1)
            ->get();

        return view('pages.sale_return.form', [
            'model' => new SaleReturn(),
            'customers' => $customers,
            'products' => $products

        ]);
    }

    /*
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new SaleReturn();
        $model->fill($request->all());

        DB::beginTransaction();
        try {
            if ($model->save()) {
                $product = Product::where('id',$model->product_id)->first();
                if(isset($product) && !empty($product)){
                    $product->stock_in_hand += $request->qty;
                    if($product->save()){
                        $customerPayments = CustomerPayment::where('customer_id',$model->customer_id)->first();
                        $st = $customerPayments->sale_total-($model->qty*$model->unit_price);
                        $diff = $st-($customerPayments->paid_total);
                        $customerPayments->sale_total = $st;
                        $customerPayments->diff_amount = $diff;
                        if($customerPayments->save()){
                            DB::commit();
                            session()->flash('app_message', 'Sale return saved successfully');
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something went wrong, please contact admin!');
            DB::rollback();
        }

        return redirect()->to('salesreturns/index');
    }


    public function fetchProduct(Request $request)
    {
        $model = Customer::join('sale_orders', 'sale_orders.customer_id', '=', 'customers.id')
            ->join('sale_order_details', 'sale_order_details.sale_order_id', '=', 'sale_orders.id')
            ->join('products', 'products.id', '=', 'sale_order_details.product_id')
            ->where('customers.status', 1)
            ->select(['products.id', 'products.uuid as code'])
            ->groupBy('products.id','products.uuid')
            ->get();

        return response()->json($model);
    }

    public function fetchProductDetails(Request $request)
    {
        $model = Product::where('id', $request->id)->select(['unit_price'])->first();
        return response()->json($model);
    }

    public function fetchProductQty(Request $request)
    {
        $model = SaleOrder::join('sale_order_details', 'sale_order_details.sale_order_id', '=', 'sale_orders.id')
            ->join('products', 'products.id', '=', 'sale_order_details.product_id')
            ->where('sale_orders.customer_id', $request->customer_id)
            ->where('sale_order_details.product_id', $request->product_id)
            ->sum('sale_order_details.quantity');
        $data = ['quantity'=>$model];

        return response()->json($data);
    }

}
