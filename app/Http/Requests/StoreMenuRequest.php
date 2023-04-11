<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|regex:/^\d{1,6}(\.\d{1,2})?$/'
        ];
    }
	
	public function messages()
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => 'name']),
            'description.required' => trans('validation.required', ['attribute' => 'description']),
            'price.required' => trans('validation.required', ['attribute' => 'price']),
            'price.regex' => trans('headers.regexPrice', ['attribute' => 'price'])
        ];
    }
}