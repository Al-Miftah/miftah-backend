<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpeakerRequest extends FormRequest
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
            'first_name' => 'filled|string|max:150',
            'last_name' => 'filled|string|max:150',
            'phone_number' => 'filled|string|min:10|max:20',
            'email' => 'filled|email|max:150',
            'location_address' => 'filled|max:100',
            'avatar' => 'filled|image:jpeg,png',
            'bio' => 'filled|string',
            'city' => 'filled|string',
        ];
    }
}
