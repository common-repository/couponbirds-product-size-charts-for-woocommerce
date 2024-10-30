<?php

defined('ABSPATH') or die('Access denied');

class CouponBirds_Size_Chart_Save
{
    private $view_chart;
    public function __construct()
    {
    }
    public function cb_save_size_chart($post_id){
        if (get_post($post_id)->post_type==='cb-size-charts'){
            $cb_chart_tab=filter_input(INPUT_POST,'cb_chart_tab',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $cb_chart_products=filter_input(INPUT_POST,'cb_chart_products',FILTER_SANITIZE_STRING,FILTER_REQUIRE_ARRAY);
            $cb_chart_categories=filter_input(INPUT_POST,'cb_chart_categories',FILTER_SANITIZE_STRING,FILTER_REQUIRE_ARRAY);
            $cb_chart_style=filter_input(INPUT_POST,'cb_chart_style',FILTER_SANITIZE_STRING);
            $cb_chart_link_show=filter_input(INPUT_POST,'cb_chart_link_show',FILTER_SANITIZE_STRING);
            $cb_chart_position=filter_input(INPUT_POST,'cb_chart_position',FILTER_SANITIZE_STRING);
            $cb_chart_label=filter_input(INPUT_POST,'cb_chart_label',FILTER_SANITIZE_STRING);
            $cb_chart_products_number=[];
            $cb_chart_categories_number=[];
            if (isset($cb_chart_products)&&is_array($cb_chart_products)){
                foreach ($cb_chart_products as $product){
                    $cb_chart_products_number[]=intval($product);
                }
            }
            if (isset($cb_chart_categories)&&is_array($cb_chart_categories)) {
                foreach ($cb_chart_categories as $category) {
                    $cb_chart_categories_number[] = intval($category);
                }
            }
            update_post_meta($post_id,'cb_chart_tab',$cb_chart_tab);
            update_post_meta($post_id,'cb_chart_products',json_encode($cb_chart_products_number));
            update_post_meta($post_id,'cb_chart_categories',json_encode($cb_chart_categories_number));
            update_post_meta($post_id,'cb_chart_style',$cb_chart_style);
            update_post_meta($post_id,'cb_chart_link_show',$cb_chart_link_show);
            update_post_meta($post_id,'cb_chart_position',$cb_chart_position);
            update_post_meta($post_id,'cb_chart_label',$cb_chart_label);
        }
    }
    public function cb_size_charts_copy(){
        $get_request_get = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_STRING );
        $size_chart_id = ( isset( $get_request_get ) ? absint( $get_request_get ) : 0 );

        if (isset($get_request_get) && !empty($get_request_get)) {
            $temp = get_post($size_chart_id);
            $post_type = $temp->post_type;
            $copy = array(
                'post_title'   => $temp->post_title.'_copy',
                'post_status'  => 'draft',
                'post_type'    => $temp->post_type,
                'post_content' => $temp->post_content,
                'post_author'  => $temp->post_author
            );
            $new_id = wp_insert_post($copy);
            update_post_meta($new_id,'cb_chart_tab',get_post_meta($size_chart_id,'cb_chart_tab',true));
            update_post_meta($new_id,'cb_chart_products',get_post_meta($size_chart_id,'cb_chart_products',true));
            update_post_meta($new_id,'cb_chart_categories',get_post_meta($size_chart_id,'cb_chart_categories',true));
            update_post_meta($new_id,'cb_chart_style',get_post_meta($size_chart_id,'cb_chart_style',true));
            update_post_meta($new_id,'cb_chart_link_show',get_post_meta($size_chart_id,'cb_chart_link_show',true));
            update_post_meta($new_id,'cb_chart_position',get_post_meta($size_chart_id,'cb_chart_position',true));
            update_post_meta($new_id,'cb_chart_label',get_post_meta($size_chart_id,'cb_chart_label',true));
            wp_redirect( admin_url('edit.php?post_type='.$post_type));
            exit;
        } else {
            wp_die( esc_html__( 'could not find post: ' . $size_chart_id ), 'cb-size-charts' );
        }
    }
}
