<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Products\Index;
use App\Http\Requests\Products\Show;
use App\Http\Requests\Products\Create;
use App\Http\Requests\Products\Store;
use App\Http\Requests\Products\Edit;
use App\Http\Requests\Products\Update;
use App\Http\Requests\Products\Destroy;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


/**
 * Description of ProductController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class ProductController extends Controller
{
    /*
     * Display a listing of the resource.
     * @param  Request  $req
     * @return \Illuminate\Http\Response
     */

    public function index(Request $req)
    {
        $productType  = Configuration::where('list_name','product_type')
            ->select(['lable','value'])
            ->where('deleted',0)
            ->get();
        $manufacturer = Configuration::where('list_name','manufacturer')
            ->select(['lable','value'])
            ->where('deleted',0)
            ->get();
        $flavour = Configuration::where('list_name','flavour')
            ->select(['lable','value'])
            ->where('deleted',0)
            ->get();
        $packing = Configuration::where('list_name','packing')
            ->select(['lable','value'])
            ->where('deleted',0)
            ->get();

        if ($req->ajax()) {

            $strt = $req->start;
            $length = $req->length;

            $product = Product::where('deleted', 0);

            if ($req->name != null) {
                $product->where('name', $req->name);
            }
            if ($req->manufacturer != null) {
                $product->where('manufacturer', $req->manufacturer);
            }
            if ($req->flavour != null) {
                $product->where('flavour', $req->flavour);
            }
            if ($req->packing != null) {
                $product->where('packing', $req->packing);
            }

            $total = $product->count();
            $product = $product->select('products.*')->offset($strt)->limit($length)->orderBy('id', 'DESC')->get();

            return DataTables::of($product)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    if ($row->status == 1) {
                        $icon = '<i class="text-danger fa fa-remove"></i>';
                    } else {
                        $icon = '<i class="text-success fa fa-check"></i>';
                    }
                    return '
                    <div class="btn-group btn-group-xs">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Update Product" href="' . url('/product/edit/' . $row->id) . '" class="btn btn-default" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-edit"></i>
                        </a>
                       
                        <form data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status" onsubmit="return confirm(\'Are you sure you want to update status?\')"
                          action="' . url('/product/destroy/' . $row->id) . '"
                          method="post"
                          style="display: inline">
                         '.csrf_field().'
                          '.method_field('POST').'
                        <button type="submit" class="btn btn-secondary cursor-pointer">
                             '.$icon.'
                        </button>
                    </form>
                    </div>
                 ';
                })
                ->editColumn('uuid', function ($row) {
                    return $row->uuid;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('manufacturer', function ($row) {
                    return $row->manufacturer;
                })
                ->editColumn('flavour', function ($row) {
                    return $row->flavour;
                })
                ->editColumn('packing', function ($row) {
                    return $row->packing;
                })
                ->editColumn('stock_in_hand', function ($row) {
                    return $row->stock_in_hand;
                })
                ->editColumn('min_stock_level', function ($row) {
                    return $row->min_stock_level;
                })
                ->editColumn('status', function ($row) {
                    return $row->status;
                })
                ->rawColumns(['action', 'id'])
                ->make(true);
        }
        return view('pages.products.index',
            [
                'products' => $productType,
                'manufacturers' => $manufacturer,
                'flavours' => $flavour,
                'packings' => $packing
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Product $product)
    {
        return view('pages.products.show', [
                'record' =>$product
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        $product  = Configuration::where('list_name','product_type')
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

        return view('pages.products.create', [
            'model' => new Product,
            'products' => $product,
            'manufacturers' => $manufacturer,
            'flavours' => $flavour,
            'packings' => $packing

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new Product;
        $model->fill($request->all());

        if ($model->save()) {
            if(isset($request->barcode) && !empty($request->barcode[0])){
                foreach ($request->barcode as $barcode){
                    $newBarcode = new Barcode();
                    $newBarcode->product_id = $model->id;
                    $newBarcode->barcode = $barcode;
                    $newBarcode->save();
                }
            }
            session()->flash('app_message', 'Product saved successfully');
            return redirect()->to('product/index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Product');
            }
        return redirect()->back();
    } /*
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product  = Configuration::where('list_name','product_type')
            ->select(['lable','value'])
            ->get();
        $manufacturer = Configuration::where('list_name','manufacturer')
            ->select(['lable','value'])
            ->get();
        $flavour = Configuration::where('list_name','flavour')
            ->select(['lable','value'])
            ->get();
        $packing = Configuration::where('list_name','packing')
            ->select(['lable','value'])
            ->get();

        $exBarCodes = Barcode::where('product_id',$id)->get();
        $model = Product::find($id);
        return view('pages.products.edit', [
            'model' => $model,
            'products' => $product,
            'manufacturers' => $manufacturer,
            'flavours' => $flavour,
            'packings' => $packing,
            'exBarCodes' => $exBarCodes

            ]);
    }
    /*
     * Update a existing resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $model = Product::find($request->id);
        $model->fill($request->all());
        if ($model->save()) {
            $exBarCodes = Barcode::where('product_id',$model->id)->get();
            if(!empty($exBarCodes) && $exBarCodes!=null){
                foreach ($exBarCodes as $data){
                    DB::table('barcodes')->delete($data->id);
                }
            }

            if(isset($request->barcode_old) && !empty($request->barcode_old)){
                foreach ($request->barcode_old as $barcode){
                    $newBarcode = new Barcode();
                    $newBarcode->product_id = $model->id;
                    $newBarcode->barcode = $barcode;
                    $newBarcode->save();
                }
            }

            if(isset($request->barcode) && !empty($request->barcode[0])){
                foreach ($request->barcode as $barcode){
                    $newBarcode = new Barcode();
                    $newBarcode->product_id = $model->id;
                    $newBarcode->barcode = $barcode;
                    $newBarcode->save();
                }
            }
            session()->flash('app_message', 'Product successfully updated');
            return redirect()->to('product/index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Product');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if($product->status == 0){
            $productStatus = 1;
        }else{
            if($product->stock_in_hand >0){
                session()->flash('app_error', 'Product have available Stock '.$product->stock_in_hand.', unable to proceed this action!');
                return redirect()->back();
            }else{
                $productStatus = 0;
            }
        }
        $product->status = $productStatus;
        if ($product->save()) {
                session()->flash('app_message', 'Product status successfully updated');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Product');
            }

        return redirect()->back();
    }
}
