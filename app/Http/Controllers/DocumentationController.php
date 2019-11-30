<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return response()->json(
        [
            'message' => '﷽',
            'user' => 
            [
                'registration' => 
                [
                    'method' => 'POST',
                    'endpoint' => '/api/auth/register',
                    'params' => [
                        'name',
                        'username',
                        'email',
                        'password',
                        'password_confirmation'
                    ]
                ],
                'login' =>
                [
                    'method' => 'POST',
                    'endpoint' => '/api/auth/login',
                    'params' => [
                        'email',
                        'password',
                    ]
                ],
                'topics' => 
                [
                    'follow/unfollow' => [
                        'method' => 'POST',
                        'endpoint' => '/api/user/topics/:id'
                    ],
                    'list' => [
                        'method' => 'GET',
                        'endpoint' => '/api/user/topics'
                    ]
                ]
            ],
            'speakers' => 
            [
                'registration' => 
                [
                    'method' => 'POST',
                    'endpoint' => '/api/speaker/auth/register',
                    'params' => [
                        'first_name',
                        'last_name',
                        'email',
                        'phone_number',
                        'location_address',
                        'city',
                        'password',
                        'password_confirmation',
                        'avatar'
                    ]
                ],
                'login' => 
                [
                    'method' => 'POST',
                    'endpoint' => '/api/speaker/auth/login',
                    'params' => [
                        'email', 'password'
                    ]
                ],
                'create' =>
                [
                    'method' => 'POST',
                    'endpoint' => '/api/speakers',
                    'params' => [
                        'first_name',
                        'last_name',
                        'email',
                        'phone_number',
                        'location_address',
                        'city',
                        'password',
                        'password_confirmation',
                        'avatar'
                    ]
                ],
                'list' =>
                [
                    'method' => 'GET',
                    'endpoint' => '/api/speakers',
                ],
                'update' =>
                [
                    'method' => 'PATCH',
                    'endpoint' => '/api/speakers/:id',
                    'params' => []
                ],
                'delete' =>
                [
                    'method' => 'DELETE',
                    'endpoint' => '/api/speakers/:id',
                    'params' => [
                        'permanent'
                    ]
                ],
                'followers' =>
                [
                    'method' => 'GET',
                    'endpoint' => '/api/speakers/:id/followers'
                ],
                'follow/unfollow' =>
                [
                    'method' => 'POST',
                    'endpoint' => '/api/speakers/:id/followers'
                ]


            ],
            'topics' => 
            [
                'list' => [
                    'method' => 'GET',
                    'endpoint' => '/api/topics'
                ],
                'create' => [
                    'method' => 'POST',
                    'endpoint' => '/api/topics',
                    'params' => [
                        'title',
                        'description'
                    ]
                ],
                'update' => [
                    'method' => 'PATCH',
                    'endpoint' => '/api/topics/:id',
                    'params' => [
                        'title',
                        'description'
                    ]
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'endpoint' => '/api/topics/:id',
                    'params' => [
                        'permanent' => 'boolean'
                    ]
                ]
            ],    
        ]);
    }
}
