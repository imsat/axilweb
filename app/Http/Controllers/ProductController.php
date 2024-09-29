<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductInterface $productService)
    {
    }
    public function index(Request $request)
    {
        try {
            // Get products from product service
            $products = $this->productService->list($request);
            return $this->response(true, 'Product list', 200, $products);
        } catch (\Exception $e) {
            return $this->response(false, $e->getMessage() ?? 'Something went wrong!', 404);
        }
    }
}
