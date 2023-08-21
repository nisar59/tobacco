<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $customer_name customer name
@property varchar $address address
@property varchar $contact_number contact number
@property varchar $email_id email id
@property tinyint $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Customer extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'customers';

    /**
    * Mass assignable columns
    */
    protected $fillable=['customer_name',
'address',
'contact_number',
'email_id',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}