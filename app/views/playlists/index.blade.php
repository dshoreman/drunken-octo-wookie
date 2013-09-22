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

<div id="playlist-items">
	<div class="content">
		<div class="row view-minimal hidden">
			@foreach ($items as $item)
				<div class="col-sm-6 col-md-3">
					<a href="{{ route('player', $item['snippet']['resourceId']['videoId']) }}" class="thumbnail">
						<img src="{{ $item['snippet']['thumbnails']['default']['url'] }}" />
					</a>
				</div>
			@endforeach
		</div>

		<div class="row view-small hidden">
			@foreach ($items as $item)
				<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<a href="{{ route('player', $item['snippet']['resourceId']['videoId']) }}" class="thumbnail">
							<img src="{{ $item['snippet']['thumbnails']['default']['url'] }}" />
						</a>
						<div class="caption">
							<h5>{{ $item['snippet']['title'] }}</h5>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<div class="view-list">
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
		</div>
	</div>
</div>

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

<script type="text/javascript">
$('#playlist-items .content').multiview();
</script>
