<?php

$client = new Google_Client();

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

Route::get('/', function() use ($client, $youtube)
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

});

Route::get('channels/{id}', function($id) use ($client, $youtube)
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

	$channel = $youtube->channels->listchannels('id,snippet,status', [
		'id' => $id,
	]);

	$playlists = $youtube->playlists->listPlaylists('id,snippet,status', [
		'channelId' => $id,
		'maxResults' => 50,
	]);

	return View::make('channels.index', [
		'channel' => $channel['items'][0],
		'playlists' => $playlists,
	]);
});

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
