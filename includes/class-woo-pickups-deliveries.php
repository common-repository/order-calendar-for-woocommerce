<?php

class Pisol_Calendar_Woo_Pickups_Deliveries{
    function __construct($start_date, $end_date, $delivery_type){
        $this->start_date =  $start_date ;
        $this->end_date =  $end_date ;
        $this->delivery_type = $delivery_type;
        $this->date_array = $this->generateDateArray($this->start_date, $this->end_date);
    }

    static function getOrders($start_date, $end_date, $delivery_type){
        $obj = new self( $start_date, $end_date, $delivery_type );
        return $obj->orders();
    }

    function orders(){
        $orders = $this->ordersBetweenDate();
        return $this->dateArrayOfOrders( $orders );
    }

    function generateDateArray($start, $end){
        $date_array = array();
        $count = 0;
        while($count < 31){
            $date = date('Y/m/d', strtotime('+'.$count.' day', strtotime($start)));
            $date_array[] = $date;
            $count++;
        }
        return $date_array;
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
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'pi_system_delivery_date',
                    'value'   => $this->date_array,
                    'compare' => 'IN',
               ),
               array(
                'key'     => 'pi_delivery_type',
                'value'   => $this->delivery_type,
                'compare' => 'LIKE',
           ),
          ),
		);
		$orders = wc_get_orders($args);
		return $orders;
    }
    
    function dateArrayOfOrders($orders){
        $date_array = array();
        foreach( $orders as $order ){
            $date =$order->get_meta('pi_system_delivery_date',true);

            $date = date('Y-m-d', strtotime($date));
            $date_array[$date][] = $order->get_id();
        }
        return $date_array;
    }
}