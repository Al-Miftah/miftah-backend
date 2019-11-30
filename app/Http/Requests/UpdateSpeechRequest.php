<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpeechRequest extends FormRequest
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
            'title' => 'filled|string|max:150',
            'summary' => 'filled|string',
            'transcription' => 'filled|nullable|string',
            'speech' => 'filled|file|mimetypes:audio/mpeg,audio/mp4,audio/ogg,audio/wave,audio/3gpp,audio/ac3,audio/basic,audio/midi',
            'cover_photo' => 'filled|nullable|image|max:200',
            'speaker_id' => 'filled|integer|exists:speakers,id',
            'topic_id' => 'filled|nullable|integer|exists:topics,id',
            'language_id' => 'filled|integer|exists:languages,id'
        ];
    }
}
