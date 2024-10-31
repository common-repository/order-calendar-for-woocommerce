<?php

class Pisol_Dtt_Calendar_Access{
    
    public $plugin_name;

    private $settings = array();

    private $active_tab;

    private $this_tab = 'calendar_access';

    private $tab_name = "Calendar Access (Pro)";

    private $setting_key = 'pi_calendar_access';
    
    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->settings = array(
    
            array('field'=>'pi_order_calendar_access', 'label'=>__('Who can access Order Calendar','order-calendar-for-woocommerce'),'type'=>'multiselect', 'default'=> '', 'value'=>$this->groups(),  'desc'=>__('Groups that can access order calendar on front end','order-calendar-for-woocommerce'), 'pro'=>true),

            array('field'=>'pi_pickup_calendar_access', 'label'=>__('Who can access Pickup Calendar','order-calendar-for-woocommerce'),'type'=>'multiselect', 'default'=> '', 'value'=>$this->groups(),  'desc'=>__('Groups that can access pickup calendar on front end','order-calendar-for-woocommerce'), 'pro'=>true),

            array('field'=>'pi_delivery_calendar_access', 'label'=>__('Who can access Delivery Calendar','order-calendar-for-woocommerce'),'type'=>'multiselect', 'default'=> '', 'value'=>$this->groups(),  'desc'=>__('Groups that can access delivery calendar on front end','order-calendar-for-woocommerce'), 'pro'=>true),

            array('field'=>'pi_customer_detail_access', 'label'=>__('Who can access Customer detail in the order','order-calendar-for-woocommerce'),'type'=>'multiselect', 'default'=> '', 'value'=>$this->groups(),  'desc'=>__('Assign group who can access customer details present in the order','order-calendar-for-woocommerce'), 'pro'=>true),

            array('field'=>'pi_product_detail_access', 'label'=>__('Who can access Product detail in the order','order-calendar-for-woocommerce'),'type'=>'multiselect', 'default'=> '', 'value'=>$this->groups(),  'desc'=>__('Assign group who can access product details present in the order','order-calendar-for-woocommerce'), 'pro'=>true),
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
        $this->tab_name = __('Calendar Access (Pro)','order-calendar-for-woocommerce');
        ?>
        <a class=" px-3 text-light d-flex align-items-center  border-left border-right  <?php echo ($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo admin_url( 'admin.php?page='.sanitize_text_field($_GET['page']).'&tab='.$this->this_tab ); ?>">
            <?php echo ( $this->tab_name); ?> 
        </a>
        <?php
    }

    function tab_content(){
        
       ?>
       <div class="alert m-3 alert-warning">
        <h3>Add calendar on the front end of the site using short-code [order_calendar], Available in pro version</h3> 
       </div>
        <form method="post" action="options.php"  class="pisol-setting-form">
        <?php settings_fields( $this->setting_key ); ?>
        <?php
            foreach($this->settings as $setting){
                new pisol_class_form_eqw($setting, $this->setting_key);
            }
        ?>
        <input type="submit" class="mt-3 mb-3 btn btn-primary btn-sm" value="Save Option" />
        </form>
       <?php
    }

    
}

new Pisol_Dtt_Calendar_Access($this->plugin_name);