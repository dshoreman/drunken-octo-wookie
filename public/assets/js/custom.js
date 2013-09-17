$(document).ready(function() {

	$('[data-toggle=offcanvas]').click(function() {
		$('.row-offcanvas').toggleClass('active');
	});

	$('body').on('click', 'a[href*="/channels/"], a[href*="/subscriptions/"]', function(e) {

		e.preventDefault();

		$('.main-content-panel').load($(this).attr('href'), function() {

			$('html, body').animate({scrollTop: 0}, 'slow');

		});
	});

});
