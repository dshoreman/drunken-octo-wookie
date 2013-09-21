{{ Breadcrumbs::render('playlist', $list, $channel) }}

<div class="media">
	<a href="#" class="pull-left">
		<img src="{{ $list['snippet']['thumbnails']['default']['url'] }}" />
	</a>
	<div class="media-body">
		<h1 class="media-heading">{{ $list['snippet']['title'] }}</h1>
		<p>{{ nl2br($list['snippet']['description']) }}</p>
	</div>
</div>

@foreach ($items as $item)
	<div class="panel panel-default video">
		<div class="panel-heading">
			<h3 class="panel-title">{{ $item['snippet']['title'] }}</h3>
		</div>
		<div class="panel-body">
			<div class="media">
				<a href="{{ route('player', $item['snippet']['resourceId']['videoId']) }}" class="pull-left">
					<img src="{{ $item['snippet']['thumbnails']['default']['url'] }}" />
				</a>
				<div class="media-body">
					<p class="description">{{ Str::limit($item['snippet']['description'], 150, '&hellip;') }}</p>
					<small>Published by {{ $item['snippet']['channelTitle'] }} on {{ $item['snippet']['publishedAt'] }}</small>
				</div>
			</div>
		</div>
	</div>
@endforeach

@if (isset($paging['prev']) || isset($paging['next']))
<ul class="pager">
	<li class="previous {{ ! $paging['prev'] ? 'disabled' : '' }}">
		<a href="{{ $paging['prev'] ? URL::to('/playlists/'.$item['snippet']['playlistId'].'/15/'.$paging['prev']) : '#' }}">&larr; Previous</a>
	</li>
	<li class="next {{ ! $paging['next'] ? 'disabled' : '' }}">
		<a href="{{ $paging['next'] ? URL::to('/playlists/'.$item['snippet']['playlistId'].'/15/'.$paging['next']) : '#' }}">Next &rarr;</a>
	</li>
</ul>
@endif
