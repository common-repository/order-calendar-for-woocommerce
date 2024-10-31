<?php

class Pisol_Dtt_Edd_Calendar_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'order-calendar-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
