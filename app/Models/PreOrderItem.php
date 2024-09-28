<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreOrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['pre_order_id', 'product_id', 'quantity'];

    public function pre_order(){
        return $this->belongsTo(User::class);
    }

}
