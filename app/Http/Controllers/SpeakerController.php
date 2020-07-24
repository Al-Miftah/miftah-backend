<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use App\Http\Resources\SpeakerCollection;
use App\Http\Requests\UpdateSpeakerRequest;
use App\Http\Requests\RegisterSpeakerRequest;
use App\Http\Resources\Detail\SpeakerResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class SpeakerController extends Controller
{
    /**
     * Constructor
     *
     * 
     */ 
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //If client wants simple list for populating dropdowns
        if ($request->has('pagination') && $request->query('pagination') == false) {
            $speakers = Speaker::get(['id', 'name']);
            return response()->json([
                'data' => $speakers
            ]);
        }
        $speakers = Speaker::paginate(30);
        return new SpeakerCollection($speakers);
    }

    /**
     * View details of a speaker
     *
     * @param Request $request
     * @param Speaker $speaker
     * @return void
     */
    public function show(Request $request, Speaker $speaker)
    {
        return new SpeakerResource($speaker);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterSpeakerRequest $request)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Create Speaker', 'api'), 403);

        $input = $request->only('first_name', 'last_name', 'email', 'avatar', 'location_address', 'phone_number', 'city', 'bio');
        $input['password'] = bcrypt($request->password);
        Speaker::create($input);

        return response()->json([
            'error' => false,
            'message' => 'Speaker account created successfully!',
        ], 201);
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
        $admin = auth('api')->user();
        abort_unless($admin->can('Update Speaker', 'api'), 403);

        $input = $request->only('first_name', 'last_name', 'email', 'avatar', 'location_address', 'phone_number', 'city', 'bio');
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
        $admin = auth('api')->user();
        if ($request->permanent) {
            abort_unless($admin->can('Force delete Speaker'), 403);
            $speaker->forceDelete();
        }else {
            abort_unless($admin->can('Delete Speaker', 'api') || $admin->can('Force delete Speaker', 'api'), 403);
            $speaker->delete();
        }
        return response()->noContent(204);
    }
}
