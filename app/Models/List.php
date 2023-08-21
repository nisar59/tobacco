<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $list_name list name
@property varchar $lable lable
@property varchar $value value
@property tinyint $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class List extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'lists';

    /**
    * Mass assignable columns
    */
    protected $fillable=['list_name',
'lable',
'value',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}