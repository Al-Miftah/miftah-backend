<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return  redirect('/api/docs');//view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('api/docs', 'DocsController')->name('docs.pages');
Route::get('api/docs/donation', 'DonationDocsController')->name('donation.docs.pages');