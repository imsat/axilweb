<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\PreOrder;
use App\Models\PreOrderItem;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@mail.com',
             'role' => 'admin',
         ]);
         User::factory()->create([
             'name' => 'Manager',
             'email' => 'manager@mail.com',
             'role' => 'manager',
         ]);

         Customer::factory(100)->create();

        // Insert category
        DB::table('categories')->insert([
            ['name' => 'Fruits & Vegetables'],
            ['name' => 'Dairy & Eggs'],
            ['name' => 'Bakery & Bread'],
            ['name' => 'Beverages'],
            ['name' => 'Snacks & Sweets'],
        ]);

        // Insert product
        DB::table('products')->insert([
            ['name' => 'Apple', 'category_id' => 1, 'price' => 1.50, 'image' => '/images/1.webp'],
            ['name' => 'Banana', 'category_id' => 1, 'price' => 0.50, 'image' => '/images/2.webp'],
            ['name' => 'Orange', 'category_id' => 1, 'price' => 1.00, 'image' => '/images/3.webp'],
            ['name' => 'Milk', 'category_id' => 2, 'price' => 2.00, 'image' => '/images/4.webp'],
            ['name' => 'Cheese', 'category_id' => 2, 'price' => 3.00, 'image' => '/images/5.webp'],
            ['name' => 'Yogurt', 'category_id' => 2, 'price' => 1.20, 'image' => '/images/1.webp'],
            ['name' => 'Bread', 'category_id' => 3, 'price' => 1.50, 'image' => '/images/2.webp'],
            ['name' => 'Croissant', 'category_id' => 3, 'price' => 2.00, 'image' => '/images/3.webp'],
            ['name' => 'Coffee', 'category_id' => 4, 'price' => 5.00, 'image' => '/images/4.webp'],
            ['name' => 'Tea', 'category_id' => 4, 'price' => 3.50, 'image' => '/images/5.webp'],
            ['name' => 'Soda', 'category_id' => 4, 'price' => 1.00, 'image' => '/images/1.webp'],
            ['name' => 'Juice', 'category_id' => 4, 'price' => 2.50, 'image' => '/images/2.webp'],
            ['name' => 'Potato Chips', 'category_id' => 5, 'price' => 1.75, 'image' => '/images/3.webp'],
            ['name' => 'Chocolate', 'category_id' => 5, 'price' => 2.00, 'image' => '/images/4.webp'],
            ['name' => 'Cereal', 'category_id' => 5, 'price' => 3.50, 'image' => '/images/5.webp'],
            ['name' => 'Rice', 'category_id' => 1, 'price' => 2.50, 'image' => '/images/1.webp'],
            ['name' => 'Pasta', 'category_id' => 1, 'price' => 1.80, 'image' => '/images/2.webp'],
            ['name' => 'Eggs', 'category_id' => 2, 'price' => 2.20, 'image' => '/images/3.webp'],
            ['name' => 'Chicken Breast', 'category_id' => 2, 'price' => 4.50, 'image' => '/images/4.webp'],
            ['name' => 'Salmon', 'category_id' => 2, 'price' => 7.00, 'image' => '/images/5.webp'],
        ]);

        // Generate fake orders
        PreOrder::factory(2000)->create()->each(function (PreOrder $preOrder) {
            PreOrderItem::factory(mt_rand(3, 8))->create(['pre_order_id'=> $preOrder->id]);
        });
    }
}
