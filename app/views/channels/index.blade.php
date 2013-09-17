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
	</div>
</div>

<script type="text/javascript">

	$('#channel_tabs a').click(function(e) {

		e.preventDefault();

		$(this).tab('show');
	});

	$('.playlists a').click(function(e) {

		e.preventDefault();

		$('.main-content-panel').load($(this).attr('href'), function() {

			$("html, body").animate({ scrollTop: 0 }, "slow");

		});
	});

</script>
