<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $supplier_id supplier id
@property date $return_date return date
@property int $product_id product id
@property int $qty qty
@property float $unit_price unit price
@property int $deleted deleted
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class PurchaseReturn extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'purchase_returns';

    /**
    * Mass assignable columns
    */
    protected $fillable=['supplier_id',
'return_date',
'product_id',
'qty',
'unit_price',
'deleted'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}