<?php

namespace App\Http\Controllers;

use App\Models\Speech;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSpeechRequest;
use App\Http\Requests\UpdateSpeechRequest;
use App\Http\Resources\SpeechCollection;
use App\Http\Resources\SpeechResource;

class SpeechController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        //
    }

    public function index()
    {
        $speeches = Speech::paginate(10);
        return new SpeechCollection($speeches);
    }


    public function store(StoreSpeechRequest $request)
    {
        $input = $request->only(['title', 'summary', 'speaker_id', 'topic_id', 'language_id']);
        $speech = new Speech($input);

        //Upload speech audio
        $file = $request->file('speech');
        $folder = 'public/uploads/speeches/audio';
        if (app()->environment(['staging', 'production'])) {
            $folder = 'uploads/speeches/audio';
        }
        $path = $this->upload($file, $folder);
        $speech->url = $path;

        //Upload cover_photo
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $folder = 'public/uploads/speeches/photos';
            if (app()->environment(['staging', 'production'])) {
                $folder = 'uploads/speeches/photos';
            }
            $path = $this->upload($file, $folder);
            $speech->cover_photo = $path;
        }
        //Save speech
        $speech->save();

        return new SpeechResource($speech);
    }

    public function show(Speech $speech)
    {
        $data = $speech->load('speaker', 'language');
        return new SpeechResource($data);
    }



    public function update(UpdateSpeechRequest $request, Speech $speech)
    {
        $input = $request->only('title', 'summary', 'transcription', 'speaker_id', 'topic_id', 'language_id');
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $folder = 'public/uploads/speeches/photos';
            if (app()->environment(['staging', 'production'])) {
                $folder = 'uploads/speeches/photos';
            }
            $path = $this->upload($file, $folder);
            $input['cover_photo'] = $path;
        }
        $speech->update($input);
        return new SpeechResource($speech->fresh());
    }

    public function destroy(Request $request, Speech $speech)
    {
        if ($request->permanent) {
            $speech->forceDelete();
        }else {
            $speech->delete();
        }
        return response()->noContent(204);
    }
}
