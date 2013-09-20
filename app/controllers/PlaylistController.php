<?php

class PlaylistController extends BaseController {

	public function ajax($id)
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
	}
}
