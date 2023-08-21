<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int unsigned $purchase_order_id purchase order id
@property int unsigned $product_id product id
@property double unsigned $unit_price unit price
@property smallint unsigned $quantity quantity
@property smallint unsigned $return_qty return qty
@property tinyint $deleted deleted
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class PurchaseOrderDetail extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'purchase_order_details';

    /**
    * Mass assignable columns
    */
    protected $fillable=['purchase_order_id',
'product_id',
'unit_price',
'quantity',
'return_qty',
'deleted'];

    /**
    * Date time columns.
    */
    protected $dates=[];


    public function product()
    {
        return $this->hasOne(Product::class, 'id','product_id');
    }



}