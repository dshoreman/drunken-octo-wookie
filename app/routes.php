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

	try
	{
		$searchResponse = $youtube->subscriptions->listSubscriptions('id,snippet,contentDetails', [
			'mine' => true,
			'maxResults' => 50,
			'order' => 'alphabetical',
		]);

		return View::make('subscriptions.list', [
			'subs' => $searchResponse,
		]);
	}
	catch (Google_ServiceException $e)
	{
		$htmlBody = sprintf('<p>A service error occurred: <code>%s</code></p>',
		htmlspecialchars($e->getMessage()));
	}
	catch (Google_Exception $e)
	{
		$htmlBody = sprintf('<p>An client error occurred: <code>%s</code></p>',
		htmlspecialchars($e->getMessage()));
	}

	return $htmlBody;

}]);

Route::get('channels/{id}', ['as' => 'channels', function($id)
{
	Youtube::init((object) Config::get('google'));

	if ( ! Youtube::setToken(Session::get('token')))
	{
		return Redirect::to(Youtube::getAuthUrl());
	}

	$channel = $youtube->channels->listchannels('id,snippet,status,contentDetails', [
		'id' => $id,
	])['items'][0];

	$playlists = $youtube->playlists->listPlaylists('id,snippet,status', [
		'channelId' => $id,
		'maxResults' => 50,
	]);

	$uploads = $channel['contentDetails']['relatedPlaylists']['uploads'];
	$uploads = $youtube->playlistItems->listPlaylistItems('id,snippet,status', [
		'playlistId' => $uploads,
		'maxResults' => 50,
	])['items'];

	return View::make('channels.index', [
		'channel' => $channel,
		'playlists' => $playlists,
		'uploads' => $uploads,
	]);
}]);

Route::get('playlists/{id}', ['as' => 'playlists', function($id)
{
	Youtube::init((object) Config::get('google'));

	if ( ! Youtube::setToken(Session::get('token')))
	{
		return Redirect::to(Youtube::getAuthUrl());
	}

	$list = $youtube->playlists->listPlaylists('id,snippet,status', [
		'id' => $id,
	]);

	$channel = $youtube->channels->listchannels('snippet', [
		'id' => $list['items'][0]['snippet']['channelId'],
	]);

	$items = $youtube->playlistItems->listPlaylistItems('id,snippet,status', [
		'playlistId' => $id,
		'maxResults' => 50,
	]);

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

	$video = $youtube->videos->listVideos($id, 'snippet,player,statistics')['items'][0];

	$channel = $youtube->channels->listchannels('snippet', [
		'id' => $video['snippet']['channelId'],
	])['items'][0];

	return View::make('videos.play', [
		'channel' => $channel,
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
