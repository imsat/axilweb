<?php

namespace App\Models;

use App\Traits\SoftDeletesWithUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreOrder extends Model
{
    use HasFactory, SoftDeletesWithUser;

    protected $fillable = ['user_id', 'total', 'status', 'delivery_date', 'deleted_by_id', 'deleted_at'];

    public function scopeSearch($query)
    {
        return empty(request()->search) ? $query : $query->whereHas('user', function ($query) {
            $query->where('name', 'like', '%' . request()->search . '%')->orWhere('email', 'like', '%' . request()->search . '%');
        });
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pre_order_items(){
        return $this->hasMany(PreOrderItem::class);
    }

    // Define the relationship to Product through PreOrderItem
    public function products()
    {
        return $this->hasManyThrough(Product::class, PreOrderItem::class, 'pre_order_id', 'id', 'id', 'product_id')->select('products.id', 'products.name', 'pre_order_items.pre_order_id as laravel_through_key');
    }
}
