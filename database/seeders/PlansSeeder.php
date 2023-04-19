<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create(['name' =>  'Standard', 'slug' => 'standard', 'price' => 999, 'stripe_plan_id' => 'price_1K8czHCJq494J0ldnn94UVzV']);
        Plan::create(['name' =>  'Deluxe', 'slug' => 'deluxe', 'price' => 1999, 'stripe_plan_id' => 'price_1K8d0XCJq494J0ldkbZR7G6O']);
        Plan::create(['name' =>  'Premium', 'slug' => 'premium', 'price' => 2999, 'stripe_plan_id' => 'price_1K8d1OCJq494J0ldckejqHGH']);
    }
}
