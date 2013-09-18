{{ Breadcrumbs::render('video', $video, $channel) }}

<div class="media">
	<a href="#" class="pull-left">
		<img src="{{ $video['snippet']['thumbnails']['default']['url'] }}" />
	</a>
	<div class="media-body">
		<h1 class="media-heading">{{ $video['snippet']['title'] }}</h1>
		<p>{{ nl2br($video['snippet']['description']) }}</p>
		<hr />
		<p><small>Published by {{ $video['snippet']['channelTitle'] }} on {{ $video['snippet']['publishedAt'] }}</small></p>
		<p><small>
			<strong>Views: </strong> {{ $video['statistics']['viewCount'] }}
			<strong>Likes: </strong> {{ $video['statistics']['likeCount'] }}
			<strong>Dislikes: </strong> {{ $video['statistics']['dislikeCount'] }}
			<strong>Favourites</strong> {{ $video['statistics']['favoriteCount'] }}
			<strong>Comments: </strong> {{ $video['statistics']['commentCount'] }}
		</small></p>
	</div>

	{{ $video['player']['embedHtml'] }}

</div>
