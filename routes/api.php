<?php

use Illuminate\Http\Request;

Route::get('developer/docs', 'DocumentationController');


//User authentication
Route::post('auth/register', 'Auth\API\RegisterController@register')->name('user.auth.register');
Route::post('auth/login', 'Auth\API\LoginController@authenticate')->name('user.auth.login');

//Speaker authentication
Route::post('speaker/auth/register', 'Auth\API\SpeakerRegistrationController')->name('speaker.auth.register');
Route::post('speaker/auth/login', 'Auth\API\SpeakerLoginController')->name('speaker.auth.login');

//Speaker followers
Route::get('speakers/{speaker}/followers', 'UserSpeakerController@index')->name('speakers.followers.index');
Route::post('speakers/{speaker}/followers', 'UserSpeakerController@store')->name('speakers.followers.store');

//User topics
Route::get('users/topics', 'UserTopicController@index')->name('users.topics.index');
Route::post('users/topics/{topic}', 'UserTopicController@store')->name('users.topics.store');

Route::apiResource('topics', 'TopicController');
Route::apiResource('speakers', 'SpeakerController');
Route::apiResource('speeches', 'SpeechController');
Route::apiResource('languages', 'LanguageController');
Route::apiResource('tags', 'TagController');


Route::get('users/{user}/favorites', 'UserFavoriteController@index');
Route::post('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@store');
Route::delete('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@destroy');