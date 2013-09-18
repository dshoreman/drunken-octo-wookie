<?php

Breadcrumbs::register('home', function($breadcrumbs)
{
	$breadcrumbs->push('Home', route('dashboard'));
});

Breadcrumbs::register('channel', function($breadcrumbs, $channel)
{
	$breadcrumbs->parent('home');

	$breadcrumbs->push($channel['snippet']['title'], route('channels', $channel['id']));
});

Breadcrumbs::register('playlist', function($breadcrumbs, $playlist, $channel)
{
	$breadcrumbs->parent('channel', $channel);

	$breadcrumbs->push($playlist['snippet']['title'], route('playlists', $playlist['id']));
});

Breadcrumbs::register('video', function($breadcrumbs, $video, $channel)
{
	$breadcrumbs->parent('channel', $channel);

	$breadcrumbs->push($video['snippet']['title'], route('player', $video['id']));
});
