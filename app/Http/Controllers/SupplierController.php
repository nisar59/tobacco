<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Http\Requests\Suppliers\Index;
use App\Http\Requests\Suppliers\Show;
use App\Http\Requests\Suppliers\Create;
use App\Http\Requests\Suppliers\Store;
use App\Http\Requests\Suppliers\Edit;
use App\Http\Requests\Suppliers\Update;
use App\Http\Requests\Suppliers\Destroy;
use Yajra\DataTables\DataTables;

/**
 * Description of SupplierController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class SupplierController extends Controller
{
    /*
   * Display a listing of the resource.
   * @param  Request  $req
   * @return \Illuminate\Http\Response
   */
    public function index(Request $req)
    {
        if ($req->ajax()) {

            $strt = $req->start;
            $length = $req->length;

            $supplier = Supplier::whereIn('status', [1, 0]);

            if ($req->supplier_name != null) {
                $supplier->where('supplier_name', $req->supplier_name);
            }
            if ($req->contact_number != null) {
                $supplier->where('contact_number', $req->contact_number);
            }

            $total = $supplier->count();
            $supplier = $supplier->select('suppliers.*')->offset($strt)->limit($length)->get();

            return DataTables::of($supplier)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    $purchasesCount = PurchaseOrder::where('supplier_id',$row->id)->count();
                    if ($row->status == 1) {
                        $icon = '<i class="text-danger fa fa-remove"></i>';
                    } else {
                        $icon = '<i class="text-success fa fa-check"></i>';
                    }

                    if($purchasesCount>0){
                        $display = 'block';
                    }else{
                        $display = 'none';
                    }
                    return '
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/supplier/edit/' . $row->id) . '" class="btn btn-default" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-edit"></i>
                        </a>
                       
                        <form onsubmit="return confirm(\'Are you sure you want to Update Status?\')"
                              action="' . url('/supplier/destroy/' . $row->id) . '"
                              method="post"
                              style="display: inline">
                             ' . csrf_field() . '
                              ' . method_field('POST') . '
                            <button type="submit" class="btn btn-secondary cursor-pointer">
                                 '.$icon.'
                            </button>
                        </form>
                        <a href="' . url('/supplier/show/' . $row->id) . '" class="btn btn-default" style="
                                    display:'.$display.';
                                    height: 36px;
                                    width: 36px;
                                    text-align: center;
                                    padding: 8px;
                                    background-color: white;
                                    color: red;
                                    margin-right: 5px;">
                            <i class="fa fa-book"></i>
                        </a>
                    </div>
                 ';
                })
                ->editColumn('supplier_name', function ($row) {
                    return $row->supplier_name;
                })
                ->editColumn('address', function ($row) {
                    return $row->address;
                })
                ->editColumn('contact_number', function ($row) {
                    return $row->contact_number;
                })
                ->editColumn('email_id', function ($row) {
                    return $row->email_id;
                })
                ->editColumn('status', function ($row) {
                    return $row->status;
                })
                ->rawColumns(['action', 'id'])
                ->make(true);
        }
        return view('pages.suppliers.index');
    }

    /*
     * Display the specified resource.
     *
     * @param  Show $request
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req,$id)
    {
        $supplier = Supplier::find($id);

        if ($req->ajax()) {
            $purchases = GeneralHelper::getSupplierLedger($id,$date1=0,$date2=0);

            if (isset($_GET['purchase_date']) && !empty($_GET['purchase_date'])) {
                $string = explode('-', $_GET['purchase_date']);
                $purchases = GeneralHelper::getSupplierLedger($id,date('Y-m-d', strtotime($string[0])),date('Y-m-d', strtotime($string[1])));
            }

            return DataTables::of($purchases)
                ->rawColumns(['action', 'id'])
                ->make(true);
        }

        return view('pages.suppliers.show', [
            'record' => $supplier
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
        return view('pages.suppliers.create', [
            'model' => new Supplier,

        ]);
    }

    /*
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Supplier;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Supplier saved successfully');
            return redirect()->to('supplier/index');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Supplier');
        }
        return redirect()->back();
    }

    /*
     * Show the form for editing the specified resource.
     * @param  Request $request
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Supplier::find($id);
        return view('pages.suppliers.edit', [
            'model' => $model,

        ]);
    }

    /*
     * Update a existing resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $model = Supplier::find($request->id);
        $model->fill($request->all());
        if ($model->save()) {
            session()->flash('app_message', 'Supplier successfully updated');
            return redirect()->to('supplier/index');
        } else {
            session()->flash('app_error', 'Something is wrong while updating Supplier');
        }
        return redirect()->back();
    }

    /*
     * Delete a  resource from  storage.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if($supplier->status == 0){
            $status = 1;
        }else{
            $status = 0;
        }
        $supplier->status = $status;
        if ($supplier->save()) {
            session()->flash('app_message', 'Supplier Status successfully Updated');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Supplier');
        }

        return redirect()->back();
    }
}
