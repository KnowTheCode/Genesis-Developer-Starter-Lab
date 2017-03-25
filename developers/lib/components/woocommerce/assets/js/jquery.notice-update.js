;(function ($, document, undefined) {

	var clickHandler= function() {
		$.ajax({
			url: ajaxurl,
			data: {
				action: 'dismiss_child_theme_woocommerce_notice'
			}
		});
	}

	$(document).on( 'click', '.child-theme-woocommerce-notice .notice-dismiss', clickHandler );

})(jQuery, document);