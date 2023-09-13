<?php

/**
 * Created by PhpStorm.
 * User: Khubaib_ur_Rehman
 * Date: 9/9/2017
 * Time: 7:40 PM
 */

namespace App\Helpers;


use App\Models\Area;
use App\Models\Banks;
use App\Models\Branch;
use App\Models\Cih;
use App\Models\CihCollections;
use App\Models\CollectionDetail;
use App\Models\Deposits;
use App\Models\Expense;
use App\Models\Loans;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Region;
use App\Models\SaleOrder;
use App\Models\StockManagement;
use App\Models\User;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

//use MongoDB\Client as Mongo;

class GeneralHelper
{
    public static function getConfigTypes()
    {
        $dataArray = [
            'flavour' => 'Flavour',
            'product_type' => 'Product Type',
            'manufacturer' => 'Manufacturer',
            'packing' => 'Packing',
            'expenses_type' => 'Expenses Type'
        ];

        return $dataArray;
    }

    public static function getConfigList()
    {
        $dataArray = [
            'flavour' => 'Flavour',
            'product_type' => 'Product Type',
            'manufacturer' => 'Manufacturer',
            'packing' => 'Packing',
            'products' => 'Products',
            'expenses_type' => 'Expenses Type'
        ];

        return $dataArray;
    }

    public static function getExpenseModes()
    {
        $dataArray = [
            'Cash' => 'Cash',
            'Cheque' => 'Cheque',
            'Online' => 'Online'
        ];

        return $dataArray;
    }

    public static function stockPurchases($id)
    {
        $stockCheck = StockManagement::where('report_date', date('Y-m-d'))->first();
        $purchaseDetails = PurchaseOrderDetail::where('purchase_order_id', $id)->get();

        if (!empty($stockCheck) && $stockCheck != null) {
            if (!empty($purchaseDetails) && $purchaseDetails != null) {
                foreach ($purchaseDetails as $detail) {
                    $stockCheck->purchase += (int)$detail->quantity;
                    $stockCheck->purchase_amount += (int)$detail->quantity * (int)$detail->unit_price;
                }
                if (!$stockCheck->save()) {
                    return false;
                } else {
                    $stockCheck->closing_stock = ((int)$stockCheck->opening_stock + (int)$stockCheck->purchase) - (int)$stockCheck->sale;
                    $stockCheck->closing_stock_amount = ((int)$stockCheck->opening_stock_amount + (int)$stockCheck->purchase_amount) - (int)$stockCheck->sale_amount;
                    if ($stockCheck->save()) {
                        self::openingStockNextDate($stockCheck);
                        foreach ($purchaseDetails as $detail) {
                            $product = Product::where('id', $detail->product_id)->first();
                            if (!empty($product) && $product != null) {
                                $product->stock_in_hand += $detail->quantity;
                                if (!$product->save()) {
                                    return false;
                                }
                            }
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }

        } else {
            if (!empty($purchaseDetails) && $purchaseDetails != null) {
                $stockModel = new StockManagement();
                foreach ($purchaseDetails as $detail) {
                    $stockModel->purchase += (int)$detail->quantity;
                    $stockModel->purchase_amount += (int)$detail->quantity * (int)$detail->unit_price;
                }
                if (!$stockModel->save()) {
                    return false;
                } else {
                    $stockModel->closing_stock = ((int)$stockModel->opening_stock + (int)$stockModel->purchase) - (int)$stockModel->sale;
                    $stockModel->closing_stock_amount = ((int)$stockModel->opening_stock_amount + (int)$stockModel->purchase_amount) - (int)$stockModel->sale_amount;
                    $stockModel->report_date = date('Y-m-d');
                    if ($stockModel->save()) {
                        self::openingStockNextDate($stockModel);
                        foreach ($purchaseDetails as $detail) {
                            $product = Product::where('id', $detail->product_id)->first();
                            if (!empty($product) && $product != null) {
                                $product->stock_in_hand += $detail->quantity;
                                if (!$product->save()) {
                                    return false;
                                }
                            }
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }

        }
        return true;
    }

    public static function stockPurchasesReverse($id)
    {
        $stockCheck = StockManagement::where('report_date', date('Y-m-d'))->first();
        $purchaseDetails = PurchaseOrderDetail::where('purchase_order_id', $id)->get();

        if (!empty($stockCheck) && $stockCheck != null) {
            if (!empty($purchaseDetails) && $purchaseDetails != null) {
                foreach ($purchaseDetails as $detail) {
                    $stockCheck->purchase -= (int)$detail->quantity;
                    $stockCheck->purchase_amount -= (int)$detail->quantity * (int)$detail->unit_price;
                }
                if (!$stockCheck->save()) {
                    return false;
                } else {
                    $stockCheck->closing_stock = ((int)$stockCheck->opening_stock + (int)$stockCheck->purchase) - (int)$stockCheck->sale;
                    $stockCheck->closing_stock_amount = ((int)$stockCheck->opening_stock_amount + (int)$stockCheck->purchase_amount) - (int)$stockCheck->sale_amount;
                    if ($stockCheck->save()) {
                        self::openingStockNextDate($stockCheck);
                        foreach ($purchaseDetails as $detail) {
                            $product = Product::where('id', $detail->product_id)->first();
                            if (!empty($product) && $product != null) {
                                $product->stock_in_hand -= (int)$detail->quantity;
                                if (!$product->save()) {
                                    return false;
                                }
                            }
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }

        }
        return true;
    }

    public static function stockSales($amount, $pQty)
    {
        $stockCheck = StockManagement::where('report_date', date('Y-m-d'))->first();
        if (!empty($stockCheck) && $stockCheck != null) {
            $stockCheck->sale += (int)$pQty;
            $stockCheck->sale_amount += (int)str_replace(',', '', $amount);
            if (!$stockCheck->save()) {
                return false;
            } else {
                $stockCheck->closing_stock = ((int)$stockCheck->opening_stock + (int)$stockCheck->purchase) - (int)$stockCheck->sale;
                $stockCheck->closing_stock_amount = ((int)$stockCheck->opening_stock_amount + (int)$stockCheck->purchase_amount) - (int)$stockCheck->sale_amount;
                if (!$stockCheck->save()) {
                    return false;
                } else {
                    self::openingStockNextDate($stockCheck);
                }
            }
        } else {
            $stockModel = new StockManagement();
            $stockModel->sale += (int)$pQty;
            $stockModel->sale_amount += (int)str_replace(',', '', $amount);
            $stockModel->report_date = date('Y-m-d');
            if (!$stockModel->save()) {
                return false;
            } else {
                $stockModel->closing_stock = ((int)$stockModel->opening_stock + (int)$stockModel->purchase) - (int)$stockModel->sale;
                $stockModel->closing_stock_amount = ((int)$stockModel->opening_stock_amount + (int)$stockModel->purchase_amount) - (int)$stockModel->sale_amount;
                if (!$stockModel->save()) {
                    return false;
                } else {
                    self::openingStockNextDate($stockModel);
                }
            }
        }
        return true;
    }

    public static function openingStockNextDate($model)
    {
        $stockCheck = StockManagement::where('report_date', date('Y-m-d', strtotime(' +1 day')))->first();
        if (!empty($stockCheck) && $stockCheck != null) {
            $stockCheck->opening_stock = $model->closing_stock;
            $stockCheck->opening_stock_amount = $model->closing_stock_amount;
            if (!$stockCheck->save()) {
                return false;
            }
        } else {
            $stockModel = new StockManagement();
            $stockModel->report_date = date('Y-m-d', strtotime(' +1 day'));
            $stockModel->opening_stock = $model->closing_stock;
            $stockModel->opening_stock_amount = $model->closing_stock_amount;
            if (!$stockModel->save()) {
                return false;
            }
        }

        return true;
    }

    public static function purchaseReturn()
    {

    }

    public static function saleReturn()
    {

    }

    public static function getExpense($type, $fromDate = 0, $toDate = 0)
    {
        $expense = Expense::where('type', $type)->where('deleted', 0);
        if ($fromDate != 0 && $toDate != 0) {
            $expense->where('exp_date', '>=', $fromDate);
            $expense->where('exp_date', '<=', $toDate);
        }
        $expense = $expense->sum('amount');

        return $expense;
    }

    public static function getExpenseAll($type)
    {
        $expense = Expense::where('type', $type)->where('deleted', 0)->sum('amount');
        return $expense;
    }

    public static function getProfitLoos()
    {
        $purchases = PurchaseOrder::where('status', 1)->sum('invoice_price');
        $expense = Expense::where('deleted', 0)->whereNotIn('type', ['cash_input'])->sum('amount');
        $sales = SaleOrder::where('status', 1)->sum('invoice_price');
        $cash = Expense::where('deleted', 0)->where('type', 'cash_input')->sum('amount');

        $inflow = $sales + $cash;
        $outflow = $purchases + $expense;
        return $inflow - $outflow;

    }

    public static function getDisplay($type, $list)
    {
        $display = 'inline';

        if ($list == 'expenses_type') {
            $expense = Expense::where('type', $type)->get();
            if (count($expense) > 0) {
                $display = "none";
            }
        } else {
            if ($list == 'product_type') {
                $product = Product::where('name', $type)->get();
                if (count($product) > 0) {
                    $display = "none";
                }
            } elseif ($list == 'manufacturer') {
                $product = Product::where('manufacturer', $type)->get();
                if (count($product) > 0) {
                    $display = "none";
                }
            } elseif ($list == 'packing') {
                $product = Product::where('packing', $type)->get();
                if (count($product) > 0) {
                    $display = "none";
                }
            } elseif ($list == 'flavour') {
                $product = Product::where('flavour', $type)->get();
                if (count($product) > 0) {
                    $display = "none";
                }
            }
        }

        return $display;
    }

    public static function getSupplierLedger($id, $date1, $date2)
    {
        $purchaseData = [];
        if ($date1 == 0 && $date1 == 0) {
            $purchases = PurchaseOrder::where('supplier_id', $id)->get();
        } else {
            $purchases = PurchaseOrder::where('supplier_id', $id);
            $purchases->where('order_date', '>=', $date1);
            $purchases->where('order_date', '<=', $date2);
            $purchases = $purchases->get();
        }

        foreach ($purchases as $key => $purchase) {
            $purchaseData[$key + $purchase->id]['order_date'] = date('F jS, Y', strtotime($purchase->order_date));
            $purchaseData[$key + $purchase->id]['description'] = 'Purchase';
            $purchaseData[$key + $purchase->id]['invoice'] = $purchase->invoice_number;
            $purchaseData[$key + $purchase->id]['dr'] = 0;
            $purchaseData[$key + $purchase->id]['cr'] = $purchase->invoice_price;
            $purchaseData[$key + $purchase->id]['payable'] = $purchase->invoice_price;

            $purchaseData[$key + 1 + $purchase->id]['order_date'] = date('F jS, Y', strtotime($purchase->order_date));
            $purchaseData[$key + 1 + $purchase->id]['description'] = 'Payment';
            $purchaseData[$key + 1 + $purchase->id]['invoice'] = $purchase->invoice_number;
            $purchaseData[$key + 1 + $purchase->id]['dr'] = $purchase->paid_amount;
            $purchaseData[$key + 1 + $purchase->id]['cr'] = 0;
            $purchaseData[$key + 1 + $purchase->id]['payable'] = $purchase->invoice_price - $purchase->paid_amount;
        }
        $purchaseData = array_values($purchaseData);
        return  $purchaseData;
    }

    public static function getCustomerLedger($id, $date1, $date2)
    {
        $salesData = [];
        if ($date1 == 0 && $date1 == 0) {
            $sales = SaleOrder::where('customer_id', $id)->get();
        } else {
            $sales = SaleOrder::where('customer_id', $id);
            $sales->where('sale_date', '>=', $date1);
            $sales->where('sale_date', '<=', $date2);
            $sales = $sales->get();
        }
        foreach ($sales as $key => $sale) {
            $salesData[$key + $sale->id]['sale_date'] = date('F jS, Y', strtotime($sale->sale_date));
            $salesData[$key + $sale->id]['description'] = 'Sale';
            $salesData[$key + $sale->id]['invoice'] = $sale->invoice_number;
            $salesData[$key + $sale->id]['dr'] = $sale->invoice_price;
            $salesData[$key + $sale->id]['cr'] = 0;
            $salesData[$key + $sale->id]['receivable'] = $sale->invoice_price;

            $salesData[$key + 1 + $sale->id]['sale_date'] = date('F jS, Y', strtotime($sale->sale_date));
            $salesData[$key + 1 + $sale->id]['description'] = 'Received';
            $salesData[$key + 1 + $sale->id]['invoice'] = $sale->invoice_number;
            $salesData[$key + 1 + $sale->id]['dr'] = 0;
            $salesData[$key + 1 + $sale->id]['cr'] = $sale->received_amount;
            $salesData[$key + 1 + $sale->id]['receivable'] = $sale->invoice_price - $sale->received_amount;;
        }

        $salesData = array_values($salesData);
        return $salesData;
    }

}
