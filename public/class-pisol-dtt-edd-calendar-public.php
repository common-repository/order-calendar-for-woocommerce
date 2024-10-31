<?php
class Pisol_Dtt_Edd_Calendar_Public {

	
	private $plugin_name;

	
	private $version;

	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	
	public function enqueue_styles() {

		

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pisol-dtt-edd-calendar-public.css', array(), $this->version, 'all' );

	}

	
	public function enqueue_scripts() {

		

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pisol-dtt-edd-calendar-public.js', array( 'jquery' ), $this->version, false );

	}

}
