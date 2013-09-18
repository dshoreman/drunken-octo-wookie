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
$(document).ajaxError(function(e, xhr, settings, error_str) {

	var error    = eval('(' + xhr.responseText + ')').error,
		title    = '<h3 class="panel-title">Oh noes!</h3>',
		heading  = '<div class="panel-heading">' + title + '</div>',
		details  = "<dl><dt>Type:</dt><dd>" + error.type + '</dd>'
				 + "\n<dt>Exception:</dt><dd>" + error_str + '</dd>'
				 + "\n<dt>Message:</dt><dd>" + error.message + '</dd>'
				 + "\n<dt>File:</dt><dd>" + error.file + '</dd>'
				 + "\n<dt>Line:</dt><dd>" + error.line + '</dd></dl>',
		message  = "This wasn't supposed to happen. Sorry about that! We'll get it fixed ASAP.",
		body     = '<div class="panel-body"><p>' + message + '</p>',
		body     = body + (debugging() ? '<pre>'+details+'</pre>' : '') + '</div>';

	$('.main-content-panel').html('<div class="panel panel-danger">'+heading+body+'</div>');

});

debug('All scripts complete.');
