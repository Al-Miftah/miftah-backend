<?php

use Illuminate\Http\Request;

Route::get('developer/docs', 'DocumentationController');


//User authentication
Route::post('auth/register', 'Auth\API\RegisterController@register')->name('user.auth.register');
Route::post('auth/login', 'Auth\API\LoginController@authenticate')->name('user.auth.login');

Route::group(['prefix' => 'user/profile', 'middleware' => ['auth:api']], function () {
    //User profile
    Route::get('', 'UserProfileController@show')->name('user.profile.show');
    Route::patch('', 'UserProfileController@update')->name('user.profile.update');
    Route::patch('password', 'UserProfileController@changePassword')->name('user.password.update');
});


//Speaker authentication
Route::post('speaker/auth/register', 'Auth\API\SpeakerRegistrationController')->name('speaker.auth.register');
Route::post('speaker/auth/login', 'Auth\API\SpeakerLoginController')->name('speaker.auth.login');

//User topics
Route::get('users/topics', 'UserTopicController@index')->name('users.topics.index');
Route::post('users/topics/{topic}', 'UserTopicController@store')->name('users.topics.store');

//User speakers
Route::post('users/speakers/{speaker}', 'UserSpeakerController@store')->name('users.speakers.store');
Route::get('users/speakers', 'UserSpeakerController@index')->name('users.speakers.index');

Route::apiResource('topics', 'TopicController');
Route::apiResource('speakers', 'SpeakerController');
Route::apiResource('speeches', 'SpeechController');
Route::apiResource('languages', 'LanguageController');
Route::apiResource('tags', 'TagController');
Route::apiResource('questions', 'QuestionController');


Route::get('users/{user}/favorites', 'UserFavoriteController@index');
Route::post('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@store');
Route::delete('users/{user}/speeches/{speech}/favorites', 'UserFavoriteController@destroy');

Route::get('questions/{question}/answers', 'QuestionAnswerController@index')->name('question.answers.index');
Route::post('questions/{question}/answers', 'QuestionAnswerController@store')->name('question.answers.store');

//User favorite a speech
Route::post('speeches/{speech}/favorites', 'UserFavoriteSpeechController@store')->name('user.favorites.speeches.store');
//List user favorited speeches
Route::get('favorites/speeches', 'UserFavoriteSpeechController@index')->name('user.favorites.speeches.index');
//User unfavorite a speech
Route::delete('speeches/{speech}/favorites', 'UserFavoriteSpeechController@destroy')->name('user.favorites.speeches.destroy');