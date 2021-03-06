<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="/assets/ico/favicon.png">

		<title>Starter Template for Bootstrap</title>

		<link href="/assets/css/bootstrap.css" rel="stylesheet">
		<link href="/assets/css/custom.css" rel="stylesheet">

	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Project name</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row row-offcanvas row-offcanvas-left">
				<div class="col-xs-6 col-md-5 col-lg-4 sidebar-offcanvas">
					<h4>Subscriptions</h4>
					<div class="list-group subscription-list" data-source="{{ URL::route('subscriptions', ['results' => 50]) }}">
						<!-- Insert Ajax Stuff Here! -->
						<small>Loading...</small>
					</div>
				</div>

				<div class="col-xs-12 col-md-7 col-lg-8">
					<p class="pull-left visible-xs">
						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
					</p>

					<div class="main-content-panel">

						{{ Breadcrumbs::render('home') }}

					</div>
				</div>
			</div>

		</div>

		<script src="/assets/js/jquery.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		function debug (data) {
			@unless( app('env') == 'production')
			console.log(data);
			@endunless

			return;
		}
		function debugging () { return {{ app('env') == 'production' ? 'false' : 'true' }}; }
		</script>
		<script src="/assets/js/multiview.js"></script>
		<script src="/assets/js/custom.js"></script>
	</body>
</html>
