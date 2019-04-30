<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO: Paginate results
        $tags = Tag::get();

        return response()->json([
            'data' => $tags
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $tag = Tag::firstOrCreate(
                ['slug' => str_slug($name)],
                [
                    'name' => $name,
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModelsTag  $modelsTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $tag->name = $request->name;
        $tag->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModelsTag  $modelsTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([
            'data' => 'Tag removed successfully'
        ], 201);
    }
}
