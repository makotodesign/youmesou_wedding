/* admin_menu_current */

(function($) {
	/* var */
	const pathInUrl = window.location.href.match('.+/(.+?)?$')[1];
	function setup() {
		let $adminMenu = $('#adminmenu');
		$adminMenu.find('.wp-submenu > li > a').each(function() {
			if ($(this).attr('href') === pathInUrl) {
				$(this)
					.addClass('current')
					.parent('li')
					.addClass('current');
				$(this)
					.closest('.wp-submenu')
					.closest('li')
					.removeClass('wp-not-current-submenu')
					.addClass('wp-has-current-submenu')
					.addClass('wp-menu-open')
					.children('a')
					.removeClass('wp-not-current-submenu')
					.addClass('wp-has-current-submenu')
					.addClass('wp-menu-open');
			}
		});
	}
	$(function() {
		setup();
	});
})(jQuery);
