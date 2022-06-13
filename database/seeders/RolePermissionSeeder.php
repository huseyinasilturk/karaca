<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{

    private function getPermissionArr($name, $title)
    {
        return [
            "name" => $name,
            "guard_name" => "web",
            "title" => $title
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Firma yetkileri
            $this->getPermissionArr("company.add", "Firma Ekle"),
            $this->getPermissionArr("company.read", "Firma Oku"),
            $this->getPermissionArr("company.update", "Firma Güncelle"),
            $this->getPermissionArr("company.delete", "Firma Sil"),

            // Ürün yetkileri
            $this->getPermissionArr("product.add", "Ürün Ekle"),
            $this->getPermissionArr("product.read", "Ürün Oku"),
            $this->getPermissionArr("product.update", "Ürün Güncelle"),
            $this->getPermissionArr("product.delete", "Ürün Sil"),

            // Nesne yetkileri
            $this->getPermissionArr("objective.add", "Nesne Ekle"),
            $this->getPermissionArr("objective.read", "Nesne Oku"),
            $this->getPermissionArr("objective.update", "Nesne Güncelle"),
            $this->getPermissionArr("objective.delete", "Nesne Sil"),

            // Personel yetkileri
            $this->getPermissionArr("person.add", "Kullanıcı Ekle"),
            $this->getPermissionArr("person.read", "Kullanıcı Oku"),
            $this->getPermissionArr("person.update", "Kullanıcı Güncelle"),
            $this->getPermissionArr("person.delete", "Kullanıcı Sil"),
            $this->getPermissionArr("person.wage", "Kullanıcı Maaşı Ayarla"),
            $this->getPermissionArr("person.export", "Kullanıcı Çıktı Al")

        ];

        $roles = [
            // Admin rolü
            [
                "name" => "admin",
                "guard_name" => "web",
                "title" => "Admin",
                "permissions" => [
                    "company.add", "company.read", "company.update", "company.delete",
                    "product.add", "product.read", "product.update", "product.delete",
                    "objective.add", "objective.read", "objective.update", "objective.delete",
                ]
            ],
            // Garson rolü
            [
                "name" => "waiter",
                "guard_name" => "web",
                "title" => "Garson",
                "permissions" => [
                    "product.add", "product.read", "product.update", "product.delete",
                ]
            ],
            // İş yeri sahibi rolü
            [
                "name" => "owner",
                "guard_name" => "web",
                "title" => "İş Yeri Sahibi",
                "permissions" => [
                    "company.add", "company.read", "company.update", "company.delete",
                    "product.add", "product.read", "product.update", "product.delete",
                    "objective.add", "objective.read", "objective.update", "objective.delete",
                ]
            ]
        ];

        foreach ($permissions as $permission) {
            $createPermission = Permission::create($permission);
        }

        foreach ($roles as $role) {
            $createRole = Role::create([
                "name" => $role["name"],
                "guard_name" => $role["guard_name"],
                "title" => $role["title"],
            ]);

            $createRole->givePermissionTo($role["permissions"]);
        }
    }
}
