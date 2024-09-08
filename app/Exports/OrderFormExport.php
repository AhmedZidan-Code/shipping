<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderFormExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Return an empty array with only headers
        return [];
    }

    public function headings(): array
    {
        return [
            'رقم المدينة',
            'اسم العميل',
            'عنوان العميل',
            'هاتف العميل',
            'قيمة المندوب',
            'قيمة التوصيل',
            'عدد القطع داخل الشحن',
            'قيمة الاوردر',
            'ملاحظات',
        ];
    }

}
