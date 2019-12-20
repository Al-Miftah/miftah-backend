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
                    'description' => 'Register a user account',
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
                    'Login to app',
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
                        'description' => 'Display profile details of logged in user',
                        'method' => 'GET',
                        'endpoint' => '/api/user/profile'
                    ],
                    'update' => [
                        'description' => 'Update user profile information',
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
                        'description' => 'Change user password',
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
                        'description' => 'Follow or unfollow a topic',
                        'method' => 'POST',
                        'endpoint' => '/api/user/topics/:id'
                    ],
                    'list' => [
                        'description' => 'List all topics user is following',
                        'method' => 'GET',
                        'endpoint' => '/api/user/topics'
                    ]
                ],
                'speakers' =>
                [
                    'follow/unfollow' => [
                        'description' => 'Follow or unfollow a speaker',
                        'method' => 'POST',
                        'endpoint' => '/api/users/speakers/:id'
                    ],
                    'list' => [
                        'description' => 'List all speakers user is following',
                        'method' => 'GET',
                        'endpoint' => '/api/users/speakers',
                    ]
                ],
                'favorites' => [
                    'speeches' => [
                        'list' => [
                            'description' => 'List all user favorite speeches',
                            'method' => 'GET',
                            'endpoint' => '/api/user/favorites/speeches',
                        ],
                        'add/remove' => [
                            'description' => 'Add or remove a speech from user favorite speeches',
                            'method' => 'POST',
                            'endpoint' => '/api/speeches/:id/favorites',
                        ],
                    ],
                    'questions' => [
                        'list' => [
                            'description' => 'List all user favorite questions',
                            'method' => 'GET',
                            'endpoint' => '/api/user/favorites/questions'
                        ],
                        'add/remove' => [
                            'description' => 'Add or remove a question from user favorite questions',
                            'method' => 'POST',
                            'endpoint' => '/api/questions/:id/favorites',
                        ],
                    ],
                    'answers' => [
                        'list' => [
                            'description' => 'List all user favorite answers',
                            'method' => 'GET',
                            'endpoint' => '/api/user/favorites/answers'
                        ],
                        'add/remove' => [
                            'description' => 'Add or remove an answer from user favorite answers',
                            'method' => 'POST',
                            'endpoint' => '/api/answers/:id/favorites',
                        ],
                    ]
                ],
                'questions' => [
                    'list' => [
                        'description' => 'List all questions user asked',
                        'method' => 'GET',
                        'endpoint' => '/api/user/questions'
                    ]
                ]
            ],
            'speakers' => 
            [
                'registration' => 
                [
                    'description' => 'Register a new speaker',
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
                    'description' => 'Signin a speaker',
                    'method' => 'POST',
                    'endpoint' => '/api/speaker/auth/login',
                    'params' => [
                        'email' => 'String', 
                        'password' => 'String'
                    ]
                ],
                'create' =>
                [
                    'description' => 'Create a new speaker',
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
                    'description' => 'List all speakers',
                    'method' => 'GET',
                    'endpoint' => '/api/speakers',
                ],
                'update' =>
                [
                    'description' => 'Update details of a speaker',
                    'method' => 'PATCH',
                    'endpoint' => '/api/speakers/:id',
                    'params' => []
                ],
                'delete' =>
                [
                    'description' => 'Delete a speaker',
                    'method' => 'DELETE',
                    'endpoint' => '/api/speakers/:id',
                    'params' => [
                        'permanent' => 'true/false'
                    ]
                ],
                'speeches' => [
                    'description' => 'List all speeches by a speaker',
                    'method' => 'GET',
                    'endpoint' => '/api/speakers/:id/speeches'
                ]
            ],
            'topics' => 
            [
                'list' => [
                    'description' => 'List all topics',
                    'method' => 'GET',
                    'endpoint' => '/api/topics'
                ],
                'create' => [
                    'description' => 'Create a new topic',
                    'method' => 'POST',
                    'endpoint' => '/api/topics',
                    'params' => [
                        'title' => 'String',
                        'description' => 'String'
                    ]
                ],
                'update' => [
                    'description' => 'Update a topic',
                    'method' => 'PATCH',
                    'endpoint' => '/api/topics/:id',
                    'params' => [
                        'title' => 'String',
                        'description' => 'String'
                    ]
                ],
                'delete' => [
                    'description' => 'Delete a topic',
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
                    'description' => 'Create a new speech',
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
                    'description' => 'List all speeches',
                    'method' => 'GET',
                    'endpoint' => '/api/speeches'
                ],
                'show' => [
                    'description' => 'Show details of speech',
                    'method' => 'GET',
                    'endpoint' => '/api/speeches/:id'
                ],
                'update' => [
                    'description' => 'Update a speech',
                    'method' => 'PATCH',
                    'endpoint' => '/api/speeches/:id',
                    'params' => []
                ],
                'delete' => [
                    'description' => 'Delete a speech',
                    'method' => 'DELETE',
                    'endpoint' => '/api/speeches/:id',
                    'params' => [
                        'permanent' => 'true/false'
                    ]
                ]
            ],
            'questions' => [
                'list' => [
                    'description' => 'List all questions',
                    'method' => 'GET',
                    'endpoint' => '/api/questions'
                ],
                'create' => [
                    'description' => 'Ask a new question',
                    'method' => 'POST',
                    'endpoint' => '/api/questions',
                    'params' => [
                        'title' => 'String',
                        'description' => 'String'
                    ]
                ],
                'update' => [
                    'description' => 'Update a question',
                    'method' => 'PATCH',
                    'endpoint' => '/api/questions/:id',
                    'params' => []
                ],
                'show' => [
                    'description' => 'Show details of a question',
                    'method' => 'GET',
                    'endpoint' => '/api/questions/:id'
                ],
                'delete' => [
                    'description' => 'Delete a question',
                    'method' => 'DELETE',
                    'endpoint' => '/api/questions/:id',
                    'params' => [
                        'permanent' => 'true/false'
                    ]
                ],
                'answers' => [
                    'list' => [
                        'description' => 'List answers to a question',
                        'method' => 'GET',
                        'endpoint' => '/api/questions/:id/answers'
                    ],
                    'create' => [
                        'description' => 'Provide answer to a question',
                        'method' => 'POST',
                        'endpoint' => '/api/questions/:id/answers',
                        'params' => [
                            'description' => 'String'
                        ]
                    ]
                ]
            ],
            'tags' => [
                'list' => [
                    'description' => 'List all available tags',
                    'method' => 'GET',
                    'endpoint' => '/api/tags'
                ],
                'speeches' => [
                    'description' => 'List speeches under a tag',
                    'method' => 'GET',
                    'endpoint' => '/api/tags/:id/speeches'
                ]
            ]
        ]);
    }
}
