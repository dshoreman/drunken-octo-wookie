$(document).ready(function() {

	$('[data-toggle=offcanvas]').click(function() {
		$('.row-offcanvas').toggleClass('active');
	});

	$('.subscription-list a').click(function(e) {

		e.preventDefault();

		$('.main-content-panel').load($(this).attr('href'));
	});

});
