<?php

class Pisol_Calendar_Woo_Orders{
    function __construct($start_date, $end_date){
        $this->start_date = $this->startAdjust( $start_date );
        $this->end_date = $this->endAdjust( $end_date );
    }

    function startAdjust( $start_date ){
        $start_date = date('Y-m-d', strtotime('-1 day', strtotime($start_date) ));
        return $start_date;
    }

    function endAdjust( $end_date ){
        $end_date = date('Y-m-d', strtotime('+1 day', strtotime($end_date)));
        return $end_date;
    }

    static function getOrders($start_date, $end_date){
        $obj = new self( $start_date, $end_date );
        return $obj->orders();
    }

    function orders(){
        $orders = $this->ordersBetweenDate();
        return $this->dateArrayOfOrders( $orders );
    }

    function orderStatus(){
        if(function_exists('wc_get_order_statuses')){
            $order_status = wc_get_order_statuses();
        }else{
            return ["pending","processing","on-hold","completed"];
        }
        
        $processed = array();
        foreach($order_status as  $key => $val){
            $new_key = str_replace('wc-','',$key);
            $processed[] = $new_key;
        }
        return $processed;
    }

    function ordersBetweenDate(){
        $all_status = $this->orderStatus();
		$args = array(
            'limit'=>-1,
			'orderby' => 'date',
			'order' => 'DESC',
            'status' => apply_filters('pisol_calendar_order_status', $all_status),
            'date_before' => $this->end_date,
            'date_after'=> $this->start_date
		);
		$orders = wc_get_orders($args);
		return $orders;
    }
    
    function dateArrayOfOrders($orders){
        $date_array = array();
        foreach( $orders as $order ){
            $date_obj = $order->get_date_created();
            $date = $date_obj->date('Y-m-d');
            $date_array[$date][] = $order->get_id();
        }
        return $date_array;
    }
}