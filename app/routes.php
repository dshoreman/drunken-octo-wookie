<?php

$client = new Google_Client();

$client->setDeveloperKey(Config::get('google.developerKey'));
$client->setClientId(Config::get('google.clientId'));
$client->setClientSecret(Config::get('google.clientSecret'));

$redirect = URL::to('oauth');
$client->setRedirectUri($redirect);

$client->loadService('YouTube');
$youtube = new Google_YoutubeService($client);

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

Route::get('/', ['as' => 'dashboard', function() use ($client, $youtube)
{
	if ($token = Session::get('token'))
	{
		$client->setAccessToken($token);
	}

	if ( ! $client->getAccessToken())
	{
		$state = mt_rand();
		$client->setState($state);
		Session::put('state', $state);

		return Redirect::to($client->createAuthUrl());
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

Route::get('channels/{id}', ['as' => 'channels', function($id) use ($client, $youtube)
{
	if ($token = Session::get('token'))
	{
		$client->setAccessToken($token);
	}

	if ( ! $client->getAccessToken())
	{
		$state = mt_rand();
		$client->setState($state);
		Session::put('state', $state);

		return Redirect::to($client->createAuthUrl());
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

Route::get('playlists/{id}', ['as' => 'playlists', function($id) use ($client, $youtube)
{
	if ($token = Session::get('token'))
	{
		$client->setAccessToken($token);
	}

	if ( ! $client->getAccessToken())
	{
		$state = mt_rand();
		$client->setState($state);
		Session::put('state', $state);

		return Redirect::to($client->createAuthUrl());
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


Route::get('videos/{id}', ['as' => 'player', function($id) use ($client, $youtube)
{
	if ($token = Session::get('token'))
	{
		$client->setAccessToken($token);
	}

	if ( ! $client->getAccessToken())
	{
		$state = mt_rand();
		$client->setState($state);
		Session::put('state', $state);

		return Redirect::to($client->createAuthUrl());
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

Route::get('oauth', function() use ($client, $youtube)
{
	if ( ! $code = Input::get('code'))
	{
		throw new Exception('Missing code');
	}

	if (strval(Session::get('state')) !== strval(Input::get('state')))
	{
		throw new Exception('Session state did not match');
	}

	$client->authenticate();

	Session::put('token', $client->getAccessToken());

	return Redirect::to('/');

});
