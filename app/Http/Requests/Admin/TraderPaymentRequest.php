<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TraderPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trader_id' => 'required|exists:traders,id',
            'date' => 'required|date',
            'type' => 'required|in:1,2,3',
            'cash' => 'required|numeric',
            'cheque' => 'required|numeric',
            'notes' => 'nullable|max:500',
        ];
    }
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $cash = $this->input('cash');
    //         $cheque = $this->input('cheque');
    //         $amount = $this->input('amount');

    //         if (($cash + $cheque) != $amount) {
    //             $validator->errors()->add('amount', 'مجموع النقدي والغير نقدي لابد أن يساوي المبلغ الكلي.');
    //         }
    //     });
    // }
}
