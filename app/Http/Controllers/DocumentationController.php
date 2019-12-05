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
                        'name' => 'String',
                        'username' => 'String',
                        'email' => 'String',
                        'password' => 'String',
                        'password_confirmation' => 'String'
                    ]
                ],
                'login' =>
                [
                    'method' => 'POST',
                    'endpoint' => '/api/auth/login',
                    'params' => [
                        'email' => 'String',
                        'password' => 'String',
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
                            'name' => 'String', 
                            'email' => 'String', 
                            'username' => 'String', 
                            'avatar' => 'File'
                        ]
                    ],
                    'change_password' => [
                        'method' => 'PATCH',
                        'endpoint' => '/user/profile/password',
                        'params' => [
                            'current_password' => 'String',
                            'password' => 'String',
                            'password_confirmation' => 'String'
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
                ],
                'favorites' => [
                    'speeches' => [
                        'list' => [
                            'method' => 'GET',
                            'endpoint' => '/api/user/favorites/speeches'
                        ],
                        'add' => [
                            'method' => 'POST',
                            'endpoint' => '/api/speeches/:id/favorites',
                        ],
                        'remove' => [
                            'method' => 'DELETE',
                            'endpoint' => '/api/speeches/:id/favorites'
                        ]
                    ],
                    'questions' => [
                        'list' => [
                            'method' => 'GET',
                            'endpoint' => '/api/user/favorites/questions'
                        ],
                        'add' => [
                            'method' => 'POST',
                            'endpoint' => '/api/questions/:id/favorites',
                        ],
                        'remove' => [
                            'method' => 'DELETE',
                            'endpoint' => '/api/questions/:id/favorites'
                        ]
                    ],
                    'answers' => [
                        'list' => [
                            'method' => 'GET',
                            'endpoint' => '/api/user/favorites/answers'
                        ],
                        'add' => [
                            'method' => 'POST',
                            'endpoint' => '/api/answers/:id/favorites',
                        ],
                        'remove' => [
                            'method' => 'DELETE',
                            'endpoint' => '/api/answers/:id/favorites'
                        ]
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
                        'first_name' => 'String',
                        'last_name' => 'String',
                        'email' => 'String',
                        'phone_number' => 'String',
                        'location_address' => 'String',
                        'city' => 'String',
                        'password' => 'String',
                        'password_confirmation' => 'String',
                        'avatar' => 'File'
                    ]
                ],
                'login' => 
                [
                    'method' => 'POST',
                    'endpoint' => '/api/speaker/auth/login',
                    'params' => [
                        'email' => 'String', 
                        'password' => 'String'
                    ]
                ],
                'create' =>
                [
                    'method' => 'POST',
                    'endpoint' => '/api/speakers',
                    'params' => [
                        'first_name' => 'String',
                        'last_name' => 'String',
                        'email' => 'String',
                        'phone_number' => 'String',
                        'location_address' => 'String',
                        'city' => 'String',
                        'password' => 'String',
                        'password_confirmation' => 'String',
                        'avatar' => 'File'
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
                        'permanent' => 'true/false'
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
                        'title' => 'String',
                        'description' => 'String'
                    ]
                ],
                'update' => [
                    'method' => 'PATCH',
                    'endpoint' => '/api/topics/:id',
                    'params' => [
                        'title' => 'String',
                        'description' => 'String'
                    ]
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'endpoint' => '/api/topics/:id',
                    'params' => [
                        'permanent' => 'true/false'
                    ]
                ]
            ],
            'speeches' =>
            [
                'create' => [
                    'method' => 'POST',
                    'endpoint' => '/api/speeches',
                    'params' => [
                        'title' => 'String',
                        'summary' => 'String',
                        'transcription' => 'optional',
                        'speech' => 'File',
                        'speaker_id' => 'Integer',
                        'language_id' => 'Integer',
                        'topic_id' => 'optional',
                        'cover_photo' => 'optional',
                        'tags' => ['...names']
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
            ],
            'questions' => [
                'list' => [
                    'method' => 'GET',
                    'endpoint' => '/api/questions'
                ],
                'create' => [
                    'method' => 'POST',
                    'endpoint' => '/api/questions',
                    'params' => [
                        'title' => 'String',
                        'description' => 'String'
                    ]
                ],
                'update' => [
                    'method' => 'PATCH',
                    'endpoint' => '/api/questions/:id',
                    'params' => []
                ],
                'show' => [
                    'method' => 'GET',
                    'endpoint' => '/api/questions/:id'
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'endpoint' => '/api/questions/:id',
                    'params' => [
                        'permanent' => 'true/false'
                    ]
                ],
                'answers' => [
                    'list' => [
                        'method' => 'GET',
                        'endpoint' => '/api/questions/:id/answers'
                    ],
                    'create' => [
                        'method' => 'POST',
                        'endpoint' => '/api/questions/:id/answers',
                        'params' => [
                            'description' => 'String'
                        ]
                    ]
                ]
            ]
        ]);
    }
}
