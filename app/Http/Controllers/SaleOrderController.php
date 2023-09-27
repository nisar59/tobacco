<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\PaymentHelper;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Product;
use App\Models\SaleOrderDetail;
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
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

/**
 * Description of SaleOrderController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class SaleOrderController extends Controller
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

            $model = SaleOrder::where('deleted', 0)->where('status', 1);

            if ($req->customer_id != null) {
                $model->where('customer_id', $req->customer_id);
            }
            if ($req->invoice_number != null) {
                $model->where('invoice_number', $req->invoice_number);
            }
            if ($req->sale_date != null) {
                $string = explode('-', $req->sale_date);
                $date1 = date('Y-m-d', strtotime($string[0]));
                $date2 = date('Y-m-d', strtotime($string[1]));

                $model->where('sale_date', '>=', $date1);
                $model->where('sale_date', '<=', $date2);
            }

            $total = $model->count();
            $model = $model->select('sale_orders.*')->offset($strt)->limit($length)->orderBy('id', 'DESC')->get();

            return DataTables::of($model)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/sales/edit/' . $row->id) . '" class="btn btn-default" data-bs-toggle="tooltip" data-bs-placement="top" title="Update" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-edit"></i>
                        </a>
                    </div>
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/sales/show/' . $row->id) . '" class="btn btn-default" data-bs-toggle="tooltip" data-bs-placement="top" title="View Receipt" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-eye"></i>
                        </a>
                    </div>
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/sales/return/' . $row->id) . '" class="btn btn-default" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Returns" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-undo"></i>
                        </a>
                    </div>
                 ';
                })
                ->editColumn('customer_id', function ($row) {
                    return $row->customer_id;
                })
                ->editColumn('sale_date', function ($row) {
                    return $row->sale_date;
                })
                ->editColumn('invoice_number', function ($row) {
                    return $row->invoice_number;
                })
                ->editColumn('status', function ($row) {
                    return $row->status;
                })
                ->rawColumns(['action', 'id'])
                ->make(true);
        }

        $customers = Customer::where('status', 1)
            ->select(['id', 'customer_name'])
            ->get();
        return view('pages.sale_orders.index', ['customers' => $customers]);
    }

    public function indexReceivable(Request $req)
    {

        if ($req->ajax()) {

            $strt = $req->start;
            $length = $req->length;

            $customer = Customer::join('expenses', 'expenses.correspondent_id', '=', 'customers.id')
                ->where('expenses.type','sale_receipts')
                ->where('expenses.deleted',0);

            if ($req->customer_name != null) {
                $customer->where('customers.customer_name', $req->customer_name);
            }

            if ($req->exp_date != null) {
                $string = explode('-', $req->exp_date);
                $date1 = date('Y-m-d', strtotime($string[0]));
                $date2 = date('Y-m-d', strtotime($string[1]));

                $customer->where('expenses.exp_date', '>=', $date1);
                $customer->where('expenses.exp_date', '<=', $date2);
            }

            $total = $customer->count();
            $customer = $customer->select('customers.*','expenses.amount','expenses.payment_mode','expenses.exp_date')
                ->offset($strt)
                ->limit($length)
                ->get();

            return DataTables::of($customer)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->make(true);
        }

        return view('pages.sale_orders.index_receivable');
    }

    /*
     * Display the specified resource.
     *
     * @param  SaleOrder  $saleorder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $saleorder = SaleOrder::where('id', $id)->first();
        return view('pages.sale_orders.show', [
            'record' => $saleorder,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Create $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        $customers = Customer::where('status', 1)
            ->select(['id', 'customer_name'])
            ->get();

        $products = DB::table('products')
            ->where('status', 1)
            ->get();

        return view('pages.sale_orders.create', [
            'model' => new SaleOrder,
            'customers' => $customers,
            'products' => $products,

        ]);
    }

    /*
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new SaleOrder;
        $model->fill($request->all());
        $date = str_replace("-", "", $request->sale_date);
        $invoice_number = 'TBC' . $request->customer_id . $date;
        $model->user_id = Auth::user()->id;
        $model->invoice_price = floatval(str_replace(',', '', $request->order_total));
        $model->invoice_number = $invoice_number;
        $model->carriage_amount = $request->carriage_amount;
        $model->status = 1;
        DB::beginTransaction();
        try {
            if ($model->save()) {

                $customerReceipts = PaymentHelper::customerSales($model->customer_id);
                if($customerReceipts == false){
                    session()->flash('app_error', 'Something is wrong while saving PurchaseOrder');
                    DB::rollback();
                }

                if (isset($request->p_id) && !empty($request->p_id)) {
                    $pdArr = [];
                    $pQty = 0;
                    foreach ($request->p_id as $key => $pid) {
                        $pdArr[$key]['sale_order_id'] = $model->id;
                        $pdArr[$key]['product_id'] = $request->p_id[$key];
                        $pdArr[$key]['unit_price'] = $request->p_unit_price[$key];
                        $pdArr[$key]['quantity'] = $request->p_unit_qty[$key];
                        $pQty += $request->p_unit_qty[$key];
                    }
                    DB::table('sale_order_details')->insert($pdArr);

                    foreach ($pdArr as $p) {
                        $product = Product::where('id', $p['product_id'])->first();
                        if (!empty($product) && $product != null) {
                            $product->stock_in_hand -= $p['quantity'];
                            $product->save();
                        }
                    }
                    $stockUpdate = GeneralHelper::stockSales($request->order_total, $pQty);
                    if ($stockUpdate == false) {
                        session()->flash('app_error', 'Something is wrong while Updating stock, please contact admin');
                        DB::rollback();
                    }
                }
                DB::commit();
                session()->flash('app_message', 'SaleOrder saved successfully');
                return redirect()->to('sales/index');
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something went wrong, please contact admin!');
            DB::rollback();
        }

        return redirect()->back();
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  SaleOrder  $saleorder
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $saleOrder = SaleOrder::where('id', $id)->first();
        $customers = Customer::where('status', 1)
            ->select(['id', 'customer_name'])
            ->get();
        $customerSelected = Customer::where('id', $saleOrder->customer_id)->first();

        $products = Product::where('deleted', 0)
            ->where('status', 1)
            ->get();
        return view('pages.sale_orders.edit', [
            'model' => $saleOrder,
            'customers' => $customers,
            'customerSelected' => $customerSelected,
            'products' => $products,

        ]);
    }

    /*
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  SaleOrder  $saleorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $model = SaleOrder::where('id', $request->sales_id)->first();
        $model->fill($request->all());
        $model->invoice_price = floatval(str_replace(',', '', $request->order_total));
        if(!isset($model->sale_date)){
            $model->sale_date = $request->sale_date_old;
        }
        $model->carriage_amount = $request->carriage_amount;
        DB::beginTransaction();
        try {
            if ($model->save()) {

                $customerReceipts = PaymentHelper::customerSales($model->customer_id);
                if($customerReceipts == false){
                    session()->flash('app_error', 'Something is wrong while saving PurchaseOrder');
                    DB::rollback();
                }

                if (isset($request->p_id) && !empty($request->p_id)) {
                    $responseData = SaleOrderDetail::where('sale_order_id', $request->sales_id)->get();
                    foreach ($responseData as $res) {
                        DB::delete('delete from sale_order_details where id = ?', [$res->id]);
                        $product = Product::where('id', $res->product_id)->first();
                        if (!empty($product) && $product != null) {
                            $product->stock_in_hand += $res->quantity;
                            $product->save();
                        }
                    }
                    $pdArr = [];
                    foreach ($request->p_id as $key => $pid) {
                        $pdArr[$key]['sale_order_id'] = $model->id;
                        $pdArr[$key]['product_id'] = $request->p_id[$key];
                        $pdArr[$key]['unit_price'] = $request->p_unit_price[$key];
                        $pdArr[$key]['quantity'] = $request->p_unit_qty[$key];
                    }
                    DB::table('sale_order_details')->insert($pdArr);

                    foreach ($pdArr as $p) {
                        $product = Product::where('id', $p['product_id'])->first();
                        if (!empty($product) && $product != null) {
                            $product->stock_in_hand -= $p['quantity'];
                            $product->save();
                        }
                    }

                }
                DB::commit();
                session()->flash('app_message', 'SaleOrder saved successfully');
                return redirect()->to('sales/index');
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something is wrong while saving PurchaseOrder');
            DB::rollback();
        }

        return redirect()->back();
    }

    /*
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  SaleOrder  $saleorder
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $responseData = SaleOrderDetail::where('sale_order_id', $request->id)->get();
        foreach ($responseData as $res) {
            DB::delete('delete from sale_order_details where id = ?', [$res->id]);
        }
        if (SaleOrder::where('id', $request->id)->delete()) {
            session()->flash('app_message', 'SaleOrder successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting SaleOrder');
        }

        return redirect()->to('sales/index');
    }


    public function formReceipt($id)
    {
        $customer = Customer::join('customer_payments', 'customer_payments.customer_id', '=', 'customers.id')
            ->where('customer_payments.diff_amount','>',0)->select('customers.*','customer_payments.diff_amount')->get();

        return view('pages.sale_orders.receiving_form', [
            'model' => new Expense(),
            'selected_customer_id' => $id,
            'customers' => $customer

        ]);

    }

    public function ReceivableStore(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'attachment_file' => 'dimensions:min_width=650,min_height=430'
        ]);

        if($validation->fails()){
            session()->flash('app_error', 'attachment file should min size of 750*500');
            return redirect()->back();
        }

        $model = new Expense();
        $model->fill($request->all());
        if(isset($request->attachment_file) && !empty($request->attachment_file)){
            $photoName = time() . '.' . $request->attachment_file->getClientOriginalExtension();
            $model->attachment_file = $photoName;
            $request->attachment_file->move(public_path('invoices'), $photoName);
        }else{
            $model->attachment_file = '';
        }
        $model->correspondent_id = $request->customer_id;

        DB::beginTransaction();
        try {
            if($model->save()){
                $result = PaymentHelper::customerSalePayment($request->customer_id);
                if($result == true){
                    DB::commit();
                    session()->flash('app_message', 'Receipt saved successfully');
                    return redirect()->to('sales/receivable');
                }
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something went wrong while saving PurchaseOrder');
            DB::rollback();
        }

        return redirect()->back();
    }

    public function fetchCustomer(Request $request)
    {
        $model = Customer::where('id', $request->id)->first();
        return response()->json($model);
    }

    public function fetchProduct(Request $request)
    {
        $model = Product::where('id', $request->id)->first();
        return response()->json($model);
    }

    public function fetchReceivable(Request $request)
    {
        $model = Customer::join('customer_payments', 'customer_payments.customer_id', '=', 'customers.id')
            ->where('customers.status', 1)
            ->where('customers.id', $request->id)
            ->select(['customer_payments.diff_amount as receivable'])
            ->first();
        return response()->json($model);
    }
}
