<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSpeakerRequest extends FormRequest
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone_number' => 'required|string|min:10|max:20',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
            'location_address' => 'required|string|max:50',
            'city' => 'required|string|max:20',
            'bio' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,bmp,png'
        ];
    }
}
