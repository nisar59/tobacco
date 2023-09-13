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
class PurchaseReturnController extends Controller
{
    /*
     * Display a listing of the resource.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $record = PurchaseOrder::where('id', $id)->first();
        $modelDetails = PurchaseOrderDetail::where('purchase_order_id', $record->id)->get();
        $supplier = Supplier::where('id', $record->supplier_id)->first();

        return view('pages.purchase_orders.returns',
            [
                'record' => $record,
                'modelDetails' => $modelDetails,
                'supplier' => $supplier,
            ]);
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

    /*
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = PurchaseOrderDetail::where('id', $request->purchase_id)->first();

        $model->return_qty += $request->purchase_return_qty;
        DB::beginTransaction();
        try {
            if ($model->save()) {
                $product = Product::where('id',$model->product_id)->first();
                if(isset($product) && !empty($product)){
                    $product->stock_in_hand -= $request->purchase_return_qty;
                    $product->save();
                }
                DB::commit();
                session()->flash('app_message', 'Purchase return saved successfully');
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something went wrong, please contact admin!');
            DB::rollback();
        }

        return redirect()->back();
    }
}
