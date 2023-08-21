<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $uuid uuid
@property varchar $bar_code bar code
@property varchar $name name
@property varchar $manufacturer manufacturer
@property varchar $flavour flavour
@property varchar $packing packing
@property double unit_price Purchase price
@property double $sales_price sales price
@property smallint unsigned $stock_in_hand stock in hand
@property smallint unsigned $min_stock_level min stock level
@property tinyint $status status
@property tinyint $deleted deleted
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Product extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'products';

    /**
    * Mass assignable columns
    */
    protected $fillable=['uuid',
'name',
'manufacturer',
'flavour',
'packing',
'unit_price',
'sales_price',
'stock_in_hand',
'min_stock_level',
'status',
'deleted'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}