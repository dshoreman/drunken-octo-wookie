<?php

class PlaylistController extends BaseController {

	public function ajax($id, $results = 15, $page = null)
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
					->where('maxResults', $results);

		if ( ! is_null($page))
		{
			$items->where('pageToken', $page);
		}
		$items = $items->get('id,snippet,status');

		return View::make('playlists.index', [
			'channel' => $channel['items'][0],
			'list' => $list['items'][0],
			'items' => $items['items'],
			'paging' => [
				'next' => (isset($items['nextPageToken']) ? $items['nextPageToken'] : null),
				'prev' => (isset($items['prevPageToken']) ? $items['prevPageToken'] : null),
				'all'  => $items['pageInfo']['totalResults'],
				'page' => $items['pageInfo']['resultsPerPage'],
			],
		]);
	}

	public function getByChannel($channelId, $results = 15, $page = null)
	{
		Youtube::init((object) Config::get('google'));

		if ( ! Youtube::setToken(Session::get('token')))
		{
			return Redirect::to(Youtube::getAuthUrl());
		}

		$playlists = Youtube::playlists()
					->where('channelId', $channelId)
					->where('maxResults', $results);

		if ( ! is_null($page))
		{
			$playlists->where('pageToken', $page);
		}
		$playlists = $playlists->get('id,snippet,status');

		return View::make('playlists.channel', [
			'id'        => $channelId,
			'playlists' => $playlists,
			'paging'    => [
				'next'  => (isset($playlists['nextPageToken']) ? $playlists['nextPageToken'] : null),
				'prev'  => (isset($playlists['prevPageToken']) ? $playlists['prevPageToken'] : null),
				'all'   => $playlists['pageInfo']['totalResults'],
				'page'  => $playlists['pageInfo']['resultsPerPage'],
			],
		]);
	}
}
