<div class="row view-minimal hidden">
	@foreach ($uploads['items'] as $video)
		<div class="col-sm-6 col-md-3">
			<a href="{{ route('player', $video['snippet']['resourceId']['videoId']) }}" class="thumbnail">
				<img src="{{ $video['snippet']['thumbnails']['default']['url'] }}" />
			</a>
		</div>
	@endforeach
</div>

<div class="row view-small hidden">
	@foreach ($uploads['items'] as $video)
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
				<a href="{{ route('player', $video['snippet']['resourceId']['videoId']) }}" class="thumbnail">
					<img src="{{ $video['snippet']['thumbnails']['default']['url'] }}" />
				</a>
				<div class="caption">
					<h5>{{ $video['snippet']['title'] }}</h5>
				</div>
			</div>
		</div>
	@endforeach
</div>

<div class="view-list">
	@foreach ($uploads['items'] as $video)
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

@if (isset($paging['prev']) || isset($paging['next']))
<ul class="pager">
	<li class="previous {{ ! $paging['prev'] ? 'disabled' : '' }}">
		<a href="{{ $paging['prev'] ? URL::to('/videos/channel/'.$playlistId.'/15/'.$paging['prev']) : '#' }}">&larr; Previous</a>
	</li>
	<li class="next {{ ! $paging['next'] ? 'disabled' : '' }}">
		<a href="{{ $paging['next'] ? URL::to('/videos/channel/'.$playlistId.'/15/'.$paging['next']) : '#' }}">Next &rarr;</a>
	</li>
</ul>
@endif
