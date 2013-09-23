<div class="row view-minimal hidden">
	@foreach ($playlists['items'] as $item)
		<div class="col-sm-6 col-md-3">
			<a href="{{ URL::to('playlists/'.$item['id']) }}" class="thumbnail">
				<img src="{{ $item['snippet']['thumbnails']['default']['url'] }}" />
			</a>
		</div>
	@endforeach
</div>

<div class="row view-small hidden">
	@foreach ($playlists['items'] as $item)
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
				<a href="{{ URL::to('playlists/'.$item['id']) }}" class="thumbnail">
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

@if (isset($paging['prev']) || isset($paging['next']))
<ul class="pager">
	<li class="previous {{ ! $paging['prev'] ? 'disabled' : '' }}">
		<a href="{{ $paging['prev'] ? URL::to('/playlists/channel/'.$id.'/15/'.$paging['prev']) : '#' }}">&larr; Previous</a>
	</li>
	<li class="next {{ ! $paging['next'] ? 'disabled' : '' }}">
		<a href="{{ $paging['next'] ? URL::to('/playlists/channel/'.$id.'/15/'.$paging['next']) : '#' }}">Next &rarr;</a>
	</li>
</ul>
@endif
