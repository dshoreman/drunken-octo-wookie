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

		$playlistId = $channel['contentDetails']['relatedPlaylists']['uploads'];

		return View::make('channels.index', [
			'id' => $id,
			'channel' => $channel,
			'playlistId' => $playlistId,
		]);
	}
}
