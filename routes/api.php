<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('auth/register', 'Auth\Api\RegisterController@register');
Route::post('auth/login', 'Auth\Api\LoginController@authenticate');


Route::apiResource('topics', 'TopicController');
Route::apiResource('speakers', 'SpeakerController');
Route::apiResource('speeches', 'SpeechController');
Route::apiResource('languages', 'LanguageController');

Route::get('users/{user}/favorites', 'UserFavoriteController@index');
Route::post('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@store');
Route::delete('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@destroy');