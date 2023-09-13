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
use App\Models\CustomerPayment;
use App\Models\Deposits;
use App\Models\Expense;
use App\Models\Loans;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Region;
use App\Models\SaleOrder;
use App\Models\StockManagement;
use App\Models\SupplierPayment;
use App\Models\User;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

//use MongoDB\Client as Mongo;

class PaymentHelper
{

    public static function supplierPurchase($supplier_id){
        $status = true;

        $supplierPurchasesSum = PurchaseOrder::where('supplier_id',$supplier_id)->where('status',1)->sum('invoice_price');
        $supplierPayments  = SupplierPayment::where('supplier_id',$supplier_id)->first();

        try {
            if(!empty($supplierPayments) && $supplierPayments!=null){
                $supplierPayments->purchase_total = $supplierPurchasesSum;
                $supplierPayments->diff_amount = ($supplierPurchasesSum-$supplierPayments->paid_total);
                $supplierPayments->save();
            }else{
                $newSupplierPayment = new SupplierPayment();
                $newSupplierPayment->supplier_id = $supplier_id;
                $newSupplierPayment->purchase_total = $supplierPurchasesSum;
                $newSupplierPayment->diff_amount = $supplierPurchasesSum;
                $newSupplierPayment->save();
            }
        } catch (\Exception $e) {
            session()->flash('app_error', $e->getMessage());
            $status =  false;
        }


        return $status;
    }

    public static function supplierPurchasePayment($supplier_id){
        $status = true;

        $supplierPaymentSum  = Expense::where('correspondent_id',$supplier_id)->where('type','purchase_payment')->where('deleted',0)->sum('amount');
        $supplierPayments  = SupplierPayment::where('supplier_id',$supplier_id)->first();

        try {
            if(!empty($supplierPayments) && $supplierPayments!=null){
                $supplierPayments->paid_total = $supplierPaymentSum;
                $supplierPayments->diff_amount = ($supplierPayments->purchase_total-$supplierPaymentSum);
                $supplierPayments->save();
            }
        } catch (\Exception $e) {
            session()->flash('app_error', $e->getMessage());
            $status =  false;
        }


        return $status;
    }


    public static function customerSales($customer_id){
        $status = true;

        $customerSalesSum = SaleOrder::where('customer_id',$customer_id)->where('status',1)->sum('invoice_price');
        $customerPayments  = CustomerPayment::where('customer_id',$customer_id)->first();

        try {
            if(!empty($customerPayments) && $customerPayments!=null){
                $customerPayments->sale_total = $customerSalesSum;
                $customerPayments->diff_amount = ($customerSalesSum-$customerPayments->received_total);
                $customerPayments->save();
            }else{
                $newCustomerPayments = new CustomerPayment();
                $newCustomerPayments->customer_id = $customer_id;
                $newCustomerPayments->sale_total = $customerSalesSum;
                $newCustomerPayments->diff_amount = $customerSalesSum;
                $newCustomerPayments->save();
            }
        } catch (\Exception $e) {
            print_r($e);
            die();
            session()->flash('app_error', $e->getMessage());
            $status =  false;
        }


        return $status;
    }

    public static function customerSalePayment($customer_id){
        $status = true;

        $customerPaymentSum  = Expense::where('correspondent_id',$customer_id)->where('type','sale_receipts')->where('deleted',0)->sum('amount');
        $customerPayments  = CustomerPayment::where('customer_id',$customer_id)->first();

        try {
            if(!empty($customerPayments) && $customerPayments!=null){
                $customerPayments->received_total = $customerPaymentSum;
                $customerPayments->diff_amount = ($customerPayments->sale_total-$customerPaymentSum);
                $customerPayments->save();
            }
        } catch (\Exception $e) {
            session()->flash('app_error', $e->getMessage());
            $status =  false;
        }


        return $status;
    }

}
