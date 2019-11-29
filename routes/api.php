<?php

use Illuminate\Http\Request;

Route::get('developer/docs', 'DocumentationController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//User authentication
Route::post('auth/register', 'Auth\API\RegisterController@register')->name('user.auth.register');
Route::post('auth/login', 'Auth\API\LoginController@authenticate')->name('user.auth.login');

//Speaker authentication
Route::post('speaker/auth/register', 'Auth\API\SpeakerRegistrationController')->name('speaker.auth.register');
Route::post('speaker/auth/login', 'Auth\API\SpeakerLoginController')->name('speaker.auth.login');

Route::apiResource('topics', 'TopicController');
Route::apiResource('speakers', 'SpeakerController');
Route::apiResource('speeches', 'SpeechController');
Route::apiResource('languages', 'LanguageController');
Route::apiResource('tags', 'TagController');

Route::get('users/{user}/favorites', 'UserFavoriteController@index');
Route::post('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@store');
Route::delete('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@destroy');