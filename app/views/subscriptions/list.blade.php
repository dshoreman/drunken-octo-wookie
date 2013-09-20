@foreach ($subs['items'] as $sub)
	<a class="list-group-item" href="{{ URL::to('channels/'.$sub['snippet']['resourceId']['channelId']) }}">
		<span class="badge badge-default">{{ $sub['contentDetails']['totalItemCount'] }}</span>
		<div class="media">
			<span class="pull-left">
				<img class="media-object" src="{{ $sub['snippet']['thumbnails']['default']['url'] }}" />
			</span>
			<div class="media-body">
				<h5 class="media-heading">{{ $sub['snippet']['title'] }}</h5>
			</div>
		</div>
	</a>
@endforeach

@if (isset($subs['prevPageToken']) || isset($subs['nextPageToken']))
<ul class="pager">
	<li class="previous {{ ! isset($subs['prevPageToken']) ? 'disabled' : '' }}">
		<a href="{{ isset($subs['prevPageToken']) ? URL::to('/subscriptions/50/'.$subs['prevPageToken']) : '#' }}">&larr; Previous</a>
	</li>
	<li class="next {{ ! isset($subs['nextPageToken']) ? 'disabled' : '' }}">
		<a href="{{ isset($subs['nextPageToken']) ? URL::to('/subscriptions/50/'.$subs['nextPageToken']) : '#' }}">Next &rarr;</a>
	</li>
</ul>
@endif
