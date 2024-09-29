<?php

namespace App\Http\Controllers;

use App\Interfaces\PreOrderInterface;
use App\Models\PreOrder;
use App\Traits\WrapInTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PreOrderController extends Controller
{
    use WrapInTransaction;

    public function __construct(protected PreOrderInterface $preOrderService)
    {
    }

    public function index(Request $request)
    {
        if (Gate::denies('view-preorders')) {
            return $this->response(false, 'Forbidden!', 403);
        }

        try {
            $preOrders = $this->preOrderService->list($request);
            return $this->response(true, 'Pre-order list', 200, $preOrders);
        } catch (\Exception $e) {
            return $this->response(false, $e->getMessage() ?? 'Something went wrong!', 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.id' => 'required', // Each product must have a id
            'products.*.price' => 'required|numeric|min:0', // Each product must have a valid price
            'products.*.quantity' => 'required|integer|min:1', // Each product must have a valid quantity
        ]);

        // Validate phone if the email ends with "@xyz.com"
        $validator->sometimes('phone', 'required|numeric', function ($input) {
            return str_ends_with($input->email, '@xyz.com');
        });

        if ($validator->fails()) {
            return $this->response(false, 'Invalid data!', 400, null, $validator->errors());
        }

        try {
            $preOrders = $this->wrapInTransaction(function ($request) {
                return $this->preOrderService->create($request);
            }, $request);

            return $this->response(true, 'Created successfully', 200, $preOrders);
        } catch (\Exception $e) {
            return $this->response(false, $e->getMessage() ?? 'Something went wrong!', 404);
        }
    }

    public function destroy(PreOrder $preOrder)
    {
        if (Gate::denies('manage-preorders')) {
            return $this->response(false, 'Forbidden!', 403);
        }

        try {
            $this->preOrderService->delete($preOrder);
            return $this->response(true, 'Deleted successfully', 200, $preOrder);
        } catch (\Exception $e) {
            return $this->response(false, $e->getMessage() ?? 'Something went wrong!', 404);
        }
    }
}
