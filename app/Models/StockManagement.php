<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property date $report_date report date
@property int $opening_stock opening stock
@property int $opening_stock_amount opening stock amount
@property int $purchase purchase
@property int $purchase_return purchase return
@property int $sale sale
@property int $sale_return sale return
@property int $closing_stock closing stock
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class StockManagement extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'stock_managements';

    /**
    * Mass assignable columns
    */
    protected $fillable=['report_date',
'opening_stock',
'opening_stock_amount',
'purchase',
'purchase_amount',
'purchase_return',
'sale',
'sale_amount',
'sale_return',
'closing_stock',
'closing_stock_amount'
];

    /**
    * Date time columns.
    */
    protected $dates=['report_date'];




}