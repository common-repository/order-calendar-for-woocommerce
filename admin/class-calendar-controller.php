<?php

class Pisol_Calendar_Controller{

    public $order_types = array(
        'order',
        'delivery',
        'pickup',
        'estimate'
    );

   

    function __construct($tab_name){
        $this->order_type = $this->activeTab();
        $this->tab = $tab_name;
        $this->year = $this->getYear();
        $this->month = $this->getMonth();
    }

    static function show($tab_name){
        $obj = new self( $tab_name );
        $url = $obj->getUrl( false );
        $orders = $obj->getOrders();
        $obj->showNavigation( $url );
        if($obj->order_type == 'pickup' || $obj->order_type == 'delivery'){
            if($obj->isThereDateAndTimePlugin()){
                $obj->showCalendar( $url, $orders );
            }else{
                $obj->missingDateTimePluginInfo();
            }
        }else{
            $obj->showCalendar( $url, $orders );
        }
    }

    function getOrders(){
        $orders = Pisol_Calendar_Orders::getOrders($this->order_type, $this->year, $this->month);
        return $orders;
    }

    function getYear(){
        if( isset($_GET['year']) ){
 
            $year = (int)sanitize_text_field($_GET['year']);
         
        }else{
 
            $year = current_time('Y');  
         
        }   
        return $year;          
    }

    function getMonth(){
        if( isset( $_GET['month'] ) ){
 
            $month = (int)sanitize_text_field($_GET['month']);
         
        }else{
 
            $month = current_time('m');
         
        }     
        return $month;
    }

    function activeTab(){
        $active_tab = (isset($_GET['order_type']) && in_array($_GET['order_type'], $this->order_types) ) ? sanitize_text_field($_GET['order_type']) : 'order';
        return $active_tab;
    }

    function showNavigation( $url ){
        Pisol_Calendar_Navigation::showNavigation( $this->year, $this->month, $this->order_type, $url );
    }

    function showCalendar( $url, $orders ){
        $html = Pisol_Display_Calendar::showCalendar($this->year, $this->month, $this->order_type, $url, $orders  );
        $this->calendarTemplate( $html );
    }

    function calendarTemplate( $html ){
        echo '<div class="row py-3"><div class="col-12">';
        echo $html;
        echo '</div></div>';
    }

    function getUrl(){
        $url = admin_url( 'admin.php?page='.sanitize_text_field($_GET['page']).'&tab='.$this->tab);
        return $url;
    }

    function isThereDateAndTimePlugin(){
        if(is_plugin_active( 'pi-woocommerce-order-date-time-and-type/pi-woocommerce-order-date-time-and-type.php') || is_plugin_active( 'pi-woocommerce-order-date-time-and-type-pro/pi-woocommerce-order-date-time-and-type-pro.php')){
            return true;
        }
        return false;
    }

    function missingDateTimePluginInfo(){
        include 'partials/missing-date-time-plugin.php';
    }
    
}