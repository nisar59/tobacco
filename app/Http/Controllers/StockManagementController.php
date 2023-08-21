<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StockManagement;
use App\Http\Requests\StockManagements\Index;
use App\Http\Requests\StockManagements\Show;
use App\Http\Requests\StockManagements\Create;
use App\Http\Requests\StockManagements\Store;
use App\Http\Requests\StockManagements\Edit;
use App\Http\Requests\StockManagements\Update;
use App\Http\Requests\StockManagements\Destroy;
use Yajra\DataTables\DataTables;

/**
 * Description of StockManagementController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class StockManagementController extends Controller
{
      
    /*
     * Display a listing of the resource.
     *
     * @param  Request  $requestuest
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $strt = $request->start;
            $length = $request->length;

            $model = StockManagement::where('opening_stock', '>=' ,0);

            if ($request->report_date != null) {
                $string = explode('-',$request->report_date);
                $date1 = date('Y-m-d',strtotime($string[0]));
                $date2 = date('Y-m-d',strtotime($string[1]));

                $model->where('report_date', '>=' , $date1);
                $model->where('report_date', '<=' ,$date2);
            }

            $total = $model->count();
            $model = $model->select('stock_managements.*')->offset($strt)->limit($length)->get();

            return DataTables::of($model)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    return '';
                })
                ->editColumn('report_date', function ($row) {
                    return $row->report_date;
                })
                ->editColumn('opening_stock', function ($row) {
                    return $row->opening_stock;
                })
                ->editColumn('purchase', function ($row) {
                    return $row->purchase;
                })
                ->editColumn('purchase_return', function ($row) {
                    return $row->purchase_return;
                })
                ->editColumn('sale', function ($row) {
                    return $row->sale;
                })
                ->editColumn('sale_return', function ($row) {
                    return $row->sale_return;
                })
                ->editColumn('closing_stock', function ($row) {
                    return $row->closing_stock;
                })
                ->rawColumns(['action', 'id'])
                ->make(true);
        }

        $productType  = Configuration::where('list_name','product_type')
            ->select(['lable','value'])
            ->where('status',1)
            ->where('deleted',0)
            ->get();
        $manufacturer = Configuration::where('list_name','manufacturer')
            ->select(['lable','value'])
            ->where('status',1)
            ->where('deleted',0)
            ->get();
        $flavour = Configuration::where('list_name','flavour')
            ->select(['lable','value'])
            ->where('status',1)
            ->where('deleted',0)
            ->get();
        $packing = Configuration::where('list_name','packing')
            ->select(['lable','value'])
            ->where('status',1)
            ->where('deleted',0)
            ->get();
        return view('pages.stock_managements.index', 
            [
                'products' => $productType,
                'manufacturers' => $manufacturer,
                'flavours' => $flavour,
                'packings' => $packing
            ]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $requestuest
     * @param  StockManagement  $stockmanagement
     * @return \Illuminate\Http\Response
     */
    public function show(Show $requestuest, StockManagement $stockmanagement)
    {
        return view('pages.stock_managements.show', [
                'record' =>$stockmanagement,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $requestuest
     * @return \Illuminate\Http\Response
     */
    public function create(Create $requestuest)
    {

        return view('pages.stock_managements.create', [
            'model' => new StockManagement,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $requestuest
     * @return \Illuminate\Http\Response
     */
    public function store(Store $requestuest)
    {
        $model=new StockManagement;
        $model->fill($requestuest->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'StockManagement saved successfully');
            return redirect()->route('stock_managements.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving StockManagement');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $requestuest
     * @param  StockManagement  $stockmanagement
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $requestuest, StockManagement $stockmanagement)
    {

        return view('pages.stock_managements.edit', [
            'model' => $stockmanagement,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $requestuest
     * @param  StockManagement  $stockmanagement
     * @return \Illuminate\Http\Response
     */
    public function update(Update $requestuest,StockManagement $stockmanagement)
    {
        $stockmanagement->fill($requestuest->all());

        if ($stockmanagement->save()) {
            
            session()->flash('app_message', 'StockManagement successfully updated');
            return redirect()->route('stock_managements.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating StockManagement');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $requestuest
     * @param  StockManagement  $stockmanagement
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $requestuest, StockManagement $stockmanagement)
    {
        if ($stockmanagement->delete()) {
                session()->flash('app_message', 'StockManagement successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting StockManagement');
            }

        return redirect()->back();
    }
}
