debug('Debug mode activated!');

$(document).ready(function() {

	$('[data-toggle=offcanvas]').click(function() {
		$('.row-offcanvas').toggleClass('active');
	});

	$('body').on('click', 'a[href*="/channels/"], a[href*="/playlists/"]', function(e) {

		e.preventDefault();

		$('.main-content-panel').load($(this).attr('href'), function() {

			$('html, body').animate({scrollTop: 0}, 'slow');

		});
	});

	$('body').on('click', '#channel_tabs a', function(e) {

		e.preventDefault();

		$(this).tab('show');
	});

});
