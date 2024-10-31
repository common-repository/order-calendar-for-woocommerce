<?php


class Pisol_Dtt_Edd_Calendar_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		new pisol_dtt_edd_calendar_menu($this->plugin_name, $this->version);
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pisol-dtt-edd-calendar-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {

	}

}
