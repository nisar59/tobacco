<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Customer;
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
    public function index($id)
    {
        $record       = SaleOrder::where('id', $id)->where('status', 1)->where('deleted', 0)->first();
        $modelDetails = SaleOrderDetail::where('sale_order_id', $id)->where('deleted', 0)->get();
        $customer     = Customer::where('id',$record->customer_id)->first();

        return view('pages.sale_orders.returns',
            [
                'record'=>$record,
                'modelDetails'=>$modelDetails,
                'customer'=>$customer,

            ]);
    }


    public function show($id)
    {
        $saleorder = SaleOrder::where('id',$id)->first();
        return view('pages.sale_orders.show', [
                'record' =>$saleorder,
        ]);

    }

    /*
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = SaleOrderDetail::where('id', $request->sales_id)->first();

        $model->return_qty += $request->sale_return_qty;
        DB::beginTransaction();
        try {
            if ($model->save()) {
                $product = Product::where('id',$model->product_id)->first();
                if(isset($product) && !empty($product)){
                    $product->stock_in_hand += $request->sale_return_qty;
                    $product->save();
                }
                DB::commit();
                session()->flash('app_message', 'Sale return saved successfully');
            }

        } catch (\Exception $e) {
            session()->flash('app_error', 'Something went wrong, please contact admin!');
            DB::rollback();
        }

        return redirect()->back();
    }

}
