<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AgentPaymentRequest extends FormRequest
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
            'agent_id' => 'required|exists:deliveries,id',
            'date' => 'required|date',
            'type' => 'required|in:1,2,3',
            'cash' => 'required|numeric',
            'cheque' => 'required|numeric',
            'notes' => 'nullable|max:500',
        ];

    }
}
