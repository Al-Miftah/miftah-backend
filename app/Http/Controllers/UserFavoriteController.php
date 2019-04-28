<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Speech};

class UserFavoriteController extends Controller
{
    public function __construct()
    {
        //
    }
    /**
     * List all user favorites
     */
    public function index(Request $request, User $user)
    {
        $favorites = $user->favorites()->paginate(10);
        return response()->json([
            'data' => $favorites
        ], 200);
    }

    //User add a new favorite
    public function store(Request $request, User $user, Speech $speech)
    {

        $user->favorites()->attach($speech->id);
        $favorites = $user->favorites()->paginate(10);

        return response()->json([
            'data' => $favorites
        ], 200);
    }

    //User remove a favorite
    public function destroy(Request $request, User $user, Speech $speech)
    {
        $user->favorites()->attach($speech->id);
        $favorites = $user->favorites()->paginate(10);
        
        return response()->json([
            'data' => $favorites
        ], 200);
    }
}
