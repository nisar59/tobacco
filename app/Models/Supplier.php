<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $supplier_name supplier name
@property varchar $address address
@property varchar $contact_number contact number
@property varchar $email_id email id
@property tinyint $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Supplier extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'suppliers';

    /**
    * Mass assignable columns
    */
    protected $fillable=['supplier_name',
'address',
'contact_number',
'email_id'
    ];

    /**
    * Date time columns.
    */
    protected $dates=[];




}