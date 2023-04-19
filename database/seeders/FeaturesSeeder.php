<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $standardFeatures = [
            ['name' => '1 user account', 'max_amount' => 1],
            ['name' => '10 employees', 'max_amount' => 10],
            ['name' => 'Email support'],
            ['name' => 'Help center access'],
        ];

        $deluxeFeatures = [
            ['name' => '5 user accounts', 'max_amount' => 5],
            ['name' => '50 employees', 'max_amount' => 50],
            ['name' => 'Priority email support'],
            ['name' => 'Help center access'],
            ['name' => 'Phone support'],
            ['name' => 'Basic analytics and reporting'],
        ];

        $premiumFeatures = [
            ['name' => 'Unlimited user accounts'],
            ['name' => 'Unlimited employees'],
            ['name' => 'Priority email and phone support'],
            ['name' => 'Help center access'],
            ['name' => 'Advanced analytics and reporting'],
            ['name' => 'Customizable dashboard'],
            ['name' => 'API access'],
        ];

        // Assuming you have created plans with the same names as mentioned above
        $standardPlan = Plan::where('name', 'Standard')->first();
        $deluxePlan = Plan::where('name', 'Deluxe')->first();
        $premiumPlan = Plan::where('name', 'Premium')->first();

        // Attach the features to the respective plans
        foreach ($standardFeatures as $featureData) {
            $feature = Feature::create($featureData);
            $standardPlan->features()->attach($feature);
        }

        foreach ($deluxeFeatures as $featureData) {
            $feature = Feature::create($featureData);
            $deluxePlan->features()->attach($feature);
        }

        foreach ($premiumFeatures as $featureData) {
            $feature = Feature::create($featureData);
            $premiumPlan->features()->attach($feature);
        }
    }
}
