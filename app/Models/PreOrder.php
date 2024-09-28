<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'total', 'status', 'delivery_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pre_order_items(){
        return $this->hasMany(PreOrderItem::class);
    }
}
