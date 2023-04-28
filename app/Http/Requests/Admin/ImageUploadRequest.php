<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
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
            'image' => 'required|image|max:2048|unique:images',
        ];
    }
	
/*	public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => 'name']),
            'image.required' => __('validation.required', ['attribute' => 'image']),
            'image.max' => __('validation.max.file', ['attribute' => 'image'])
        ];
    }*/
}
