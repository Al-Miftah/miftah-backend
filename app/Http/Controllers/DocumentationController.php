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
                'profile' =>
                [
                    'show' => [
                        'method' => 'GET',
                        'endpoint' => '/api/user/profile'
                    ],
                    'update' => [
                        'method' => 'PATCH',
                        'endpoint' => '/api/user/profile',
                        'params' => [
                            'name', 'email', 'username', 'avatar'
                        ]
                    ],
                    'change_password' => [
                        'method' => 'PATCH',
                        'endpoint' => '/user/profile/password',
                        'params' => [
                            'current_password', 'password', 'password_confirmation'
                        ]
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
                ],
                'speakers' =>
                [
                    'follow/unfollow' => [
                        'method' => 'POST',
                        'endpoint' => '/api/users/speakers/:id'
                    ],
                    'list' => [
                        'method' => 'GET',
                        'endpoint' => '/api/users/speakers'
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
            'speeches' =>
            [
                'create' => [
                    'method' => 'POST',
                    'endpoint' => '/api/speeches',
                    'params' => [
                        'title',
                        'summary' => 'optional',
                        'transcription' => 'optional',
                        'speech' => 'File',
                        'speaker_id',
                        'language_id',
                        'topic_id' => 'optional',
                        'cover_photo' => 'optional'
                    ]
                ],
                'list' => [
                    'method' => 'GET',
                    'endpoint' => '/api/speeches'
                ],
                'show' => [
                    'method' => 'GET',
                    'endpoint' => '/api/speeches/:id'
                ],
                'update' => [
                    'method' => 'PATCH',
                    'endpoint' => '/api/speeches/:id',
                    'params' => []
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'endpoint' => '/api/speeches/:id',
                    'params' => [
                        'permanent' => 'true/false'
                    ]
                ]
            ]   
        ]);
    }
}
