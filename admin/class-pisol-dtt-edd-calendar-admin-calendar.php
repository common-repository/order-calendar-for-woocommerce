<?php

class Pisol_Admin_Calendar{

    public $plugin_name;

    private $settings = array();

    private $active_tab;

    private $this_tab = 'default';

    private $tab_name = "Calendar";

    public  $who_can_view = array('editor', 'administrator');

    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->active_tab = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'default';

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }


        add_action($this->plugin_name.'_tab', array($this,'tab'),1);

        add_action( 'wp_ajax_pisol_load_orders', array($this,'orderLinks') );
    }

    function tab(){
        $this->tab_name = __('Calendar', 'order-calendar-for-woocommerce');
        ?>
        <a class=" px-3 text-light d-flex align-items-center  border-left border-right  <?php echo ($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo admin_url( 'admin.php?page='.sanitize_text_field($_GET['page']).'&tab='.$this->this_tab ); ?>">
            <?php echo ( $this->tab_name); ?> 
        </a>
        <?php
    }

    function tab_content(){
        Pisol_Calendar_Controller::show($this->this_tab);
    }

    function orderLinks(){
        $user = wp_get_current_user();
        if( array_intersect($this->who_can_view, $user->roles ) ) { 
            $orders = ($_POST['orders']);
            include 'partials/orders.php';
        }
        die;
    }
}

new Pisol_Admin_Calendar($this->plugin_name);