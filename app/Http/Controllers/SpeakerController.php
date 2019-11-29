<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use App\Http\Resources\SpeakerResource;
use App\Http\Resources\SpeakerCollection;
use App\Http\Requests\UpdateSpeakerRequest;
use App\Http\Requests\RegisterSpeakerRequest;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $speakers = Speaker::paginate(10);
        return new SpeakerCollection($speakers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterSpeakerRequest $request)
    {
        $input = $request->only('first_name', 'last_name', 'email', 'location_address', 'phone_number', 'city', 'address', 'bio');
        $input['password'] = bcrypt($request->password);
        $speaker = Speaker::create($input);

        return new SpeakerResource($speaker);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpeakerRequest $request, Speaker $speaker)
    {
        $input = $request->only('first_name', 'last_name', 'email', 'location_address', 'phone_number', 'city', 'address', 'bio');
        $speaker->update($input);
        return new SpeakerResource($speaker->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Speaker $speaker)
    {
        if ($request->permanent) {
            $speaker->forceDelete();
        }else {
            $speaker->delete();
        }
        return response()->noContent(204);
    }
}
