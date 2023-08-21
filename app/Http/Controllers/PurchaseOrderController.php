<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Product;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
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
class PurchaseOrderController extends Controller
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

            $model = PurchaseOrder::whereIn('status', [0,1]);

            if ($req->supplier_id != null) {
                $model->where('supplier_id', $req->supplier_id);
            }
            if ($req->invoice_number != null) {
                $model->where('invoice_number', $req->invoice_number);
            }
            if ($req->purchase_date != null) {
                $string = explode('-', $req->purchase_date);
                $date1 = date('Y-m-d', strtotime($string[0]));
                $date2 = date('Y-m-d', strtotime($string[1]));

                $model->where('order_date', '>=', $date1);
                $model->where('order_date', '<=', $date2);
            }

            $total = $model->count();
            $model = $model->select('purchase_orders.*')->offset($strt)->limit($length)->get();

            return DataTables::of($model)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/purchase/edit/' . $row->id) . '" class="btn btn-default" style="
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
                        <a href="' . url('/purchase/show/' . $row->id) . '" class="btn btn-default" style="
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
                    <div style="display: none" class="btn-group btn-group-xs">
                        <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update status" href="' . url('/purchase/status/update/' . $row->id.'/'.$row->status) . '" class="btn btn-default" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-paper-plane"></i>
                        </a>
                    </div>
                    <div style="display: none" class="btn-group btn-group-xs">
                        <button data-toggle="modal" data-target="#edit-modal" data-id="'.$row->id.'" data-bs-placement="bottom" title="Purchase Return" class="btn btn-warning btn-detail open_modal" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-undo"></i>
                        </button>
                    </div>
                 ';
                })
                ->editColumn('supplier_id', function ($row) {
                    return $row->supplier_id;
                })
                ->editColumn('order_date', function ($row) {
                    return $row->order_date;
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

        $suppliers = Supplier::where('status', 1)
            ->select(['id', 'supplier_name'])
            ->get();

        return view('pages.purchase_orders.index', ['suppliers' => $suppliers]);
    }

    /*
     * Display the specified resource.
     *
     * @param  PurchaseOrder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::where('id', $id)->first();
        return view('pages.purchase_orders.show', [
            'record' => $purchaseOrder,
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
        $supplier = Supplier::where('status', 1)
            ->select(['id', 'supplier_name'])
            ->get();

        $products = Product::where('deleted', 0)
            ->where('status', 1)
            ->get();

        return view('pages.purchase_orders.create', [
            'model' => new PurchaseOrder,
            'suppliers' => $supplier,
            'products' => $products,

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
        $model = new PurchaseOrder;
        $model->fill($request->all());

//        $validation = Validator::make($request->all(), [
//            'image' => 'dimensions:min_width=100,min_height=100'
//        ]);
//
//        if($validation->fails()){
//            session()->flash('app_error', 'Image should min size of 750*500');
//            return redirect()->back();
//        }

        if(isset($request->image) && !empty($request->image)){
            $photoName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('invoices'), $photoName);
            $model->image = $photoName;
        }else{
            $model->image = '';
        }

        $model->user_id = Auth::user()->id;
        $model->invoice_price = (int)str_replace( ',', '', $request->order_total );
        $model->status = 1;

        DB::beginTransaction();
        try {
            if ($model->save()) {
                if (isset($request->p_id) && !empty($request->p_id)) {
                    $pdArr = [];
                    foreach ($request->p_id as $key => $pid) {
                        $pdArr[$key]['purchase_order_id'] = $model->id;
                        $pdArr[$key]['product_id'] = $request->p_id[$key];
                        $pdArr[$key]['unit_price'] = $request->p_unit_price[$key];
                        $pdArr[$key]['quantity'] = $request->p_unit_qty[$key];
                    }
                    DB::table('purchase_order_details')->insert($pdArr);
                }


                foreach ($pdArr as $p) {
                    $product = Product::where('id', $p['product_id'])->first();
                    if (!empty($product) && $product != null) {
                        $product->stock_in_hand += $p['quantity'];
                        $product->unit_price    = $p['unit_price'];
                        $product->save();
                    }
                }

                DB::commit();
                session()->flash('app_message', 'PurchaseOrder saved successfully');
                return redirect()->to('purchase/index');
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something is wrong while saving PurchaseOrder');
            DB::rollback();
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit $request
     * @param  PurchaseOrder $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::where('id', $id)->first();
        $supplier = Supplier::where('status', 1)
            ->select(['id', 'supplier_name'])
            ->get();
        $supplierSelected = Supplier::where('id', $purchaseOrder->supplier_id)->first();

        $products = Product::where('deleted', 0)
            ->where('status', 1)
            ->get();
        return view('pages.purchase_orders.edit', [
            'model' => $purchaseOrder,
            'suppliers' => $supplier,
            'supplierSelected' => $supplierSelected,
            'products' => $products,
        ]);
    }

    /*
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
//        $validation = Validator::make($request->all(), [
//            'image' => 'dimensions:min_width=550,min_height=750'
//        ]);
//
//        if($validation->fails()){
//            session()->flash('app_error', 'Image should min size of 750*500');
//            return redirect()->back();
//        }

        $model = PurchaseOrder::where('id', $request->purchase_id)->first();
        $model->fill($request->all());

        if (isset($request->image) && !empty($request->image)) {
            $photoName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('invoices'), $photoName);
            $model->image = $photoName;
        }

        $model->order_date = $request->order_date_old;
        $model->user_id = Auth::user()->id;
        $model->invoice_price = (int)str_replace( ',', '', $request->order_total );

        DB::beginTransaction();
        try {
            $stockUpdate = GeneralHelper::stockPurchases($request->purchase_id);
            if($stockUpdate){
                if ($model->save()) {
                    if (isset($request->p_id) && !empty($request->p_id)) {
                        $responseData = PurchaseOrderDetail::where('purchase_order_id', $request->purchase_id)->get();
                        foreach ($responseData as $res) {
                            DB::delete('delete from purchase_order_details where id = ?',[$res->id]);
                            $product = Product::where('id',$res->product_id)->first();
                            if(!empty($product) && $product!=null){
                                $product->stock_in_hand -= $res->quantity;
                                $product->save();
                            }
                        }
                        $pdArr = [];
                        foreach ($request->p_id as $key => $pid) {
                            $pdArr[$key]['purchase_order_id'] = $model->id;
                            $pdArr[$key]['product_id'] = $request->p_id[$key];
                            $pdArr[$key]['unit_price'] = $request->p_unit_price[$key];
                            $pdArr[$key]['quantity'] = $request->p_unit_qty[$key];
                        }
                        DB::table('purchase_order_details')->insert($pdArr);

                        foreach ($pdArr as $p) {
                            $product = Product::where('id', $p['product_id'])->first();
                            if (!empty($product) && $product != null) {
                                $product->unit_price    = $p['unit_price'];
                                $product->stock_in_hand += $p['quantity'];
                                $product->save();
                            }
                        }
                    }
                    DB::commit();
                    session()->flash('app_message', 'PurchaseOrder Updated successfully');
                    return redirect()->to('purchase/index');
                }
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
     * @param  Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $responseData = PurchaseOrderDetail::where('purchase_order_id', $request->id)->get();
        foreach ($responseData as $res) {
            DB::delete('delete from purchase_order_details where id = ?',[$res->id]);
        }
        if (PurchaseOrder::where('id',$request->id)->delete()) {
            session()->flash('app_message', 'PurchaseOrder successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting PurchaseOrder');
        }

        return redirect()->to('purchase/index');
    }

    public function fetchSupplier(Request $request)
    {
        $model = Supplier::where('id', $request->id)->first();
        return response()->json($model);
    }

    public function fetchProduct(Request $request)
    {
        $model = Product::where('id', $request->id)->first();
        return response()->json($model);
    }

    public function updateStatus($id,$status){
        $status = ($status == 1)?0:1;
        DB::beginTransaction();
        try {
            if($status == 1){
                $stockUpdate = GeneralHelper::stockPurchases($id);
                if($stockUpdate){
                    DB::table('purchase_orders')
                        ->where('id', $id)
                        ->update(['status' => $status]);
                }
            }else{
                $stockUpdate = GeneralHelper::stockPurchasesReverse($id);
                if($stockUpdate){
                    DB::table('purchase_orders')
                        ->where('id', $id)
                        ->update(['status' => $status]);
                }
            }
            DB::commit();
            session()->flash('app_message', 'PurchaseOrder Updated successfully');
        } catch (\Exception $e) {
            session()->flash('app_error', 'Something is wrong while saving PurchaseOrder');
            DB::rollback();
        }
        return redirect()->back();
    }

    public function getReturnOrder($id){
        $responseData = PurchaseOrderDetail::where('purchase_order_id', $id)->first();

        return json_encode($responseData);
    }
}
