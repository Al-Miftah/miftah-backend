<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return redirect('/api/docs');
});

//User authentication
Route::post('user/auth/register', 'Auth\API\RegisterController@register')->name('user.auth.register');
Route::post('user/auth/login', 'Auth\API\LoginController@authenticate')->name('user.auth.login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user/auth/logout', 'Auth\API\LogoutController')->name('user.auth.logout');
    Route::post('email-verification/resend', 'Auth\API\VerificationController@resend')->name('api.verification.resend');
    //User profile
    Route::group(['prefix' => 'user/profile'], function () {
        //User profile
        Route::get('', 'UserProfileController@show')->name('user.profile.show');
        Route::patch('', 'UserProfileController@update')->name('user.profile.update');
        Route::patch('password', 'UserProfileController@changePassword')->name('user.password.update');
        Route::get('notifications', 'UserNotificationController')->name('user.notifications.index');
    });
    //User speakers (following)
    Route::get('user/speakers/following', 'UserSpeakerController@index')->name('users.speakers.index');
    Route::post('user/speakers/{speaker}/following', 'UserSpeakerController@store')->name('users.speakers.store');
    //Permissions & Roles
    Route::get('permissions', 'PermissionController@index')->name('permissions.index');
    Route::get('roles', 'RoleController@index')->name('roles.index');
    Route::patch('users/{user}/roles', 'RoleController@update')->name('user.roles.update');
    Route::patch('users/{user}/permissions', 'PermissionController@update')->name('user.permissions.update');
});

//Email verification
Route::get('email-verification/verify/{id}', 'Auth\API\VerificationController@verify')->name('api.verification.verify');

//Password reset
Route::get('password/email', 'Auth\API\ForgotPasswordController@sendLink')->name('api.password.forgot');
Route::post('password/reset', 'Auth\API\ResetPasswordController@doReset')->name('api.password.reset');

//Speaker authentication
Route::post('speaker/auth/register', 'Auth\API\SpeakerRegistrationController')->name('speaker.auth.register');
Route::post('speaker/auth/login', 'Auth\API\SpeakerLoginController')->name('speaker.auth.login');

//User topics - Topics is following
Route::get('users/topics', 'UserTopicController@index')->name('users.topics.index');
Route::post('users/topics/{topic}', 'UserTopicController@store')->name('users.topics.store');

//Speeches of a speaker
Route::get('speakers/{speaker}/speeches', 'SpeakerSpeechController')->name('speaker.speeches');

//TODO: Wrap some routes in auth:api
Route::apiResource('topics', 'TopicController');
Route::apiResource('speakers', 'SpeakerController');
Route::apiResource('speeches', 'SpeechController');
Route::apiResource('tags', 'TagController');
Route::apiResource('questions', 'QuestionController');


Route::get('questions/{question}/answers', 'QuestionAnswerController@index')->name('question.answers.index');
Route::post('questions/{question}/answers', 'QuestionAnswerController@store')->name('question.answers.store');

//User favorite/unfavorite a speech
Route::post('speeches/{speech}/favorites', 'UserFavoriteSpeechController@store')->name('user.favorites.speeches.store');
//List user favorited speeches
Route::get('user/favorites/speeches', 'UserFavoriteSpeechController@index')->name('user.favorites.speeches.index');

//User favorite/unfavorite a questions
Route::post('questions/{question}/favorites', 'UserFavoriteQuestionController@store')->name('user.favorites.questions.store');
Route::get('user/favorites/questions', 'UserFavoriteQuestionController@index')->name('user.favorites.questions.index');

//User favorite/unfavorite an answer
Route::post('answers/{answer}/favorites', 'UserFavoriteAnswerController@store')->name('user.favorites.answers.store');
Route::get('user/favorites/answers', 'UserFavoriteAnswerController@index')->name('user.favorites.answers.index');
//Route::delete('answers/{answer}/favorites', 'UserFavoriteAnswerController@destroy')->name('user.favorites.answers.destroy');

//User questions
Route::get('user/questions', 'UserQuestionController@index')->name('user.questions');

//Tag speeches
Route::get('tags/{tag}/speeches', 'TagSpeechController')->name('tags.speeches.index');