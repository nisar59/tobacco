<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Expense;
use App\Models\Product;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Http\Requests\PurchaseOrders\Index;
use App\Http\Requests\PurchaseOrders\Show;
use App\Http\Requests\PurchaseOrders\Create;
use App\Http\Requests\PurchaseOrders\Store;
use App\Http\Requests\PurchaseOrders\Edit;
use App\Http\Requests\PurchaseOrders\Update;
use App\Http\Requests\PurchaseOrders\Destroy;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Description of PurchaseOrderController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class PurchaseReturnController extends Controller
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

            $supplier = Supplier::join('purchase_returns', 'purchase_returns.supplier_id', '=', 'suppliers.id')
                ->join('products', 'purchase_returns.product_id', '=', 'products.id')
                ->where('purchase_returns.deleted', 0);

            if ($req->supplier_name != null) {
                $supplier->where('suppliers.supplier_name', $req->supplier_name);
            }


            $total = $supplier->count();
            $supplier = $supplier->select('purchase_returns.supplier_id', 'purchase_returns.return_date', 'products.uuid', 'purchase_returns.qty', 'purchase_returns.unit_price')
                ->offset($strt)
                ->limit($length)
                ->get();

            return DataTables::of($supplier)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->make(true);
        }

        return view('pages.purchase_return.index');
    }

    public function create(Request $request)
    {

        $suppliers = Supplier::join('purchase_orders', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->where('suppliers.status', 1)
            ->select(['suppliers.id', 'suppliers.supplier_name'])
            ->groupBy('suppliers.id', 'suppliers.supplier_name')
            ->get();

        $products = Product::where('deleted', 0)
            ->where('status', 1)
            ->get();

        return view('pages.purchase_return.form', [
            'model' => new PurchaseReturn(),
            'suppliers' => $suppliers,
            'products' => $products

        ]);
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new PurchaseReturn();
        $model->fill($request->all());


        DB::beginTransaction();
        try {
            if ($model->save()) {
                $product = Product::where('id', $model->product_id)->first();
                if (isset($product) && !empty($product)) {
                    $product->stock_in_hand -= $request->qty;

                    if ($product->save()) {
                        $supplierPayments = SupplierPayment::where('supplier_id', $model->supplier_id)->first();

                        $purchaseTotal = PurchaseOrder::where('supplier_id', $model->supplier_id)->sum('invoice_price');
                        $supplierPaymentSum  = Expense::where('correspondent_id',$model->supplier_id)->where('type','purchase_payment')->where('deleted',0)->sum('amount');

                        $purchaseReturnTotal = DB::table('purchase_returns')
                            ->selectRaw('SUM(purchase_returns.qty * purchase_returns.unit_price) as total')
                            ->where('supplier_id', $model->supplier_id)->get()->toArray()[0]->total;
                        if(isset($purchaseReturnTotal) && !empty($purchaseReturnTotal)){
                            $pRTotal = $purchaseReturnTotal;
                        }else{
                            $pRTotal = 0;
                        }

                        $pt = $purchaseTotal - $pRTotal;
                        $diff = $pt - $supplierPaymentSum;
                        $supplierPayments->purchase_total = $pt;
                        $supplierPayments->paid_total = $supplierPaymentSum;
                        $supplierPayments->diff_amount = $diff;
                        if ($supplierPayments->save()) {
                            DB::commit();
                            session()->flash('app_message', 'Purchase return saved successfully');
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something went wrong, please contact admin!');
            DB::rollback();
        }

        return redirect()->to('purchasereturns/index');
    }

    public function fetchProduct(Request $request)
    {
        $model = Supplier::join('purchase_orders', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->join('purchase_order_details', 'purchase_order_details.purchase_order_id', '=', 'purchase_orders.id')
            ->join('products', 'products.id', '=', 'purchase_order_details.product_id')
            ->where('suppliers.status', 1)
            ->where('suppliers.id', $request->id)
            ->select(['products.id', 'products.uuid as code'])
            ->groupBy('products.id', 'products.uuid')
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
        $model = Product::where('id', $request->id)->select(['stock_in_hand'])->first();
        return response()->json($model);
    }
}
