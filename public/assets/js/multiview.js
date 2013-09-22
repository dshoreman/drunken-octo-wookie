(function ($) {

	$.fn.outerHtml = function() {
		return $('<div />').append(this.eq(0).clone()).html();
	}
}( jQuery ));

(function ($) {

	$.fn.multiview = function () {

		var buttons = [
				['th', 'minimal'],
				['th-large', 'small'],
				['th-list', 'list']
			],
			toolbar = '<div class="btn-toolbar">'
					+ 	'<div class="btn-group pull-right">';

		for (var i = 0; i < buttons.length; i++) {
			toolbar = toolbar
					+ '<button type="button" class="btn btn-default" data-view="'+buttons[i][1]+'">'
					+ 	'<span class="glyphicon glyphicon-'+buttons[i][0]+'"></span>'
					+ '</button>';;
		};

		$(this).before(toolbar + '</div></div>');

		$('.btn-toolbar button', $(this).parent()).click(function() {
			var parent = $(this).parent().parent().parent().attr('id');

			$('.view-minimal, .view-small, .view-list', '#'+parent).removeClass('hidden');
			$('.view-minimal, .view-small, .view-list', '#'+parent).hide();

			$('.view-'+$(this).data('view'), '#'+parent).show();
		})
	}
}( jQuery ));
