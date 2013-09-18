{{ Breadcrumbs::render('channel', $channel) }}

<div class="media">
	<a href="#" class="pull-left">
		<img src="{{ $channel['snippet']['thumbnails']['default']['url'] }}" />
	</a>
	<div class="media-body">
		<h1 class="media-heading">{{ $channel['snippet']['title'] }}</h1>
		<p>{{ nl2br($channel['snippet']['description']) }}</p>
	</div>
</div>

<ul class="nav nav-tabs nav-justified" id="channel_tabs">
	<li class="active"><a href="#playlists">Playlists</a></li>
	<li><a href="#videos">Videos</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane fade active in playlists">
		@foreach ($playlists['items'] as $item)
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{{ $item['snippet']['title'] }}</h3>
				</div>
				<div class="panel-body">
					<div class="media">
						<a href="{{ URL::to('playlists/'.$item['id']) }}" class="pull-left">
							<img src="{{ $item['snippet']['thumbnails']['default']['url'] }}" />
						</a>
						<div class="media-body">
							<p>{{ $item['snippet']['description'] }}</p>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="tab-pane fade" id="videos">
		<h3>Videos</h3>
		@foreach ($uploads as $video)
			<div class="panel panel-default video">
				<div class="panel-heading">
					<h3 class="panel-title">{{ $video['snippet']['title'] }}</h3>
				</div>
				<div class="panel-body">
					<div class="media">
						<a href="{{ route('player', $video['snippet']['resourceId']['videoId']) }}" class="pull-left">
							<img src="{{ $video['snippet']['thumbnails']['default']['url'] }}" />
						</a>
						<div class="media-body">
							<p class="description">{{ Str::limit($video['snippet']['description'], 150, '&hellip;') }}</p>
							<small>Published by {{ $video['snippet']['channelTitle'] }} on {{ $video['snippet']['publishedAt'] }}</small>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
