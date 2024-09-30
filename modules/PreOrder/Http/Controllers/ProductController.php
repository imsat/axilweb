<?php

namespace Modules\PreOrder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\PreOrder\Interfaces\ProductInterface;

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
