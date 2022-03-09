<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function modul_name()
    {
        return [
            'name' => 'yetki adi',
            'guard_name' => 'web',
            'title' => 'Yetki Görünecek Adı'
        ];
    }


    public function run()
    {
        $modules = [];
        // array_push($modules, $this->modul_name());

        array_push($modules, $this->modul_name());
    }
}
