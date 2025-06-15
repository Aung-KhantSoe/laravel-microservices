<?php

namespace Database\Seeders;

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
        // Create 10 users, each with 1-5 contracts
        \App\Models\User::factory()
            ->count(10)
            ->has(
                \App\Models\Contract::factory()
                    ->count(rand(1, 5))
            ) // This closing parenthesis was missing
            ->create();

        // Create some additional contracts with specific states
        \App\Models\Contract::factory()
            ->count(3)
            ->draft()
            ->create();

        \App\Models\Contract::factory()
            ->count(5)
            ->active()
            ->create();

        \App\Models\Contract::factory()
            ->count(2)
            ->expired()
            ->create();

        \App\Models\Contract::factory()
            ->count(2)
            ->terminated()
            ->create();
    }
}
