<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $invoice_number invoice number
 * @property varchar $carriage_amount carriage amount
 * @property varchar $invoice_price invoice price
 * @property varchar $customer_id customer id
 * @property int unsigned $user_id user id
 * @property date $sale_date sale date
 * @property tinyint $status status
 * @property int $deleted deleted
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class SaleOrder extends Model
{

    /**
     * Mass assignable columns
     */
    protected $fillable = ['invoice_number',
        'customer_id',
        'invoice_price',
        'carriage_amount',
        'received_amount',
        'payment_method',
        'user_id',
        'sale_date',
        'status',
        'deleted'];

    /**
     * Database table name
     */
    protected $table = 'sale_orders';

    /**
     * Date time columns.
     */
    protected $dates = ['sale_date'];


    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function salesDetails()
    {
        return $this->hasMany(SaleOrderDetail::class, 'sale_order_id', 'id');
    }

}