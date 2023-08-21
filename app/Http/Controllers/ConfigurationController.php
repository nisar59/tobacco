<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Expense;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Http\Requests\Configurations\Index;
use App\Http\Requests\Configurations\Show;
use App\Http\Requests\Configurations\Create;
use App\Http\Requests\Configurations\Store;
use App\Http\Requests\Configurations\Edit;
use App\Http\Requests\Configurations\Update;
use App\Http\Requests\Configurations\Destroy;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * Description of ListingController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class ConfigurationController extends Controller
{
    /*
     * Display a Configuration of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($key)
    {
        $model = Configuration::where('list_name', $key)->where('deleted', 0)->get();
        return view('pages.configurations.index',
            [
                'models' => $model,
                'config_list_name' => $key
            ]
        );
    }

    /*
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Configuration  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Configuration $listing)
    {
        return view('pages.configurations.show', [
            'record' => $listing,
        ]);

    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($key)
    {
        return view('pages.configurations.create', [
            'model' => new Configuration,
            'config_list_name' => $key,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model = new Configuration;
        $model->fill($request->all());
        $model->lable = ucfirst($request->lable);
        $model->value = strtolower($model->lable);
        if (isset($request->additional_key) && !empty($request->additional_key)) {
            $model->additional_key = strtolower($request->additional_key);
        }
        if ($model->save()) {
            session()->flash('app_message', 'Configuration saved successfully');
            return redirect()->to('config/index/' . $model->list_name);
        } else {
            session()->flash('app_message', 'Something is wrong while saving Configuration');
        }
        return redirect()->back();
    }

    /*
     * Show the form for editing the specified resource.
     * @param  Configuration $listing
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listing = Configuration::find($id);
        return view('pages.configurations.edit', [
            'model' => $listing,
            'config_list_name' => $listing->list_name,

        ]);
    }

    /**
     * Update a existing resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $model = Configuration::find($request->id);
        $model->lable = ucfirst($request->lable);
        $model->value = strtolower($model->lable);
        $model->status = $request->status;
        if (isset($request->additional_key) && !empty($request->additional_key)) {
            $model->additional_key = strtolower($request->additional_key);
        }
        if ($model->save()) {
            session()->flash('app_message', 'Configuration successfully updated');
            return redirect()->to('config/index/' . $model->list_name);
        } else {
            session()->flash('app_message', 'Something is wrong while saving Configuration');
        }
        return redirect()->back();
    }

    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy $request
     * @param  Configuration $listing
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $listing = Configuration::find($id);

        $congTypes = GeneralHelper::getConfigTypes();
        foreach ($congTypes as $key => $types) {
            if ($listing->list_name == 'expenses_type') {
                $expense = Expense::where('type', $listing->value)->get();
                if (count($expense) > 0) {
                    session()->flash('app_error', 'Configuration can not be deleted!');
                } else {
                    if ($listing->delete()) {
                        session()->flash('app_message', 'Configuration successfully deleted');
                    } else {
                        session()->flash('app_error', 'Error occurred while deleting Configuration');
                    }
                }
            } else {
                if ($listing->list_name == $key) {
                    $product = Product::where($key, $listing->value)->get();
                    if (count($product) > 0) {
                        session()->flash('app_error', 'Configuration can not be deleted!');
                    } else {
                        if ($listing->delete()) {
                            session()->flash('app_message', 'Configuration successfully deleted');
                        } else {
                            session()->flash('app_error', 'Error occurred while deleting Configuration');
                        }
                    }
                }
            }
        }


        return redirect()->back();
    }

    public function profitLoos(Request $request)
    {
        if ($request->exp_date != null) {
            $string = explode('-', $request->exp_date);
            $date1 = date('Y-m-d', strtotime($string[0]));
            $date2 = date('Y-m-d', strtotime($string[1]));
        }else{
            $date1 = date('Y-m-01');
            $date2 = date('Y-m-d');
        }

        $purchases = PurchaseOrder::where('status', 1)->where('order_date', '>=', $date1)->where('order_date', '<=', $date2)->sum('invoice_price');
//        -----------------------------------------------------
        $sales = SaleOrder::where('status', 1)->where('sale_date', '>=', $date1)->where('sale_date', '<=', $date2)->sum('invoice_price');
//        -------------------------------------------------------

        $cashInPut = DB::table('expenses')
            ->where('type', 'cash_input')
            ->where('exp_date', '>=', $date1)
            ->where('exp_date', '<=', $date2)
            ->sum('amount');

        $cashInPutPre = DB::table('expenses')
            ->where('type', 'cash_input')
            ->where('exp_date', '<', $date1)
            ->sum('amount');

//        ----------------------------------------------------
        $cashOutflow = DB::table('expenses')
            ->join('configurations', 'configurations.value', '=', 'expenses.type')
            ->where('configurations.list_name', 'expenses_type')
            ->where('configurations.status', 1)
            ->where('expenses.exp_date', '>=', $date1)
            ->where('expenses.exp_date', '<=', $date2)
            ->sum('expenses.amount');
//        -----------------------------------------------------------

        $grossCashInflow = $sales + $cashInPut;
        $netCashOutflow = ($purchases + $cashOutflow);

        $expenseTypesNp = Configuration::where('list_name', 'expenses_type')->get();
        return view('pages.configurations.profit_loss', [
            'sales' => $sales,
            'cashInPut' => $cashInPut,
            'netCashOutflow' => $netCashOutflow,
            'grossCashInflow' => $grossCashInflow,
            'purchases' => $purchases,
            'expenseTypesNp' => $expenseTypesNp,
            'cashInPutPre' => $cashInPutPre,
            'date1' => $date1,
            'date2' => $date2
        ]);
    }
}
