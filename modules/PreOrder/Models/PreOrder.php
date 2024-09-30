<?php

namespace Modules\PreOrder\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PreOrder\Database\Factories\PreOrderFactory;
use Modules\PreOrder\Traits\SoftDeletesWithUser;

class PreOrder extends Model
{
    use HasFactory, SoftDeletesWithUser;

    protected $fillable = ['customer_id', 'total', 'status', 'delivery_address', 'delivery_date', 'deleted_by_id', 'deleted_at'];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return PreOrderFactory::new();
    }

    public function scopeSearch($query)
    {
        return empty(request()->search) ? $query : $query->whereHas('customer', function ($query) {
            $query->where('name', 'like', '%' . request()->search . '%')->orWhere('email', 'like', '%' . request()->search . '%');
        });
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
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
