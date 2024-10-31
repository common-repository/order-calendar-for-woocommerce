<?php

class Pisol_Calendar_Orders{

    function __construct($order_type, $year, $month){
        $this->order_type = $order_type;
        $this->year = $year;
        $this->month = $month;
        $this->start_date = $this->getStartDate();
        $this->end_date = $this->getEndDate();
    }

    static function getOrders($order_type, $year, $month){
        $obj = new self($order_type, $year, $month);
        return $obj->orders();
    }

    function orders(){
        $orders = array();
        if($this->order_type == 'order'){
            $orders = Pisol_Calendar_Woo_Orders::getOrders($this->start_date, $this->end_date);
        }elseif($this->order_type == 'pickup'){
            $orders = Pisol_Calendar_Woo_Pickups_Deliveries::getOrders($this->start_date, $this->end_date, $this->order_type);
        }elseif($this->order_type == 'delivery'){
            $orders = Pisol_Calendar_Woo_Pickups_Deliveries::getOrders($this->start_date, $this->end_date, $this->order_type);
        }
        return $orders;
    }

    function getStartDate(){
        $start_date = $this->year.'-'.sprintf('%02d',$this->month).'-01';
        return $start_date;
    }

    function getEndDate(){
        $timestamp = strtotime($this->getStartDate());
        $days_in_month  = date('t', $timestamp);
        $end_date = $this->year.'-'.sprintf('%02d',$this->month).'-'.$days_in_month;
        return $end_date;
    }

    
}