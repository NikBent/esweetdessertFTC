<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Explicitly specify table name
    protected $primaryKey = 'product_id'; // Your primary key column

    public $incrementing = false; // Because product_id is a string (not auto-incrementing integer)
    protected $keyType = 'string'; // product_id is CHAR/VARCHAR
}
