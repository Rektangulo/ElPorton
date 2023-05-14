<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\ReservationDateService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;

class ReservationRequest extends FormRequest
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
			'name' => 'required',
			'email' => 'required|email',
			'number' => 'required|numeric|digits_between:7,15',
			'guest_count' => 'required|numeric|digits_between:1,20',
			'time' => 'required|in:lunch,dinner',
			'date' => [
				'required',
				'date_format:d/m/Y',
				'after:today',
				'before:2 months',
				function ($attribute, $value, $fail) {
					$time = $this->input('time');
					if (ReservationDateService::isReservationLimitReached($value, $time)) {
						$fail(__('front.reservation_limit_reached'));
					}
				},
			],
			'message' => 'nullable|string|max:60000',
		];
    }
	
	protected function failedValidation(Validator $validator): RedirectResponse
	{
		if ($validator->errors()->has('date')) {
			throw new HttpResponseException(
				redirect('/reservation')->withErrors($validator)->withInput()
			);
		}

		parent::failedValidation($validator);
	}
}
