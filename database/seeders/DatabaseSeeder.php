<?php

namespace Database\Seeders;

use App\Models\Information;
use App\Models\User;
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
        $this->call([RolePermissionSeeder::class]);

        $information = Information::create([
            "name" => "Karaca",
            "surname" => "Admin",
            "birthday" => "2021-08-11"
        ]);

        $user = User::create([
            "user_name" => "admin",
            "email" => "admin@gmail.com",
            "information_id" => $information->id,
            "password" => '$2a$12$sazfKZCa1bfABRrYCRRlk.VSkCxlppxSCTkwOzpIvQmM.Uqp.cdD6' // 123123123
        ]);

        $user->assignRole("admin");

        // $user->givePermissionTo('*.create,update,view');

        // Veritabanı SQL Seederları
        // $this->call([CountryCitySeeder::class, ObjectiveSeeder::class, ModuleSeeder::class, AddressSeeder::class, AddressAtCompanySeeder::class, CompanySeeder::class, ContactAtCompanySeeder::class]);
    }
}
