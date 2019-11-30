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
            'speech' => 'required|file|mimetypes:audio/mpeg,audio/mp4,audio/ogg,audio/wave,audio/3gpp,audio/ac3,audio/basic,audio/midi',
            'cover_photo' => 'nullable|image|max:200',
            'speaker_id' => 'required|integer|exists:speakers,id',
            'topic_id' => 'nullable|integer|exists:topics,id',
            'language_id' => 'required|integer|exists:languages,id',
            'tags' => 'sometimes|array'
        ];
    }
}
