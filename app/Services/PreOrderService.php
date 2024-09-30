<?php

namespace App\Services;

use App\Interfaces\PreOrderInterface;
use App\Models\PreOrder;
use Illuminate\Support\Facades\DB;

class PreOrderService implements PreOrderInterface
{
    protected $userService, $sendPreOrderConfirmationEmailService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->sendPreOrderConfirmationEmailService = new SendPreOrderConfirmationEmailService();
    }

    public function list($request)
    {
        $shortBy = $request->get('short_by');
        $perPage = $request->get('per_page', 10);
        $fields = explode(',', $request->get('fields', 'id'));

        $query = PreOrder::search()->select($fields)
            ->when(blank($shortBy), fn($q) => $q->latest('id'))
            ->when(!blank($shortBy), fn($q) => $q->orderBy($shortBy[0]['key'], $shortBy[0]['order']));

        if ($request->filled('with')) {
            $with = json_decode($request->get('with'));
            $query->with($with);
        }
        return $query->paginate($perPage);
    }

    public function create($request)
    {
        // Get user
        $userData = $request->only('name', 'email', 'phone', 'address');
        $user = $this->userService->findOrCreate($userData);

        if (!blank($user)) {
            // Create new pre-order
            $products = $request->get('products');

            $preOrder = new PreOrder();
            $preOrderData['user_id'] = $user->id;
            $preOrderData['total'] = $request->get('total');
            $preOrderData['delivery_address'] = $request->get('delivery_address');
            $preOrder->fill($preOrderData);
            $preOrder->save();

            if (!blank($preOrder)) {
                $preOrderItems = [];
                $total = 0;
                foreach ($products as $key => $product) {
                    $quantity = (integer)data_get($product, 'quantity');
                    $productId = (integer)data_get($product, 'id');
                    // Get product price
                    $productDetails = DB::table('products')->where('id', $productId)->select('id', 'price')->first();
                    if (!blank($productDetails) && $quantity > 0) {
                        $price = (double)$productDetails->price;
                        $preOrderItems[$key]['product_id'] = $productDetails->id;
                        $preOrderItems[$key]['price'] = $price;
                        $preOrderItems[$key]['quantity'] = $quantity;
                        $total += $price * $quantity;
                    }
                }

                //Create pre-order items
                if (!empty($preOrderItems) && is_array($preOrderItems)) {
                    $preOrder->pre_order_items()->createMany($preOrderItems);

                    // Update total
                    $preOrder->total = $total;
                    $preOrder->save();

                    //Send emails
                    $this->sendPreOrderConfirmationEmailService->sendPreOrderConfirmationEmails($preOrder, $user);

                    return $preOrder;
                }

                return false;
            }
            return false;
        }
        return false;
    }

    public function delete($preOrder)
    {
        $preOrder->delete();
        return true;
    }
}
