<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property smallint $product_id product id
@property varchar $barcode barcode
@property int $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
   
 */
class Barcode extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'barcodes';

    /**
    * Mass assignable columns
    */
    protected $fillable=['product_id',
'barcode',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}