<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $controllers = [
            'المستخدمين' => 4, // Only first action
            'الأدوار' => 4, // First two actions
            'تصنيفات التجار' => 4, // First three actions
            'بيانات المناديب' => 4, // First four actions
            'طلبات المناديب' => 4, // All five actions
            'بيانات التجار' => 4,
            'طلبات التجار' => 3,
            'المحافظات' => 4,
            'المدن' => 4,
            'أسعار الشحن' => 4,
            'طلبات بوصلة' => 4,
            'الطلبات المحولة للمناديب' => 4,
            'طلبات قيد التحصيل' => 3,
            'طلبات قيد المرتجعات' => 3,
            'الطلبات المؤجلة' => 3,
            'الشحن عالراسل' => 3,
            'طلبات تحت التنفيذ' => 3,
            'يومية الطلبات' => 1,
            'الإعدادت العامة' => 2,
            'سجل عمليات النظام' => 1,
            'التحصيلات' => 1,
            'المرتجعات' => 1,
            'حسابات المندوب' => 1,
            'تقرير تنفيذات المندوب' => 1,
            'الاعدادات الإدارية' => 4,
            'المصروفات' => 4,
            'تسديدات التجار' => 4,
            'تقارير أرصدة التجار' => 1,
            'الطلبات الملغاه' => 4,
            'الخزينة' => 1,
            'تسديدات الوكلاء' => 4,
            'أسعار شحن الوكلاء' => 4,
            'الرصيد الافتتاحي' => 4,
            'السلايدر'=> 4,
            'الصفحات الثابتة'=> 4,
            'السمات'=> 4,
            'الخدمات'=> 4,
            'العمليات'=> 4,
            'الفيديوهات'=> 4,
            'الاحصائيات'=> 4,
            'أعضاء الفريق'=> 4,
        ];

        $actions = ['عرض', 'تعديل', 'حذف', 'إنشاء'];

        foreach ($controllers as $controller => $actionCount) {
            // Ensure actionCount is valid (between 1 and 5)
            $actionCount = max(1, min(4, $actionCount));

            // Get only the specified number of actions
            $controllerActions = array_slice($actions, 0, $actionCount);

            foreach ($controllerActions as $action) {
                Permission::updateOrCreate(
                    ['name' => "{$action} {$controller}"],
                    [
                        'name' => "{$action} {$controller}",
                        'group' => $controller,
                        'guard_name' => 'admin',
                    ]
                );
            }
        }

    }
}
