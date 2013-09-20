<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['as' => 'dashboard', function()
{
	Youtube::init((object) Config::get('google'));

	if ( ! Youtube::setToken(Session::get('token')))
	{
		return Redirect::to(Youtube::getAuthUrl());
	}

	return View::make('app');
}]);

Route::get('subscriptions/{results?}/{page?}', [
			'uses' => 'SubscriptionController@ajax',
			  'as' => 'subscriptions'
]);

Route::get('channels/{id}', [
			'uses' => 'ChannelController@ajax',
			  'as' => 'channels'
]);

Route::get('playlists/{id}/{results?}/{page?}', [
			'uses' => 'PlaylistController@ajax',
		      'as' => 'playlists'
]);

Route::get('videos/{id}', [
			'uses' => 'VideoController@ajax',
			  'as' => 'player'
]);

Route::get('oauth', function()
{
	Youtube::init((object) Config::get('google'));

	$token = Youtube::auth();

	Session::put('token', $token);

	return Redirect::to('/');

});
