<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganization extends FormRequest
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
            'name' => ['filled', 'string', 'min:5'],
            'digital_address' => ['filled', 'min:10'],
            'phone_number' => ['filled', 'min:10', 'max:25'],
            'about' => ['filled', 'min:10'],
            'logo_url' => ['nullable|string']
        ];
    }
}
