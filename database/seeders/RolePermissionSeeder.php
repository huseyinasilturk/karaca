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

            // Personel yetkileri
            $this->getPermissionArr("person.add", "Kullanıcı Ekle"),
            $this->getPermissionArr("person.read", "Kullanıcı Oku"),
            $this->getPermissionArr("person.update", "Kullanıcı Güncelle"),
            $this->getPermissionArr("person.delete", "Kullanıcı Sil"),
            $this->getPermissionArr("person.wage", "Kullanıcı Maaşı Ayarla"),
            $this->getPermissionArr("person.export", "Kullanıcı Çıktı Al"),

            // Gelir Gider yetkileri
            $this->getPermissionArr("expense.read", "Gider Oku"),
            $this->getPermissionArr("expense.delete", "Gider Sil"),
            $this->getPermissionArr("income.read", "Gelir Oku"),
            $this->getPermissionArr("income.delete", "Gelir Sil"),

            // Stok yetkileri
            $this->getPermissionArr("stock.add", "Stok Ekle"),
            $this->getPermissionArr("stock.sell", "Satış"),
            $this->getPermissionArr("stock.transfer", "Stok Aktar"),
            $this->getPermissionArr("stockLimit.read", "Stok Limiti Oku"),
            $this->getPermissionArr("stockLimit.add", "Stok Limiti Ekle"),
            $this->getPermissionArr("stockLimit.update", "Stok Limiti Güncelle"),
            $this->getPermissionArr("stockLimit.delete", "Stok Limiti Sil"),

            // Ürün yetkileri
            $this->getPermissionArr("product.read", "Ürün Oku"),
            $this->getPermissionArr("product.add", "Ürün Ekle"),
            $this->getPermissionArr("product.update", "Ürün Güncelle"),
            $this->getPermissionArr("product.delete", "Ürün Sil"),

            // İzin yetkileri
            $this->getPermissionArr("dayoff.read", "İzin Oku"),
            $this->getPermissionArr("dayoff.add", "İzin Ekle"),
            $this->getPermissionArr("dayoff.update", "İzin Güncelle"),
            $this->getPermissionArr("dayoff.delete", "İzin Sil"),

            // Müşteri yetkileri
            $this->getPermissionArr("customer.read", "Müşteri Oku"),
            $this->getPermissionArr("customer.add", "Müşteri Ekle"),
            $this->getPermissionArr("customer.update", "Müşteri Güncelle"),
            $this->getPermissionArr("customer.delete", "Müşteri Sil"),

            // Müşteri yetkileri
            $this->getPermissionArr("reminder.read", "Hatırlatıcı Oku"),
            $this->getPermissionArr("reminder.add", "Hatırlatıcı Ekle"),
            $this->getPermissionArr("reminder.update", "Hatırlatıcı Güncelle"),
            $this->getPermissionArr("reminder.delete", "Hatırlatıcı Sil"),

            // Nesne yetkileri
            $this->getPermissionArr("objective.read", "Nesne Oku"),


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
                    "objective.read"
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
                    "objective.read"
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
