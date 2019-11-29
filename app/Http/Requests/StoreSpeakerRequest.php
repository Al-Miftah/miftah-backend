<?php

namespace App\Http\Requests;

//use Illuminate\Foundation\Http\FormRequest;

class StoreSpeakerRequest extends FormRequest //Extending custom FormRequest
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
            'phone' => 'required|max:150',
            'city' => 'required|max:50',
            'address' => 'required|string|max:50',
            'avatar' => 'image|mimes:jpeg,png',
            'bio'   => 'String|max:255'
        ];
    }
}
