{{ Breadcrumbs::render('channel', $channel) }}

<div class="media">
	<a href="#" class="pull-left">
		<img src="{{ $channel['snippet']['thumbnails']['default']['url'] }}" />
	</a>
	<div class="media-body">
		<h1 class="media-heading" data-channelId="{{ $id }}">{{ $channel['snippet']['title'] }}</h1>
		<p>{{ nl2br($channel['snippet']['description']) }}</p>
	</div>
</div>

<ul class="nav nav-tabs nav-justified" id="channel_tabs">
	<li class="active"><a href="#playlists">Playlists</a></li>
	<li><a href="#videos" data-playlist="{{ $playlistId }}">Videos</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane fade active in playlists" id="playlists">
	</div>
	<div class="tab-pane fade videos" id="videos">
	</div>
</div>
