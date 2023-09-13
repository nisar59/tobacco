<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $supplier_id supplier id
@property int unsigned $purchase_total purchase total
@property int unsigned $paid_total paid total
@property int unsigned $diff_amount diff amount
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class SupplierPayment extends Model
{
    
    /**
    * Database table name
    */
    protected $table = 'supplier_payments';

    /**
    * Mass assignable columns
    */
    protected $fillable=['supplier_id',
'purchase_total',
'paid_total',
'diff_amount'];

    /**
    * Date time columns.
    */
    protected $dates=[];


    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id','supplier_id');
    }


}