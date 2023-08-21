<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $invoice_number invoice number
@property varchar $customer_id customer id
@property int unsigned $user_id user id
@property date $sale_date sale date
@property tinyint $status status
@property int $deleted deleted
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class SaleOrder extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'sale_orders';

    /**
    * Mass assignable columns
    */
    protected $fillable=['invoice_number',
'invoice_price',
'customer_id',
'user_id',
'sale_date',
'status',
'deleted'];

    /**
    * Date time columns.
    */
    protected $dates=['sale_date'];


    public function customer()
    {
        return $this->hasOne(Customer::class, 'id','customer_id');
    }
    public function salesDetails()
    {
        return $this->hasMany(SaleOrderDetail::class, 'sale_order_id','id');
    }

}