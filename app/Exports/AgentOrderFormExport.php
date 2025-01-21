<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class AgentOrderFormExport implements WithHeadings, WithEvents, WithStrictNullComparison
{
    // Define the headings for the columns
    public function headings(): array
    {
        return [
            'حالة الطلب',
            'رقم المدينة',
            'اسم العميل',
            'عنوان العميل',
            'هاتف العميل',
            'قيمة المندوب',
            'قيمة التوصيل',
            'عدد القطع داخل الشحن',
            'قيمة الاوردر',
            'ملاحظات',
            'الاجمالي',
        ];

    }

    // Register events to manipulate the sheet after it's generated
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $drop_column = 'A'; // Column 'A' where dropdown will be applied
                $row_start = 2; // Start applying dropdown from row 2 (below headings)

                // Define the dropdown options
                $options = [
                    'new',
                    'converted_to_delivery',
                    'total_delivery_to_customer',
                    'partial_delivery_to_customer',
                    'not_delivery',
                    'under_implementation',
                    'cancel',
                    'delaying',
                    'collection',
                    'paid',
                    'shipping_on_messanger',
                ];

                // Apply the dropdown options to the first data row (row 2)
                $validation = $event->sheet->getCell("{$drop_column}{$row_start}")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('خطأ');
                $validation->setError('الحالة غير موجودة.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('من فضلك اختر حالة الطلب');
                $validation->setFormula1(sprintf('"%s"', implode(',', $options)));

                // Apply the dropdown to rows starting from row 2
                for ($i = $row_start; $i <= 10000; $i++) { // You can adjust the row range (here it's up to row 100)
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                }
            },
        ];
    }
}
