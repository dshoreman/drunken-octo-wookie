<?php

class SubscriptionController extends BaseController {

	public function ajax($results = 15, $page = null)
	{
		Youtube::init((object) Config::get('google'));

		if ( ! Youtube::setToken(Session::get('token')))
		{
			return Redirect::to(Youtube::getAuthUrl());
		}

		$subs = Youtube::subscriptions()
				->where('mine', true)
				->where('maxResults', $results)
				->where('order', 'alphabetical');

		if ( ! is_null($page))
		{
			$subs->where('pageToken', $page);
		}
		$subs = $subs->get('id,snippet,contentDetails');

		return View::make('subscriptions.list', [
			'subs' => $subs,
			'paging' => [
				'next' => (isset($subs['nextPageToken']) ? $subs['nextPageToken'] : null),
				'prev' => (isset($subs['prevPageToken']) ? $subs['prevPageToken'] : null),
				'all'  => $subs['pageInfo']['totalResults'],
				'page' => $subs['pageInfo']['resultsPerPage'],
			],
		]);
	}
}
