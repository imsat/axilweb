<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image', 'category_id', 'stock'];

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
