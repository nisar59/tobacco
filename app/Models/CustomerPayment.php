<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $customer_id customer id
@property int unsigned $sale_total sale total
@property int unsigned $received_total received total
@property int unsigned $diff_amount diff amount
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class CustomerPayment extends Model
{
    
    /**
    * Database table name
    */
    protected $table = 'customer_payments';

    /**
    * Mass assignable columns
    */
    protected $fillable=['customer_id',
'sale_total',
'received_total',
'diff_amount'];

    /**
    * Date time columns.
    */
    protected $dates=[];


    public function customer()
    {
        return $this->hasOne(Customer::class, 'id','customer_id');
    }


}