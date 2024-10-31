<?php

class Pisol_Calendar_Navigation{

    function __construct( $year, $month, $order_type, $url ){
        $this->active = $order_type;
        $this->url = $url.'&year='.$year.'&month='.sprintf("%02d", $month).'&order_type=';
    }

    static function showNavigation( $year, $month, $order_type, $url ){
        $obj = new self( $year, $month, $order_type, $url );
        $html = "";
        $html .= $obj->wooOrderButton();
        $html .= $obj->deliveryDateButton();
        $html .= $obj->pickupDateButton();
        $obj->template($html);
    }

    function template($html){
        echo '<div class="row py-2"><div class="col-12 text-center">';
        echo $html;
        echo '</div></div>';
    }

    function wooOrderButton(){
        return $this->button('order', __('Orders Dates','order-calendar-for-woocommerce'));
    }

    function deliveryDateButton(){
        return $this->button('delivery', __('Delivery Dates','order-calendar-for-woocommerce'));
    }

    function pickupDateButton(){
        return $this->button('pickup', __('Pickup Dates','order-calendar-for-woocommerce'));
    }

    function estimateDateButton(){
        return $this->button('estimate', __('Estimate Dates','order-calendar-for-woocommerce'));
    }

    function button($order_type, $text){
        $class = $order_type == $this->active ? 'btn-primary' : 'btn-secondary';
        $html = '<a href="'.esc_url($this->url.$order_type).'" class="mx-2 btn '.$class.'">';
        $html .= esc_html($text);
        $html .= '</a>';
        return $html;
    }
}