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
	return View::make('app');
}]);

Route::get('subscriptions/{results?}/{page?}', [
			'uses' => 'SubscriptionController@ajax',
			'as' => 'subscriptions'
]);

Route::get('channels/{id}', ['as' => 'channels', function($id)
{
	Youtube::init((object) Config::get('google'));

	if ( ! Youtube::setToken(Session::get('token')))
	{
		return Redirect::to(Youtube::getAuthUrl());
	}

	$channel = Youtube::channels()
				->where('id', $id)
				->get('id,snippet,status,contentDetails')['items'][0];

	$playlists = Youtube::playlists()
				->where('channelId', $id)
				->where('maxResults', 50)
				->get('id,snippet,status');

	$uploads = $channel['contentDetails']['relatedPlaylists']['uploads'];
	$uploads = Youtube::playlistItems()
				->where('playlistId', $uploads)
				->where('maxResults', 50)
				->get('id,snippet,status');

	return View::make('channels.index', [
		'channel' => $channel,
		'playlists' => $playlists,
		'uploads' => $uploads['items'],
	]);
}]);

Route::get('playlists/{id}', ['as' => 'playlists', function($id)
{
	Youtube::init((object) Config::get('google'));

	if ( ! Youtube::setToken(Session::get('token')))
	{
		return Redirect::to(Youtube::getAuthUrl());
	}

	$list = Youtube::playlists()
			->where('id', $id)
			->get('id,snippet,status');

	$channel = Youtube::channels()
				->where('id', $list['items'][0]['snippet']['channelId'])
				->get('snippet');

	$items = Youtube::playlistItems()
				->where('playlistId', $id)
				->where('maxResults', 50)
                ->get('id,snippet,status');

	return View::make('playlists.index', [
		'channel' => $channel['items'][0],
		'list' => $list['items'][0],
		'items' => $items['items'],
	]);
}]);

Route::get('videos/{id}', ['as' => 'player', function($id)
{
	Youtube::init((object) Config::get('google'));

	if ( ! Youtube::setToken(Session::get('token')))
	{
		return Redirect::to(Youtube::getAuthUrl());
	}

	$video = Youtube::videos()->get($id, 'snippet,player,statistics')['items'][0];

	$channel = Youtube::channels()
				->where('id', $video['snippet']['channelId'])
				->get('snippet');

	return View::make('videos.play', [
		'channel' => $channel['items'][0],
		'video' => $video,
	]);
}]);

Route::get('oauth', function()
{
	Youtube::init((object) Config::get('google'));

	$token = Youtube::auth();

	Session::put('token', $token);

	return Redirect::to('/');

});
