<?php

class Pisol_Dtt_Calendar_Advance{
    
    public $plugin_name;

    private $settings = array();

    private $active_tab;

    private $this_tab = 'advance_report';

    private $tab_name = "Advance Report (Pro)";

    private $setting_key = 'pi_advance_report';
    
    

    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->settings = array(
    
            array('field'=>'pi_order_advance_report2'),

           
        );
        
        $this->active_tab = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'default';

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }


        add_action($this->plugin_name.'_tab', array($this,'tab'),1);

       
        $this->register_settings();
    }

    function groups(){
        $wp_roles = new WP_Roles();
        $all_roles = $wp_roles->roles;
        $roles = array();
        foreach($all_roles as $role_key => $role){
            $roles[$role_key] = $role['name'];
        }
        $roles["pi_guest"] = __('Guest','order-calendar-for-woocommerce');
        return $roles;
    }
    
    function delete_settings(){
        foreach($this->settings as $setting){
            delete_option( $setting['field'] );
        }
    }

    function register_settings(){   

        foreach($this->settings as $setting){
            register_setting( $this->setting_key, $setting['field']);
        }
    
    }

    function tab(){
        $this->tab_name = __('Advance Report (Pro)','order-calendar-for-woocommerce');
        ?>
        <a class=" px-3 text-light d-flex align-items-center  border-left border-right  <?php echo ($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo admin_url( 'admin.php?page='.sanitize_text_field($_GET['page']).'&tab='.$this->this_tab ); ?>">
            <?php echo ( $this->tab_name); ?> 
        </a>
        <?php
    }

    function tab_content(){
       ?>
       <div class="alert m-3 alert-warning">
        <h3>Both this bottom report are available in pro version and this 2 report can be added in front end using short code [pisol_advance_report]</h3> 
       </div>
       <h3><?php _e('Total product report', 'order-calendar-for-woocommerce'); ?></h3>
        <img src="<?php echo PISOL_DTT_EDD_CALENDAR_URL; ?>admin/img/total-product.png"" class="img-fluid mb-3">
        <hr>
        <h3><?php _e('Order report', 'order-calendar-for-woocommerce'); ?></h3>
        <img src="<?php echo PISOL_DTT_EDD_CALENDAR_URL; ?>admin/img/order-report.png"" class="img-fluid">
       <?php
    }

    
}

new Pisol_Dtt_Calendar_Advance($this->plugin_name);