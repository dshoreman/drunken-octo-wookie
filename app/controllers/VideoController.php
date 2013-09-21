<?php

class VideoController extends BaseController {

	public function ajax($id)
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
	}

	public function getByPlaylist($playlistId, $results = 15, $page = null)
	{
		Youtube::init((object) Config::get('google'));

		if ( ! Youtube::setToken(Session::get('token')))
		{
			return Redirect::to(Youtube::getAuthUrl());
		}

		$uploads = Youtube::playlistItems()
					->where('playlistId', $playlistId)
					->where('maxResults', $results);

		if ( ! is_null($page))
		{
			$uploads->where('pageToken', $page);
		}
		$uploads = $uploads->get('id,snippet,status');

		return View::make('videos.channel', [
			'playlistId'        => $playlistId,
			'uploads' => $uploads,
			'paging'    => [
				'next'  => (isset($uploads['nextPageToken']) ? $uploads['nextPageToken'] : null),
				'prev'  => (isset($uploads['prevPageToken']) ? $uploads['prevPageToken'] : null),
				'all'   => $uploads['pageInfo']['totalResults'],
				'page'  => $uploads['pageInfo']['resultsPerPage'],
			],
		]);
	}
}
