<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'عرض الصلاحيات',
            'اضافة صلاحيه',
            'تعديل صلاحيه',
            'حذف الصلاحيه',
            'عرض القطاعات',
            'اضافة قطاع',
            'تعديل قطاع',
            'حذف قطاع',
            'تفاصيل القطاع',
            'عرض الشارات',
            'اضافة شارة',
            'تعديل شارة',
            'حذف شارة',
            'عرض افراد',
            'اضافة فرد',
            'تعديل فرد',
            'صلاحيه الدخول',
            'حذف فرد',
            'استيراد اكسيل',
            'عرض الحضور',
            'اضافة حضور',
            'تعديل حضور',
            'حذف حضور',
            'ملاحظات',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
