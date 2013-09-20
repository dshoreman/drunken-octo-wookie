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
}
