<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class StoreDonation extends FormRequest
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
            'transaction_reference' => ['required', 'string', 'unique:donations'],
            'gateway' => ['required', 'string'],
            'amount' => ['required'],
            'currency' => ['required', Rule::in(['GHS', 'USD', 'GBP'])],
            'channel' => ['required', Rule::in(['card', 'mobile_money', 'cash', 'bank'])],
            'additional_information' => ['nullable', 'string', 'min:10'],
            'user_id' => ['nullable', 'exists:users,id'],
            'organization_id' => ['required', 'exists:organizations,id'],
        ];
    }
}
