<?php

namespace Modules\PreOrder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Modules\PreOrder\Interfaces\PreOrderInterface;
use Modules\PreOrder\Models\PreOrder;
use Modules\PreOrder\Traits\WrapInTransaction;

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
            'delivery_address' => 'required|string',
            'g_recaptcha_response' => 'required',
            'products.*.id' => 'required', // Each product must have a id
            'products.*.price' => 'required|numeric|min:0', // Each product must have a valid price
            'products.*.quantity' => 'required|integer|min:1', // Each product must have a valid quantity
            'products' => 'required|array',
        ], [
            'products.required' => 'Please add at least one product into your cart!',
            'g_recaptcha_response.required' => 'The recaptcha field is required!',
        ]);

        // Validate phone if the email ends with "@xyz.com"
        $validator->sometimes('phone', 'required|numeric', function ($input) {
            return str_ends_with($input->email, '@xyz.com');
        });

        if ($validator->fails()) {
            return $this->response(false, 'Invalid data!', 400, null, $validator->errors());
        }

        //Grecaptcha
        $recaptchaResponse = $request->get('g_recaptcha_response');
        if(!blank($recaptchaResponse)){
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('app.recaptcha_secret'),
                'response' => $recaptchaResponse,
            ])->json();

            if(data_get($response, 'success') !== true){
                return $this->response(false, 'Something went wrong', 404);
            }
        }

        try {
            $preOrders = $this->wrapInTransaction(function ($request) {
                return $this->preOrderService->create($request);
            }, $request);

            return $this->response(true, 'Submitted successfully', 200, $preOrders);
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
