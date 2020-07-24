<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganization extends FormRequest
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
            'name' => ['required', 'unique:organizations,name'],
            'digital_address' => ['required', 'min:10'],
            'phone_number' => ['required', 'min:10'],
            'about' => ['required', 'min:10'],
            'logo_url' => ['nullable|string']
        ];
    }
}
