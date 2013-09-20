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
