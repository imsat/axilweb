<?php

namespace Modules\PreOrder\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PreOrder\Database\Factories\PreOrderItemFactory;

class PreOrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['pre_order_id', 'product_id', 'price', 'quantity'];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return PreOrderItemFactory::new();
    }

    public function pre_order(){
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
