<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $type type
@property date $exp_date exp date
@property varchar $payment_mode payment mode
@property float $amount amount
@property varchar $remarks remarks
@property varchar $attachment_file attachment file
@property tinyint $deleted deleted
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Expense extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'expenses';

    /**
    * Mass assignable columns
    */
    protected $fillable=['type',
'exp_date',
'payment_mode',
'amount',
'remarks',
'attachment_file',
'deleted'];

    /**
    * Date time columns.
    */
    protected $dates=['exp_date'];




}