<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('dashboard/speakers', 'AdminController@listSpeakers')->name('speakers.index');
Route::get('dashboard/topics', 'AdminController@listTopics')->name('topics.index');
Route::get('dashboard/speeches', 'AdminController@listSpeeches')->name('speeches.index');
Route::get('dashboard/languages', 'AdminController@listLanguages')->name('languages.index');
Route::get('dashboard/users', 'AdminController@listUsers')->name('users.index');

Route::view('dashboard/speakers/create', 'speakers.create')->name('speakers.create');
Route::view('dashboard/topics/create', 'topics.create');
Route::view('dashboard/speeches/create', 'speeches.create');
Route::view('dashboard/users/create', 'users.create');
Route::get('dashboard/speakers/{speaker}/edit', 'SpeakerController@edit');
Route::get('dashboard/topics/{topic}/edit', 'TopicController@edit');
Route::get('dashboard/speeches/{speech}/edit', 'SpeechController@edit');
Route::get('dashboard/users/{user}/edit', 'UserController@edit');