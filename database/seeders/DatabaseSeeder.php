<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('users')->insert([
            ['name' => 'Jonathan', 'email' => 'jonmartindell@yahoo.com', 'password' => '$2y$12$JQOlhnsPUcEGnU6zyTuh8eZsHW8k/m8nSmhTWia5drRPHL5ZgBa1S'],
            ['name' => 'Sherry', 'email' => 'sherrymartindell@gmail.com', 'password' => '$2y$12$JQOlhnsPUcEGnU6zyTuh8eZsHW8k/m8nSmhTWia5drRPHL5ZgBa1S'],
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('categories')->insert([
            // income
            ['name' => 'MHC', 'heading' => 'Jonathan', 'budget' => 4250, 'infrequent' => false, 'expense' => false, 'sort' => 1.1],
            ['name' => 'PHS', 'heading' => 'Sherry', 'budget' => 4500, 'infrequent' => false, 'expense' => false, 'sort' => 1.2],
            ['name' => 'Prosper', 'heading' => 'Sherry', 'budget' => 1050, 'infrequent' => false, 'expense' => false, 'sort' => 1.3],
            ['name' => 'Misc (gfts/rfnd)', 'heading' => 'Misc', 'budget' => 0, 'infrequent' => false, 'expense' => false, 'sort' => 1.4],
            // expenses ['name' => 'NAME', 'heading' => 'HEADING', 'budget' => 0000, 'sort' => 0.0, 'infrequent' => false, 'expense' => true],
            ['name' => 'Tithe', 'heading' => 'Giving', 'budget' => 500, 'infrequent' => false, 'expense' => true, 'sort' => 2.1],
            ['name' => 'Gifts', 'heading' => 'Giving', 'budget' => 800, 'infrequent' => true, 'expense' => true, 'sort' => 2.3],
            ['name' => 'Mortgage', 'heading' => 'Housing', 'budget' => 2100, 'infrequent' => false, 'expense' => true, 'sort' => 3.1],
            ['name' => 'Home Maintenance', 'heading' => 'Housing', 'budget' => 700, 'sort' => 3.2, 'infrequent' => true, 'expense' => true],
            ['name' => 'Household Supplies', 'heading' => 'Housing', 'budget' => 275, 'sort' => 3.3, 'infrequent' => false, 'expense' => true],
            ['name' => 'Furniture', 'heading' => 'Housing', 'budget' => 90, 'sort' => 3.4, 'infrequent' => true, 'expense' => true],
            ['name' => 'Utilities', 'heading' => 'Housing', 'budget' => 400, 'sort' => 3.5, 'infrequent' => false, 'expense' => true],
            ['name' => 'Internet', 'heading' => 'Housing', 'budget' => 81, 'sort' => 3.6, 'infrequent' => false, 'expense' => true],
            ['name' => 'Cell Phones', 'heading' => 'Housing', 'budget' => 110, 'sort' => 3.7, 'infrequent' => true, 'expense' => true],
            ['name' => 'Fuel', 'heading' => 'Transportation', 'budget' => 200, 'sort' => 4.1, 'infrequent' => false, 'expense' => true],
            ['name' => 'Car Maintenance', 'heading' => 'Transportation', 'budget' => 300, 'sort' => 4.2, 'infrequent' => true, 'expense' => true],
            ['name' => 'Groceries', 'heading' => 'Food', 'budget' => 1750, 'sort' => 5.1, 'infrequent' => false, 'expense' => true],
            ['name' => 'Restaurants', 'heading' => 'Food', 'budget' => 250, 'sort' => 5.2, 'infrequent' => false, 'expense' => true],
            ['name' => 'Kid Clothes/Shoes', 'heading' => 'Lifestyle', 'budget' => 250, 'sort' => 6.1, 'infrequent' => true, 'expense' => true],
            ['name' => 'Kids Extracurricular', 'heading' => 'Lifestyle', 'budget' => 700, 'sort' => 6.2, 'infrequent' => true, 'expense' => true],
            ['name' => 'Fitness', 'heading' => 'Lifestyle', 'budget' => 250, 'sort' => 6.3, 'infrequent' => false, 'expense' => true],
            ['name' => 'Allowance', 'heading' => 'Lifestyle', 'budget' => 100, 'sort' => 6.4, 'infrequent' => false, 'expense' => true],
            ['name' => 'Health Insurance', 'heading' => 'Insurance', 'budget' => 50, 'sort' => 7.1, 'infrequent' => true, 'expense' => true],
            ['name' => 'Life Insurance', 'heading' => 'Insurance', 'budget' => 92, 'sort' => 7.2, 'infrequent' => false, 'expense' => true],
            ['name' => 'Car Insurance/Fees', 'heading' => 'Insurance', 'budget' => 60, 'sort' => 7.3, 'infrequent' => true, 'expense' => true],
            ['name' => 'Student Loans', 'heading' => 'Debt', 'budget' => 210, 'sort' => 8.0, 'infrequent' => false, 'expense' => true],
            ['name' => 'License Fee/Insurance', 'heading' => 'Business', 'budget' => 165, 'sort' => 9.0, 'infrequent' => true, 'expense' => true],
            ['name' => 'Taxes', 'heading' => 'Business', 'budget' => 700, 'sort' => 9.1, 'infrequent' => true, 'expense' => true],
            ['name' => 'Videos/CDs/Books', 'heading' => 'Entertainment', 'budget' => 75, 'sort' => 10.0, 'infrequent' => false, 'expense' => true],
            ['name' => 'PC Parts/Electronics', 'heading' => 'Entertainment', 'budget' => 25, 'sort' => 10.1, 'infrequent' => true, 'expense' => true],
            ['name' => 'Cards', 'heading' => 'Entertainment', 'budget' => 25, 'sort' => 10.2, 'infrequent' => true, 'expense' => true],
            ['name' => 'Date Night', 'heading' => 'Entertainment', 'budget' => 130, 'sort' => 10.3, 'infrequent' => false, 'expense' => true],
            ['name' => 'Vacation', 'heading' => 'Entertainment', 'budget' => 350, 'sort' => 10.4, 'infrequent' => true, 'expense' => true],
            ['name' => 'Pets', 'heading' => 'Misc', 'budget' => 250, 'sort' => 11.0, 'infrequent' => false, 'expense' => true],
            ['name' => 'J Personal', 'heading' => 'Misc', 'budget' => 300, 'sort' => 11.1, 'infrequent' => false, 'expense' => true],
            ['name' => 'S Personal', 'heading' => 'Misc', 'budget' => 300, 'sort' => 11.2, 'infrequent' => false, 'expense' => true],

        ]);
    }
}
