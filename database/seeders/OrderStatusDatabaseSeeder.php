<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Database\Seeder;

class OrderStatusDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_status')->insert([
            ['name' => 'waiting', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['name' => 'processing', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['name' => 'shipped', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['name' => 'delivered', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['name' => 'canceled', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
        ]);
    }
}
