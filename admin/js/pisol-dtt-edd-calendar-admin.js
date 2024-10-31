(function ($) {
	'use strict';
	function pisol_calendar_order() {
		this.init = function () {
			this.detectClick();
		}

		this.detectClick = function () {
			var parent = this;
			jQuery(".pisol-order-count").on("click", function () {
				var orders = jQuery(this).data("orders");
				var order_type = jQuery(this).data("order_type");
				var date = jQuery(this).data("date");

				parent.loadOrders(orders, order_type, date);
			});
		}

		this.loadOrders = function (orders, order_type, date) {
			var parent = this;

			jQuery.ajax({
				url: ajaxurl,
				method: 'POST',
				data: {
					'action': "pisol_load_orders",
					'order_type': order_type,
					'orders': orders,
					'date': date
				},
				success: function (res) {
					$.magnificPopup.open({
						items: {
							src: res
						},
						type: 'inline'
					}, 0);

				}
			})
		}


	}

	jQuery(function ($) {
		var pisol_calendar_order_obj = new pisol_calendar_order();
		pisol_calendar_order_obj.init();
	});

})(jQuery);
