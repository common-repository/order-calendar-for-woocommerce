<?php
if(!empty($orders)):
    echo '<div class="order-box">';
    echo '<div class="p-3">';
    echo '<h3 class="my-0">';
    if($_POST['order_type'] == 'order'){
        echo __('Orders placed on: ', 'order-calendar-for-woocommerce'). date(get_option( 'date_format' ), strtotime($_POST['date']));
    }elseif($_POST['order_type'] == 'pickup'){
     echo __('Orders pickup on: ', 'order-calendar-for-woocommerce'). date(get_option( 'date_format' ), strtotime($_POST['date']));
    }elseif($_POST['order_type'] == 'delivery'){
        echo __('Orders delivery on: ', 'order-calendar-for-woocommerce'). date(get_option( 'date_format' ), strtotime($_POST['date']));
    }

    echo '</h3>';
    echo '</div>';
foreach($orders as $order){
    $status = str_replace('wc-', '', get_post_status( $order ));
    echo '<a target="_blank" class="btn btn-primary btn-sm m-3 pi-status-'.esc_attr($status).' pi-status" href="'.esc_url(admin_url('post.php?post='.$order.'&action=edit')).'" title="'.esc_attr($status).'">';
    echo __('Order no', 'order-calendar-for-woocommerce').': '.$order;
    echo '</a>';
}
echo '<img src="'.PISOL_DTT_EDD_CALENDAR_URL.'admin/img/time.png" class="img-fluid w100">';
echo '</div>';
endif;