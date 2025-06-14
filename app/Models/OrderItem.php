<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';
    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'qty', 'price'];
}
?>