<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrderImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    /**
     * Define the validation rules for each row.
     */
    public function rules(): array
    {
        return [
            $this->mapData('customer_address') => 'required|string|max:255',
            $this->mapData('customer_name') => 'required|string|max:255',
            $this->mapData('customer_phone') => 'required',
            $this->mapData('delivery_ratio') => 'nullable|numeric',
            $this->mapData('delivery_value') => 'nullable|numeric',
            $this->mapData('province_id') => 'nullable|integer',
            $this->mapData('shipment_pieces_number') => 'nullable|integer',
            $this->mapData('shipment_value') => 'nullable|numeric',
            $this->mapData('notes') => 'nullable',
        ];
    }
/**
 * @return array
 */
    public function customValidationAttributes()
    {
        return [
            $this->mapData('province_id') => 'رقم المدينة',
            $this->mapData('customer_address') => 'عنوان العميل',
            $this->mapData('customer_name') => 'اسم العميل',
            $this->mapData('customer_phone') => 'هاتف العميل',
            $this->mapData('delivery_ratio') => 'قيمة المندوب',
            $this->mapData('delivery_value') => 'قيمة التوصيل',
            $this->mapData('shipment_pieces_number') => 'عدد القطع داخل الشحن',
            $this->mapData('shipment_value') => 'قيمة الاوردر',
            $this->mapData('notes') => 'ملاحظات',
        ];
    }
    /**
     * Process each valid row and create an Order.
     */
    public function collection(Collection $rows)
    {
        
         
        if (empty($rows) && $rows->count() == 0) {
            throw new \Exception("The file must contain at least 1 row.");
        }
        foreach ($rows as $row) {
    try {
        Order::create([
            'trader_id' => request('trader_id'),
            'province_id' => $row[$this->mapData('province_id')],
            'customer_name' => $row[$this->mapData('customer_name')],
            'customer_address' => $row[$this->mapData('customer_address')],
            'customer_phone' => $row[$this->mapData('customer_phone')],
            'delivery_ratio' => $row[$this->mapData('delivery_ratio')],
            'delivery_value' => $row[$this->mapData('delivery_value')],
            'shipment_pieces_number' => $row[$this->mapData('shipment_pieces_number')],
            'shipment_value' => $row[$this->mapData('shipment_value')],
            'trader_collection' => $row[$this->mapData('shipment_value')],
            'total_value' => $row[$this->mapData('delivery_value')] + $row[$this->mapData('shipment_value')],
            'notes' => $row[$this->mapData('notes')] ?? '',
        ]);
    } catch (\Exception $e) {
        // Log the error and optionally continue processing the remaining rows
        logger()->error('Error creating order: ' . $e->getMessage(), ['row' => $row]);
        
        // Optionally, rethrow the exception if you want to stop processing
        // throw $e;

        // Or, you can collect errors to provide a summary later
        // $this->errors[] = "Error creating order for row: " . json_encode($row) . " - " . $e->getMessage();
    }
}
    }

    public function mapData($key)
    {
        $data = [
            'province_id' => "rkm_almdyn",
            'customer_name' => "asm_alaamyl",
            'customer_address' => "aanoan_alaamyl",
            'customer_phone' => "hatf_alaamyl",
            'delivery_ratio' => "kym_almndob",
            'delivery_value' => "kym_altosyl",
            'shipment_pieces_number' => "aadd_alktaa_dakhl_alshhn",
            'shipment_value' => "kym_alaordr",
            'notes' => "mlahthat",
        ];
        return $data[$key];
    }
}
