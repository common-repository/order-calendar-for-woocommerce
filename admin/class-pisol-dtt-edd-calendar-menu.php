<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
class pisol_dtt_edd_calendar_menu{

    public $plugin_name;
    public $menu;

    function __construct($plugin_name , $version){
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action( 'admin_menu', array($this,'plugin_menu') );
        add_action($this->plugin_name.'_promotion', array($this,'promotion'));
    }

    function plugin_menu(){
        
        $menu = add_menu_page(__('Order Calendar','order-calendar-for-woocommerce'), __('Order Calendar','order-calendar-for-woocommerce'), 'manage_options', 'pisol-dtt-edd-calendar',  array($this, 'menu_option_page'), PISOL_DTT_EDD_CALENDAR_URL.'admin/img/calendar.svg' ,
        6  );

        add_action("load-".$menu, array($this,'menu_page_style'));
 
    }

    function menu_option_page(){
        ?>
        <div class="container mt-2">
            <div class="row">
                    <div class="col-12">
                        <div class='bg-dark'>
                        <div class="row">
                            <div class="col-12 col-sm-2 py-2">
                            <a href="https://www.piwebsolution.com/" target="_blank"><img class="img-fluid ml-2" src="<?php echo PISOL_DTT_EDD_CALENDAR_URL; ?>admin/img/pi-web-solution.svg"></a>
                            </div>
                            <div class="col-12 col-sm-10 d-flex text-center small">
                                <?php do_action($this->plugin_name.'_tab'); ?>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-12">
                <div class="bg-light border px-3">
                    <div class="row">
                        <div class="col">
                        <?php do_action($this->plugin_name.'_tab_content'); ?>
                        </div>
                        <?php do_action($this->plugin_name.'_promotion'); ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <?php
    }

    function menu_page_style(){
       /* admin side popup */
       wp_enqueue_style('pi-magnify-popup', plugins_url('css/magnific-popup.css', __FILE__));
       wp_enqueue_script( 'pi-magnify-popup', plugin_dir_url( __FILE__ ) . 'js/jquery.magnific-popup.min.js', array( 'jquery' ));
       /* end */

       wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pisol-dtt-edd-calendar-admin.js', array( 'jquery' ), $this->version, false );

        wp_enqueue_style($this->plugin_name.'style_bootstrap', plugins_url('css/bootstrap.css', __FILE__));

        wp_register_script( 'selectWoo', WC()->plugin_url() . '/assets/js/selectWoo/selectWoo.full.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'selectWoo' );
        wp_enqueue_style( 'select2', WC()->plugin_url() . '/assets/css/select2.css');
    
    }

    function promotion(){
        ?>
        <div class="col-12 col-sm-4">
            
        <div class="bg-dark text-light text-center my-3">
                <a href="<?php echo PISOL_DTT_EDD_CALENDAR_BUY_URL; ?>" target="_blank">
                    <?php  new pisol_promotion("pi_dtt_edd_calendar_installation_date"); ?>
                </a>
        </div>  
        <div class="bg-primary p-3 text-light text-center mb-3 pi-shadow promotion-bg">
            <h2 class="text-light font-weight-light "><span>Get Pro for <h2 class="h2 font-weight-bold my-2 text-light"><?php echo PISOL_DTT_EDD_PRICE; ?></h2></span></h2>
            <a class="btn btn-danger btn-sm text-uppercase" href="<?php echo  PISOL_DTT_EDD_CALENDAR_BUY_URL; ?>" target="_blank">Buy Now !!</a>
            <div class="inside mt-2">
                PRO version offer more advanced features like:<br><br>
                <ul class="text-left  h6 font-weight-light">
                <li class="border-top py-2 h6">Show total number of product ordered for a date</li>
                <li class="border-top py-2 h6">Show total number of product ordered for a date organized in time-slot group</li>
                <li class="border-top py-2 h6">Show calendar on the front end using the short-code <span class="text-primary">[order_calendar]</span></li>
                <li class="border-top py-2 h6">Pro version will show the <span class="text-primary">orders arranged as per the time slots</span>, so you will know how many orders to be ready till what time </li>
                <li class="border-top py-2 h6">Assign order <span class="text-primary">detail access</span> as per the employee role</li>
                <li class="border-top py-2 h6">If an employee is in a production <span class="text-primary">show them product detail</span> of the order</li>
                <li class="border-top py-2 h6">If an employee is in delivery then only show him <span class="text-primary">customer detail</span> or even product detail </li>
                <li class="border-top py-2 h6">Grant access based on user role to access <span class="text-primary">Order Calendar</span> on front end</li>
                <li class="border-top py-2 h6">Grant access based on user role to access <span class="text-primary">Pickup Calendar</span> on front end</li>
                <li class="border-top py-2 h6">Grant access based on user role to access <span class="text-primary">Delivery Calendar</span> on front end</li>
                <li class="border-top py-2 h6">Grant access based on user role to access <span class="text-primary">Customer detail</span> on front end</li>
                <li class="border-top py-2 h6">Grant access based on user role to access <span class="text-primary">Ordered Product detail</span> on front end</li>
                </ul>
                <a class="btn btn-light" href="<?php echo  PISOL_DTT_EDD_CALENDAR_BUY_URL; ?>" target="_blank">Click to Buy Now</a>
            </div>
        </div>
    </div>
    
    <?php
    }



}