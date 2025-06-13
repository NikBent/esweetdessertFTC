<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order'; // 👈 specify the correct table name
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = ['order_id', 'users_id', 'date'];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
?>