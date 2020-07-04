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
                    ['method' => 'GET', 'title' => 'Notifications', 'page' => 'notifications']
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
            ],
            [
                'name' => 'Topics',
                'page' => 'topics',
                'children' => [
                    ['method' => 'POST', 'title' => 'Create', 'page' => 'create'],
                    ['method' => 'GET', 'title' => 'View', 'page' => 'view'],
                    ['method' => 'PATCH', 'title' => 'Update', 'page' => 'update'],
                    ['method' => 'DELETE', 'title' => 'Delete', 'page' => 'delete'],
                    ['method' => 'GET', 'title' => 'List', 'page' => 'list']
                ]
            ],
            [
                'name' => 'Speakers',
                'page' => 'speakers',
                'children' => [
                    ['method' => 'POST', 'title' => 'Create', 'page' => 'create'],
                    ['method' => 'PATCH', 'title' => 'Update', 'page' => 'update'],
                    ['method' => 'GET', 'title' => 'View', 'page' => 'view'],
                    ['method' => 'DELETE', 'title' => 'Delete', 'page' => 'delete'],
                    ['method' => 'GET', 'title' => 'List', 'page' => 'list'],
                    ['method' => 'POST', 'title' => 'Login', 'page' => 'login'],
                ]
            ]
        ];

        $page = $request->query('page') ?? 'welcome';        
        return view('docs.pages.'.$page, compact('menus'));
    }
}
