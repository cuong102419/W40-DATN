<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Tạo 50 đơn hàng giả
        foreach (range(1, 50) as $index) {
            $orderCreatedAt = now()->subDays(rand(0, 365));
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => 2,
                'admin_id' => 1,
                'order_code' => strtoupper($faker->unique()->bothify('ORD#######')),
                'status' => $faker->randomElement(['completed', 'canceled']),
                'total' => $faker->randomFloat(0, 1000000, 5000000),
                'payment_method' => $faker->randomElement(['ATM', 'COD', 'MOMO']),
                'payment_status' => $faker->randomElement(['paid','cancel']),
                'address' => $faker->address,
                'fullname' => $faker->name,
                'email' => $faker->email,
                'phone_number' => $faker->phoneNumber,
                'note' => $faker->sentence,
                'discount_amount' => $faker->randomFloat(0, 0, 100000),
                'shipping' => $faker->randomFloat(0, 0, 100000),
                'reason' => $faker->optional()->sentence,
                'created_at' => $orderCreatedAt,
                'updated_at' => $orderCreatedAt,
            ]);

            // Tạo order_items cho mỗi đơn hàng
            foreach (range(1, rand(1, 5)) as $itemIndex) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_variant_id' => rand(1, 2),// ae tạo khoảng 5 biến thể rồi để vào giá trị max để fake dữ liệu
                    'quantity' => rand(1, 5),
                    'unit_price' => $faker->randomFloat(0, 1000000, 5000000),
                    'created_at' => $orderCreatedAt,
                    'updated_at' => $orderCreatedAt,
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }
    }
}
