<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpeechRequest extends FormRequest
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
            'title' => 'required|string|max:150',
            'summary' => 'required|string',
            'transcription' => 'nullable|string',
            'url' => 'required|string|max:250',
            'cover_photo' => 'nullable|string|max:250',
            'speaker_id' => 'required|integer|exists:speakers,id',
            'topic_id' => 'nullable|integer|exists:topics,id',
            'tags' => 'sometimes|array'
        ];
    }
}
