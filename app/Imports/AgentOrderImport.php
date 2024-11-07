<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AgentOrderImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
     * Define the validation rules for each row.
     */
    public function rules(): array
    {
        return [
            $this->mapData('status') => 'required|string|max:255|in:new,converted_to_delivery,total_delivery_to_customer,partial_delivery_to_customer,not_delivery,under_implementation,cancel,delaying,collection,paid,shipping_on_messanger',
            $this->mapData('customer_address') => 'required|string|max:255',
            $this->mapData('customer_name') => 'required|string|max:255',
            $this->mapData('customer_phone') => 'required',
            $this->mapData('delivery_ratio') => 'nullable|numeric',
            $this->mapData('delivery_value') => 'nullable|numeric',
            $this->mapData('province_id') => 'nullable|integer',
            $this->mapData('shipment_pieces_number') => 'nullable|integer',
            $this->mapData('shipment_value') => 'nullable|numeric',
            $this->mapData('notes') => 'nullable',
            $this->mapData('total') => 'required|numeric',
        ];
    }
/**
 * @return array
 */
    public function customValidationAttributes()
    {
        return [
            $this->mapData('status') => 'حالة الطلب',
            $this->mapData('province_id') => 'رقم المدينة',
            $this->mapData('customer_address') => 'عنوان العميل',
            $this->mapData('customer_name') => 'اسم العميل',
            $this->mapData('customer_phone') => 'هاتف العميل',
            $this->mapData('delivery_ratio') => 'قيمة المندوب',
            $this->mapData('delivery_value') => 'قيمة التوصيل',
            $this->mapData('shipment_pieces_number') => 'عدد القطع داخل الشحن',
            $this->mapData('shipment_value') => 'قيمة الاوردر',
            $this->mapData('notes') => 'ملاحظات',
            $this->mapData('total') => 'الاجمالي',
        ];
    }
    /**
     * Process each valid row and create an Order.
     */
    public function collection(Collection $rows)
    {
    }

    public function mapData($key)
    {
        $data = [
            'status' => "hal_altlb",
            'province_id' => "rkm_almdyn",
            'customer_name' => "asm_alaamyl",
            'customer_address' => "aanoan_alaamyl",
            'customer_phone' => "hatf_alaamyl",
            'delivery_ratio' => "kym_almndob",
            'delivery_value' => "kym_altosyl",
            'shipment_pieces_number' => "aadd_alktaa_dakhl_alshhn",
            'shipment_value' => "kym_alaordr",
            'notes' => "mlahthat",
            'total' => "alagmaly",
        ];
        return $data[$key];
    }
}
