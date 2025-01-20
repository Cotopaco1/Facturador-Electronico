<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  =>  'required|string',
            'price' =>  'required|decimal:0,2',
            'unit_measure_id' => 'required|integer|exists:unit_measures,id',
            'is_excluded'     => 'required|boolean',
            'tribute_id'      => 'required|integer|exists:tributes,id',
            'tax_rate'        => 'required|string',
            //
        ];
    }
}
