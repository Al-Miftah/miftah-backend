<?php

namespace App\Http\Controllers;


use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\TagCollection;
use App\Http\Resources\Detail\TagResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class TagController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * List tags
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return new TagCollection(Tag::paginate(30));
    }

    /**
     * View a tag
     *
     * @param Request $request
     * @param Tag $tag
     * @return void
     */
    public function show(Request $request, Tag $tag)
    {
        return new TagResource($tag->load('speeches'));
    }

    /**
     * Create a new tag
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Create Tag'), 403, 'You are not authorized to perfrom this action');
        $tags = $request->input('tags');
        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tag)],
                [
                    'name' => $tag,
                ]
            );
        }

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'Tags created successfully!'
            ]
        ]);
    }


    /**
     * Update a tag
     *
     * @param Request $request
     * @param Tag $tag
     * @return void
     */
    public function update(Request $request, Tag $tag)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Update Tag'), 403, 'You are not authorized to perform this action');
        $tag->name = $request->name;
        $tag->save();
        return new TagResource($tag);
    }


    /**
     * Delete a tag
     *
     * @param Tag $tag
     * @return void
     */
    public function destroy(Tag $tag)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Delete Tag'), 403, 'You are not authorized to perform this action');
        $tag->delete();
        return response()->noContent(204);
    }
}
