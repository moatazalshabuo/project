<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>"حذف المسؤولين"]);
        Permission::create(['name'=>"حذف المستخدمين"]);
        Permission::create(['name'=>"تعديل المستخدمين"]);
        Permission::create(['name'=>"اضافة مستخدم"]);
        Permission::create(['name'=>"عرض المستخدمين"]);
        Permission::create(['name'=>"عرض المنتجات"]);
        Permission::create(['name'=>"حذف المنتجات"]);
        Permission::create(['name'=>"تعديل المنتجات"]);
        Permission::create(['name'=>"اضافة منتج"]);
        Permission::create(['name'=>"عرض المواد الخام"]);
        Permission::create(['name'=>"حذف مادة خام"]);
        Permission::create(['name'=>"تعديل مادة خام"]);
        Permission::create(['name'=>"اضافة مادة خام"]);
        Permission::create(['name'=>"فواتير المبيعات"]);
        Permission::create(['name'=>"التنقل بين كل الفواتير المبيعات"]);
        Permission::create(['name'=>"فواتير المشتريات"]);
        Permission::create(['name'=>"التنقل بين كل فواتير المشتريات"]);
        Permission::create(['name'=>"الاعمال"]);
        Permission::create(['name'=>"محاسب"]);
        Permission::create(['name'=>"حذف ايصال"]);
        Permission::create(['name'=>"ادارة العملاء"]);
        Permission::create(['name'=>"اداة الموردين"]);
        Permission::create(['name'=>"تعديل اعدادت النظام"]);
        Permission::create(['name'=>'بيانات الصفحة الرئيسية']);

        $user = User::create([
            'name'=>"admin",
            "email"=>"admin@gmail.com",
            "password"=>Hash::make(12345678),
            "user_type"=>1
        ]);
        $permission = Permission::all();

        foreach ($permission as $value) {
            $user->givePermissionTo($value);
        }
    }
}
