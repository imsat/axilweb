<?php
namespace App\Services;

use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductService implements ProductInterface
{
    public function list($request)
    {
        $perPage = $request->get('per_page', 20);
        $fields = explode(',', $request->get('fields', 'id'));

        $query = Product::search()->select($fields)->latest('id', 'desc');

        if ($request->filled('with')) {
            $with = json_decode($request->get('with'));
            $query->with($with);
        }
        return $query->cursorPaginate($perPage);
    }
}
