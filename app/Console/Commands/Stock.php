<?php

namespace App\Console\Commands;

use App\Helpers\PaymentHelper;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\StockManagement;

class Stock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:management {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $type = $this->argument('type');

        if ($type == 'opening') {
            $products = Product::where('status',1)->get();
            foreach ($products as $product){
                $stockCheck = StockManagement::where('report_date', date('Y-m-d'))->first();
                $stockCheck->opening_stock += $product->stock_in_hand;

                $purchaseDetails = PurchaseOrderDetail::where('product_id',$product->id)->get();
                foreach ($purchaseDetails as $detail){
                    $purchase = PurchaseOrder::where('id',$detail->purchase_order_id)->where('status')->first();
                    if(!empty($purchase) && $purchase!=null){
                        $stockCheck->opening_stock_amount += $detail->unit_price*$detail->quantity;
                    }
                }
                $stockCheck->save();
            }
        } elseif ($type == 'stock') {
            $date = date('Y-m-d');
            $end = date('Y-12-t'); //get end date of month

            while (strtotime($date) <= strtotime($end)) {
                $stockCheck = StockManagement::where('report_date', $date)->first();
                if (empty($stockCheck) && $stockCheck == null) {
                    $stockModel = new StockManagement();
                    $stockModel->report_date = $date;
                    $stockModel->save();
                }
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
        } elseif ($type == 'payment') {

            $suppliers = Supplier::all();
            foreach ($suppliers as $supplier){
                PaymentHelper::supplierPurchase($supplier->id);
                PaymentHelper::supplierPurchasePayment($supplier->id);
            }

            $customers = Customer::all();
            foreach ($customers as $customer){
                PaymentHelper::customerSales($customer->id);
                PaymentHelper::customerSalePayment($customer->id);
            }
        }

        return 0;
    }
}
