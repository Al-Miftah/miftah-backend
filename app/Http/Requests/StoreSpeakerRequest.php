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
            'name' => 'required|max:150',
            'phone' => 'required|max:150',
            'email' => ['string', 'email', 'max:255', 'unique:speakers'],
            'address' => 'required|string|max:150',
            'avatar' => 'image|mimes:jpeg,png',
            'bio'   => 'String|max:255'
        ];
    }
}
