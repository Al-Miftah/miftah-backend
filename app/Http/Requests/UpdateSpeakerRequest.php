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
            'name' => 'filled|string|max:150',
            'phone' => 'filled|string|max:20',
            'email' => 'filled|email|max:150',
            'address' => 'filled|max:150',
            'avatar' => 'filled|image:jpeg,png',
            'bio' => 'filled|string|max:255'
        ];
    }
}
