<?php
class Pisol_Display_Calendar {  

    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
     
    /**
     * Constructor
     */
    public function __construct( $year, $month, $order_type, $url, $orders ){  
        $this->dayLabels = array(
            date_i18n('D', strtotime('Monday')),
            date_i18n('D', strtotime('Tuesday')),
            date_i18n('D', strtotime('Wednesday')),
            date_i18n('D', strtotime('Thursday')),
            date_i18n('D', strtotime('Friday')),
            date_i18n('D', strtotime('Saturday')),
            date_i18n('D', strtotime('Sunday')),
        );     
        $this->naviHref = $url.'&order_type='.$order_type;
        $this->year = $year;
        $this->month = $month;
        $this->orders = $orders;
        $this->order_type = $order_type;
    }

    static function showCalendar( $year, $month, $order_type, $url, $orders ){
        $obj = new self( $year, $month, $order_type, $url, $orders );
        return $obj->show();
    }
     
    
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() {
        $year  = $this->year;
         
        $month = $this->month;
         
                 
         
        $this->currentYear = $year;
         
        $this->currentMonth = $month;
         
        $this->daysInMonth = $this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content .= $this->_showDay($i*7+$j);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }

    function getFormatedDate($day){
        $formated_date = $this->year.'-'.sprintf('%02d',$this->month).'-'.sprintf('%02d',$day);
        return $formated_date;
    }

    function orderCount($day){
        $date = $this->getFormatedDate($day);
        if( !isset($this->orders[$date]) ) return 0;
        return count($this->orders[$date]);
    }

    function ordersPlaced($day){
        $date = $this->getFormatedDate($day);
        $orders = isset($this->orders[$date]) ? $this->orders[$date] : array();
        return json_encode($orders);
    }

    function orderCountTemplate($day){
        $date = $this->getFormatedDate($day);
        $order_count = $this->orderCount($day);
        $orders_placed = $this->ordersPlaced($day);
        $html = "";
        if( !empty( $order_count ) ){
            $html .= '<a href="javascript:void(0);" class="pisol-order-count" data-orders="'.$orders_placed.'" data-order_type="'.$this->order_type.'" data-date="'.$date.'">'.$order_count.'</a>';
        }
        return $html;
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;   
             
        }else{
             
            $this->currentDate =null;
 
            $cellContent=null;
        }
             
         
        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'">'.$cellContent.$this->orderCountTemplate($cellContent).'</li>';
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.esc_attr($this->naviHref).'&month='.esc_attr(sprintf('%02d',$preMonth)).'&year='.esc_attr($preYear).'">'.__('Prev','order-calendar-for-woocommerce').'</a>'.
                    '<span class="title">'.date_i18n('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.esc_attr($this->naviHref).'&month='.esc_attr(sprintf("%02d", $nextMonth)).'&year='.esc_attr($nextYear).'">'.__('Next','order-calendar-for-woocommerce').'</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}