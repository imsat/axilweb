<?php

namespace Modules\PreOrder\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\PreOrder\Models\Customer;
use Modules\PreOrder\Models\PreOrder;
use Tests\TestCase;

class PreOrderTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_creates_an_new_preorder(): void
    {
        $preorder = PreOrder::factory()->create();
        $this->assertInstanceOf(PreOrder::class, $preorder);
    }

    /**
     * Test validation failure on pre-order creation.
     */
    public function test_pre_order_creation_validation_failure()
    {
        $response = $this->postJson('/pre-orders', [
            'name' => '',
            'email' => 'invalid-email',
            'products' => null,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'product_id']);
    }


    /**
     * Test successful pre-order creation.
     */
    public function test_pre_order_creation_success()
    {

        // Create a user (customer) first
        $customer = Customer::factory()->create();
        $preOrderData = [
            'name' => 'John Doe',
            'email' => 'swap.satyajit@gmail.com',
            'delivery_address' => 'Banani, Dhaka',
            'products' => [
                ['id' => 9, 'price' => 5, 'quantity' => 3],
                ['id' => 11, 'price' => 2.5, 'quantity' => 4]
            ]
        ];

        $response = $this->actingAs($customer)->postJson('/pre-orders', $preOrderData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Submitted successfully',
            ]);

        $this->assertDatabaseHas('pre_orders', [
            'name' => 'John Doe',
            'email' => 'swap.satyajit@gmail.com',
        ]);
    }

    /**
     * Test pre-order deletion.
     */
    public function test_pre_order_deletion()
    {
        // Create a pre-order to delete
        $preOrder = PreOrder::factory()->create();

        $response = $this->deleteJson("/pre-orders/{$preOrder->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Deleted successfully',
            ]);

        // Ensure the pre-order is removed from the database
        $this->assertDatabaseMissing('pre_orders', [
            'id' => $preOrder->id,
        ]);
    }

}
