debug('Debug mode activated!');

$(document).ready(function() {

	/**
	 * Toggling sidebar for extra-small viewports
	 */
	$('[data-toggle=offcanvas]').click(function() {
		$('.row-offcanvas').toggleClass('active');
	});

	/**
	 * Handle internal links for a smoother experience
	 */
	$('body').on('click', 'a[href*="/channels/"], a[href*="/playlists/"]', function(e) {

		e.preventDefault();

		$('.main-content-panel').load($(this).attr('href'), function() {

			$('html, body').animate({scrollTop: 0}, 'slow');

		});
	});

	/**
	 * Initialise any tab groups
	 */
	$('body').on('click', '#channel_tabs a', function(e) {

		e.preventDefault();

		$(this).tab('show');
	});

});

/**
 * Ajax Error handler
 */
$(document).ajaxError(function(e, jqxhr, settings, error) {

	var title = '<h3 class="panel-title">Oh noes!</h3>',
		heading = '<div class="panel-heading">'+title+'</div>',
		body = '<div class="panel-body">'+error+'</div>',
		error = '<div class="panel panel-danger">'+heading+body+'</div>';

	$('.main-content-panel').html(error);
});

debug('All scripts complete.');
