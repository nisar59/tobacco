<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\Customers\Create;
use Yajra\DataTables\DataTables;
use Throwable;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Description of CustomerController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class CustomerController extends Controller
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

            $customer = Customer::join('customer_payments', 'customer_payments.customer_id', '=', 'customers.id')
                ->whereIn('customers.status', [1, 0]);

            if ($req->customer_name != null) {
                $customer->where('customers.customer_name', $req->customer_name);
            }
            if ($req->contact_number != null) {
                $customer->where('customers.contact_number', $req->contact_number);
            }

            $total = $customer->count();
            $customer = $customer->select('customers.*','customer_payments.diff_amount as receivable')->offset($strt)->limit($length)->get();

            return DataTables::of($customer)
                ->setOffset($strt)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])
                ->addColumn('action', function ($row) {
                    $sales = SaleOrder::where('customer_id', $row->id)->count();
                    if ($row->status == 1) {
                        $icon = '<i class="text-danger fa fa-remove"></i>';
                    } else {
                        $icon = '<i class="text-success fa fa-check"></i>';
                    }

                    if ($sales > 0) {
                        $display = 'block';
                    } else {
                        $display = 'none';
                    }

                    return '
                    <div class="btn-group btn-group-xs">
                        <a href="' . url('/customer/edit/' . $row->id) . '" class="btn btn-default" style="
                                height: 36px;
                                width: 36px;
                                text-align: center;
                                padding: 8px;
                                background-color: white;
                                color: red;
                                margin-right: 5px;">
                        <i class="fa fa-edit"></i>
                        </a>
                       
                        <form onsubmit="return confirm(\'Are you sure you want to update status?\')"
                              action="' . url('/customer/destroy/' . $row->id) . '"
                              method="post"
                              style="display: inline">
                             ' . csrf_field() . '
                              ' . method_field('POST') . '
                            <button type="submit" class="btn btn-secondary cursor-pointer">
                                ' . $icon . '
                            </button>
                        </form>
                        <a href="' . url('/customer/show/' . $row->id) . '" class="btn btn-default" style="
                                display:' . $display . ';
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
                ->editColumn('customer_name', function ($row) {
                    return $row->customer_name;
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
        return view('pages.customers.index');
    }

    /*
     * Display the specified resource.
     *
     * @param  Show $request
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $id)
    {
        $customer = Customer::join('customer_payments', 'customer_payments.customer_id', '=', 'customers.id')
            ->where('customers.status', 1)
            ->where('customers.id', $id)
            ->select(['customers.*', 'customer_payments.diff_amount as receivable_amount'])
            ->first();

        if ($req->ajax()) {
            $purchases = GeneralHelper::getCustomerLedger($id, $date1 = 0, $date2 = 0);

            if (isset($_GET['sale_date']) && !empty($_GET['sale_date'])) {
                $string = explode('-', $_GET['sale_date']);
                $purchases = GeneralHelper::getCustomerLedger($id, date('Y-m-d', strtotime($string[0])), date('Y-m-d', strtotime($string[1])));
            }

            return DataTables::of($purchases)
                ->rawColumns(['action', 'id'])
                ->make(true);
        }

        $sales = SaleOrder::where('customer_id', $id);

        return view('pages.customers.show', [
            'record' => $customer,
            'sales' => $sales,
        ]);

    }

    public function exportLedger(Request $req)
    {
        try {
            if (isset($_GET['sale_date']) && !empty($_GET['sale_date'])) {
                $string = explode('-', $_GET['sale_date']);
                $purchases = GeneralHelper::getCustomerLedger($req->id, date('Y-m-d', strtotime($string[0])), date('Y-m-d', strtotime($string[1])));
            } else {
                $purchases = GeneralHelper::getCustomerLedger($req->id, $date1 = 0, $date2 = 0);
            }

            // share data to view
            view()->share('pages.customers.ledger', $purchases);
            $pdf = PDF::loadView('pages.customers.ledger', array('purchases' => $purchases));
            // download PDF file with download method
            return $pdf->download('customer_ledger.pdf');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong with this error: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong with this error: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  Create $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        return view('pages.customers.create', [
            'model' => new Customer,

        ]);
    }

    /*
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Customer;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Customer saved successfully');
            return redirect()->to('customer/index');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Customer');
        }
        return redirect()->back();
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('pages.customers.edit', [
            'model' => $customer,

        ]);
    }

    /*
     * Update a existing resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $model = Customer::find($request->id);
        $model->fill($request->all());
        if ($model->save()) {
            session()->flash('app_message', 'Customer successfully updated');
            return redirect()->to('customer/index');
        } else {
            session()->flash('app_error', 'Something is wrong while updating Customer');
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
        $customer = Customer::find($id);
        if ($customer->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $customer->status = $status;
        if ($customer->save()) {
            session()->flash('app_message', 'Customer Status successfully Updated');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Customer');
        }

        return redirect()->back();
    }
}
