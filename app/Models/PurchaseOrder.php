<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $supplier_id supplier id
@property int unsigned $user_id user id
@property date $order_date order date
@property varchar $image image
@property varchar $invoice_number invoice number
@property varchar $invoice_price invoice price
@property tinyint $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class PurchaseOrder extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'purchase_orders';

    /**
    * Mass assignable columns
    */
    protected $fillable=['supplier_id',
'user_id',
'order_date',
'invoice_number',
'invoice_price',
'image',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=['order_date'];


    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id','supplier_id');
    }
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id','id');
    }

}