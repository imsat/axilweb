<?php

namespace Modules\PreOrder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PreOrder\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image', 'category_id', 'stock'];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

    /**
     * Global search scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeSearch($query)
    {
        return empty(request()->search) ? $query : $query->where('name', 'LIKE', '%' . request()->search . '%');
    }

    /**
     * Get the user's avatar.
     */
    protected function image(): Attribute
    {
        return Attribute::make(get: fn($image) => $image ? asset($image) : null);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
