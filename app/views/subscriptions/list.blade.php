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

@if (isset($paging['prev']) || isset($paging['next']))
<ul class="pager">
	<li class="previous {{ ! $paging['prev'] ? 'disabled' : '' }}">
		<a href="{{ $paging['prev'] ? URL::to('/subscriptions/15/'.$paging['prev']) : '#' }}">&larr; Previous</a>
	</li>
	<li class="next {{ ! $paging['next'] ? 'disabled' : '' }}">
		<a href="{{ $paging['next'] ? URL::to('/subscriptions/15/'.$paging['next']) : '#' }}">Next &rarr;</a>
	</li>
</ul>
@endif
