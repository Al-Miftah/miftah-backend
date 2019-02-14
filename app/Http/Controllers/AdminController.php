<?php

/**
 * A temporal controller for handling dashboard actions
 * 
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Language, Speaker, Speech, Topic, User};

class AdminController extends Controller
{
    public function listSpeakers(Request $request)
    {
        $speakers = Speaker::get();
        return view('speakers.index', compact('speakers'));
    }

    public function listTopics(Request $request)
    {
        $topics = Topic::get();
        return view('topics.index', compact('topics'));
    }

    public function listSpeeches(Request $request)
    {
        $speeches = Speech::get();
        return view('speeches.index', compact('speeches'));
    }

    public function listLanguages(Request $request)
    {
        $speeches = Language::get();
        return view('languages.index', compact('languages'));
    }

    public function listUsers(Request $request)
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }
    
}
