<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $list_name list name
@property varchar $lable lable
@property varchar $value value
@property varchar $additional_key additional key
@property tinyint $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Configuration extends Model
{
    
    /**
    * Database table name
    */
    protected $table = 'configurations';

    /**
    * Mass assignable columns
    */
    protected $fillable=['list_name',
'lable',
'value',
'additional_key',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}