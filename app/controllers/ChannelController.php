<?php

class ChannelController extends BaseController {

	public function ajax($id)
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
	}
}
