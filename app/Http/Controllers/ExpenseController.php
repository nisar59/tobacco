<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Http\Requests\Expenses\Index;
use App\Http\Requests\Expenses\Show;
use App\Http\Requests\Expenses\Create;
use App\Http\Requests\Expenses\Store;
use App\Http\Requests\Expenses\Edit;
use App\Http\Requests\Expenses\Update;
use App\Http\Requests\Expenses\Destroy;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

/**
 * Description of ExpenseController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class ExpenseController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @param  Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $expenseType = Configuration::where('list_name', 'expenses_type')
            ->select(['lable', 'value'])
            ->where('status', 1)
            ->where('deleted', 0)
            ->get();

        if ($req->ajax()) {

            $strt = $req->start;
            $length = $req->length;

            $expense = Expense::whereIn('deleted', [1, 0])
                ->whereNotIn('type', ['cash_input']);

            if ($req->type != null) {
                $expense->where('type', $req->type);
            }
            if ($req->exp_date != null) {
                $string = explode('-', $req->exp_date);
                $date1 = date('Y-m-d', strtotime($string[0]));
                $date2 = date('Y-m-d', strtotime($string[1]));

                $expense->where('exp_date', '>=', $date1);
                $expense->where('exp_date', '<=', $date2);
            }
            if ($req->payment_mode != null) {
                $expense->where('payment_mode', $req->payment_mode);
            }

            $total = $expense->count();
            $expense = $expense->select('expenses.*')->offset($strt)->limit($length)->orderBy('exp_date','DESC')->get();

            return DataTables::of($expense)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    if ($row->deleted == 0) {
                        $icon = '<i class="text-danger fa fa-remove"></i>';
                    } else {
                        $icon = '<i class="text-success fa fa-check"></i>';
                    }

                    return '
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/expense/edit/' . $row->id) . '" class="btn btn-default" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-edit"></i>
                        </a>
                       
                        <form data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status" onsubmit="return confirm(\'Are you sure you want to delete?\')"
                          action="' . url('/expense/destroy/' . $row->id) . '"
                          method="post"
                          style="display: inline">
                         ' . csrf_field() . '
                          ' . method_field('POST') . '
                            <button type="submit" class="btn btn-secondary cursor-pointer">
                                 '.$icon.'
                            </button>
                        </form>
                        <a href="' . url('/expense/show/' . $row->id) . '" class="btn btn-default" style="
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
                 ';
                })
                ->editColumn('type', function ($row) {
                    return $row->type;
                })
                ->editColumn('exp_date', function ($row) {
                    return $row->exp_date;
                })
                ->editColumn('payment_mode', function ($row) {
                    return $row->payment_mode;
                })
                ->editColumn('amount', function ($row) {
                    return $row->amount;
                })
                ->rawColumns(['action', 'id'])
                ->make(true);
        }

        return view('pages.expenses.index', ['expenseType' => $expenseType]);
    }

    public function cash(Request $req)
    {
        if ($req->ajax()) {

            $strt = $req->start;
            $length = $req->length;

            $expense = Expense::whereIn('deleted', [1, 0]);
            $expense->where('type', 'cash_input');

            if ($req->exp_date != null) {
                $string = explode('-', $req->exp_date);
                $date1 = date('Y-m-d', strtotime($string[0]));
                $date2 = date('Y-m-d', strtotime($string[1]));

                $expense->where('exp_date', '>=', $date1);
                $expense->where('exp_date', '<=', $date2);
            }
            if ($req->payment_mode != null) {
                $expense->where('payment_mode', $req->payment_mode);
            }

            $total = $expense->count();
            $expense = $expense->select('expenses.*')->offset($strt)->limit($length)->orderBy('exp_date','DESC')->get();

            return DataTables::of($expense)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    if ($row->deleted == 0) {
                        $icon = '<i class="text-danger fa fa-remove"></i>';
                    } else {
                        $icon = '<i class="text-success fa fa-check"></i>';
                    }

                    return '
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/cash/edit/' . $row->id) . '" class="btn btn-default" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-edit"></i>
                        </a>
                       
                        <form data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status" onsubmit="return confirm(\'Are you sure you want to delete?\')"
                          action="' . url('/cash/destroy/' . $row->id) . '"
                          method="post"
                          style="display: inline">
                         ' . csrf_field() . '
                          ' . method_field('POST') . '
                            <button type="submit" class="btn btn-secondary cursor-pointer">
                                 '.$icon.'
                            </button>
                        </form>
                        <a href="' . url('/cash/show/' . $row->id) . '" class="btn btn-default" style="
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
                 ';
                })
                ->editColumn('exp_date', function ($row) {
                    return $row->exp_date;
                })
                ->editColumn('payment_mode', function ($row) {
                    return $row->payment_mode;
                })
                ->editColumn('amount', function ($row) {
                    return $row->amount;
                })
                ->rawColumns(['action', 'id'])
                ->make(true);
        }

        return view('pages.expenses.cash_index');
    }
    /*
     * Display the specified resource.
     *
     * @param  Show $request
     * @param  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        return view('pages.expenses.show', [
            'record' => $expense,
        ]);

    }

    public function cashShow($id)
    {
        $expense = Expense::find($id);
        return view('pages.expenses.cash_show', [
            'record' => $expense,
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
        $expenseType = Configuration::where('list_name', 'expenses_type')
            ->select(['lable', 'value'])
            ->where('status', 1)
            ->where('deleted', 0)
            ->get();
        return view('pages.expenses.create', [
            'model' => new Expense,
            'expenseType' => $expenseType

        ]);
    }

    public function cashCreate(Create $request)
    {
        return view('pages.expenses.cash_create', [
            'model' => new Expense

        ]);
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'attachment_file' => 'dimensions:min_width=650,min_height=430'
        ]);

        if($validation->fails()){
            session()->flash('app_error', 'attachment file should min size of 750*500');
            return redirect()->back();
        }

        $model = new Expense;
        $model->fill($request->all());
        if(isset($request->attachment_file) && !empty($request->attachment_file)){
            $photoName = time() . '.' . $request->attachment_file->getClientOriginalExtension();
            $model->attachment_file = $photoName;
            $request->attachment_file->move(public_path('invoices'), $photoName);
        }else{
            $model->attachment_file = '';
        }
        if ($model->save()) {

            if($request->type == 'cash_input'){
                session()->flash('app_message', 'Cash Input saved successfully');
                return redirect()->to('cash/index');
            }else{
                session()->flash('app_message', 'Expense saved successfully');
                return redirect()->to('expense/index');
            }
        } else {
            session()->flash('app_message', 'Something is wrong while saving Data');
        }
        return redirect()->back();
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expenseType = Configuration::where('list_name', 'expenses_type')
            ->select(['lable', 'value'])
            ->where('status', 1)
            ->where('deleted', 0)
            ->get();
        $expense = Expense::find($id);
        return view('pages.expenses.edit', [
            'model' => $expense,
            'expenseType' => $expenseType
        ]);
    }

    public function cashEdit($id)
    {
        $expense = Expense::find($id);
        return view('pages.expenses.cash_edit', [
            'model' => $expense
        ]);
    }

    /*
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'attachment_file' => 'dimensions:min_width=650,min_height=430'
        ]);

        if($validation->fails()){
            session()->flash('app_error', 'attachment file should min size of 750*500');
            return redirect()->back();
        }

        $model = Expense::find($request->id);
        $model->fill($request->all());

        if (isset($request->attachment_file) && !empty($request->attachment_file)) {
            $photoName = time() . '.' . $request->attachment_file->getClientOriginalExtension();
            $model->attachment_file = $photoName;
            $request->attachment_file->move(public_path('invoices'), $photoName);
        }

        if ($model->save()) {

            if($request->type == 'cash_input'){
                session()->flash('app_message', 'Cash Input successfully updated');
                return redirect()->to('cash/index');
            }else{
                session()->flash('app_message', 'Expense successfully updated');
                return redirect()->to('expense/index');
            }
        } else {
            session()->flash('app_error', 'Something is wrong while updating Data');
        }
        return redirect()->back();
    }

    /*
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if($expense->deleted == 0){
            $expenseDelete= 1;
        }else{
            $expenseDelete = 0;
        }

        $expense->deleted = $expenseDelete;
        if ($expense->save()) {
            session()->flash('app_message', 'Expense Status successfully Updated');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Expense');
        }

        return redirect()->back();
    }

    public function cashDestroy($id)
    {
        $expense = Expense::find($id);
        if($expense->deleted == 0){
            $expenseDelete= 1;
        }else{
            $expenseDelete = 0;
        }

        $expense->deleted = $expenseDelete;
        if ($expense->save()) {
            session()->flash('app_message', 'Expense Status successfully Updated');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Expense');
        }

        return redirect()->back();
    }
}
