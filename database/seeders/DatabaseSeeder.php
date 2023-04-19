<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Abdallah Mohamed',
            'email' => 'abdal_cascad@hotmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);
    }
}
