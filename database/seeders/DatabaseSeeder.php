<?php

namespace Database\Seeders;

use App\Models\Information;
use App\Models\User;
use App\Models\Wage;
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
        // Veritabanı SQL Seederları
        $this->call([RolePermissionSeeder::class, ObjectiveSeeder::class,  CompanySeeder::class, ProductSeeder::class, FileDataSeeder::class, ListPriceSeeder::class, StockSeeder::class,  StockLimitSeeder::class]);

        $information = Information::create([
            "name" => "Karaca",
            "surname" => "Admin",
            "birthday" => "2021-08-11"
        ]);

        $user = User::create([
            "user_name" => "admin",
            "company_id" => 1,
            "email" => "admin@gmail.com",
            "information_id" => $information->id,
            "password" => '$2a$12$sazfKZCa1bfABRrYCRRlk.VSkCxlppxSCTkwOzpIvQmM.Uqp.cdD6' // 123123123
        ]);

        $user->assignRole("admin");

        $wage = Wage::create([
            "wage_date" => "2021-08-11",
            "user_id" => $user->id,
            "wage_price" => "4250",
            "status" => "1",
        ]);
    }
}
