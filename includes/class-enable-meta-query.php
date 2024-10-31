<?php


class pisol_calendar_enable_meta_query{


    function __construct(){
    /* this is needed else woocommerce don't do meta query search on order for custom meta field */
        add_filter( 'woocommerce_get_wp_query_args', array($this, 'addMetaToQuery'), 10, 2 );
    }
        
    function addMetaToQuery( $wp_query_args, $query_vars ){
        if ( isset( $query_vars['meta_query'] ) ) {
            $meta_query = isset( $wp_query_args['meta_query'] ) ? $wp_query_args['meta_query'] : [];
            $wp_query_args['meta_query'] = array_merge( $meta_query, $query_vars['meta_query'] );
        }
        return $wp_query_args;
    }

}

new pisol_calendar_enable_meta_query();