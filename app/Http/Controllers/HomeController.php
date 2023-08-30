<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Configuration;
use App\Models\Expense;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SaleOrder;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Show the application dashboard.
     *
     *  @param  Request  $req
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $req)
    {
        if ($req->ajax()) {

            $start = $req->start;
            $length = $req->length;

            $product = Product::where('deleted', 0)->where('status',1);

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
            $product = $product->select('products.*')->orderBy('stock_in_hand','ASC')->offset($start)->limit($length)->get();

            return DataTables::of($product)
                ->setOffset($start)
                ->with([
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                ])

                ->editColumn('id', function ($row) {
                    return $row->name;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('stock_in_hand', function ($row) {
                    return $row->stock_in_hand;
                })
                ->editColumn('min_stock_level', function ($row) {
                    return $row->min_stock_level;
                })
                ->rawColumns(['action', 'id'])
                ->make(true);
        }

        $purchases = PurchaseOrder::where('status', 1)->sum('invoice_price');
        $sales = SaleOrder::where('status', 1)->sum('invoice_price');
        $expenses = Expense::where('deleted', 0)->whereNotIn('type', ['cash_input'])->sum('amount');
        $profitLoos = GeneralHelper::getProfitLoos();

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

        return view('home', [
            'purchases' => self::shortNumber($purchases),
            'sales' => self::shortNumber($sales),
            'expenses' => $expenses,
            'profitLoos' => $profitLoos,
            'productTypes' => $productType,
            'manufacturers' => $manufacturer,
            'flavours' => $flavour,
            'packings' => $packing
        ]);
    }


    function shortNumber($num)
    {
        $units = ['', 'K', 'M', 'B', 'T'];
        for ($i = 0; $num >= 1000; $i++) {
            $num /= 1000;
        }
        return round($num, 1) . $units[$i];
    }
}
