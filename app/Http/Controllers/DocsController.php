<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $menus = [
            [
                'name' => 'Authentication',
                'page' => 'auth',
                'children' => [
                    ['method' => 'POST', 'title' => 'Login', 'page' => 'login'],
                    ['method' => 'POST', 'title' => 'Register', 'page' => 'register'],
                    ['method' => 'GET', 'title' => 'Logout', 'page' => 'logout'],
                ]
            ],
            [
                'name' => 'Profile',
                'page' => 'profile',
                'children' => [
                    ['method' => 'GET', 'title' => 'View profile', 'page' => 'view-profile'],
                    ['method' => 'PATCH', 'title' => 'Update profile', 'page' => 'update-profile'],
                    ['method' => 'POST', 'title' => 'Change password', 'page' => 'change-password'],
                ]
            ],
            [
                'name' => 'Email verification',
                'page' => 'verification',
                'children' => [
                    ['method' => 'POST', 'title' => 'Resend', 'page' => 'resend']
                ]
            ],
            [
                'name' => 'Password reset',
                'page' => 'password',
                'children' => [
                    ['method' => 'GET', 'title' => 'Forgot password', 'page' => 'forgot'],
                    ['method' => 'POST', 'title' => 'Reset', 'page' => 'reset']
                ]
            ]
        ];

        $page = $request->query('page') ?? 'welcome';        
        return view('docs.pages.'.$page, compact('menus'));
    }
}
