<?php

defined('ABSPATH') or die('Access denied');

class CouponBirds_Size_Chart_Register
{
    private $view_chart;
    private $save_chart;
    private $show_chart;
    public function __construct()
    {
        require_once(CBPSC_PLUGIN_ROOT_PATH . '/view/class-coupon-birds-size-chart-meta-box.php');
        $this->view_chart = new CouponBirds_Size_Chart_MetaBox();
        require_once(CBPSC_PLUGIN_ROOT_PATH . '/includes/class-coupon-birds-size-chart-save.php');
        $this->save_chart = new CouponBirds_Size_Chart_Save();
        require_once(CBPSC_PLUGIN_ROOT_PATH . '/includes/class-coupon-birds-size-chart-show.php');
        $this->show_chart = new CouponBirds_Size_Chart_Show();
        // Register settings
        add_action('init', array($this, 'cb_register_post'));
        add_action('admin_init', array($this, 'cb_add_cap'));
        add_filter('manage_edit-cb-size-charts_columns', array($this, 'cb_size_chart_column'));
        add_filter('manage_cb-size-charts_posts_custom_column', array($this, 'cb_size_chart_manage_column'));
        add_action('admin_enqueue_scripts', array($this,'cb_stylesheet_and_script_register'));
        add_action('wp_enqueue_scripts', array($this,'cb_stylesheet_and_script_register'));
        add_action('admin_action_cb_size_charts_copy', array($this->save_chart,'cb_size_charts_copy'));
        add_action('add_meta_boxes', array($this, 'cb_size_chart_boxes'));
        add_action('save_post', array($this->save_chart, 'cb_save_size_chart'));
        add_filter('woocommerce_product_tabs', array($this->show_chart,'cb_size_chart_tab_show'));
        add_filter('woocommerce_single_product_summary', array($this->show_chart,'cb_size_chart_modal_show'));
    }

    public function cb_register_post()
    {
        $labels = array(
            'name' => __('Birds Charts', 'woo-product-size-chart-by-couponbirds'),
            'singular_name' => __('Size Chart', 'woo-product-size-chart-by-couponbirds'),
            'all_items' => __( 'Size Charts', 'woo-product-size-chart-by-couponbirds' ),
            'add_new' => __('Add Size Chart', 'woo-product-size-chart-by-couponbirds'),
            'add_new_item' => __('New Size Chart', 'woo-product-size-chart-by-couponbirds'),
            'edit_item' => __('Edit Size Chart', 'woo-product-size-chart-by-couponbirds'),
            'view_item' => __('View Size Chart', 'woo-product-size-chart-by-couponbirds'),
            'not_found' => __('Size Chart not found', 'woo-product-size-chart-by-couponbirds'),
            'not_found_in_trash' => __('Size Chart not found in trash', 'woo-product-size-chart-by-couponbirds')
        );

        $capability_type = 'cb_size_charts';
        $caps = array(
            'edit_post' => "edit_{$capability_type}",
            'read_post' => "read_{$capability_type}",
            'delete_post' => "delete_{$capability_type}",
            'edit_posts' => "edit_{$capability_type}s",
            'edit_others_posts' => "edit_others_{$capability_type}s",
            'publish_posts' => "publish_{$capability_type}s",
            'read_private_posts' => "read_private_{$capability_type}s",
            'read' => "read",
            'delete_posts' => "delete_{$capability_type}s",
            'delete_private_posts' => "delete_private_{$capability_type}s",
            'delete_published_posts' => "delete_published_{$capability_type}s",
            'delete_others_posts' => "delete_others_{$capability_type}s",
            'edit_private_posts' => "edit_private_{$capability_type}s",
            'edit_published_posts' => "edit_published_{$capability_type}s",
            'create_posts' => "edit_{$capability_type}s",
            'manage_posts' => "manage_{$capability_type}s",
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'menu_position' => 25,
            'exclude_from_search' => true,
            'capability_type' => $capability_type,
            'capabilities' => $caps,
            'map_meta_cap' => true,
            'rewrite' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'show_in_nav_menus' => false,
            'menu_icon' => CBPSC_PLUGIN_ROOT_URL . '/asset/images/icon.png',
            'supports' => array('title'),
        );
        register_post_type('cb-size-charts', $args);
    }


    public function cb_add_cap()
    {
        $capability_type = 'cb_size_charts';
        $caps = array(
            'edit_post' => "edit_{$capability_type}",
            'delete_post' => "delete_{$capability_type}",
            'edit_posts' => "edit_{$capability_type}s",
            'edit_others_posts' => "edit_others_{$capability_type}s",
            'publish_posts' => "publish_{$capability_type}s",
            'read_private_posts' => "read_private_{$capability_type}s",
            'delete_posts' => "delete_{$capability_type}s",
            'delete_private_posts' => "delete_private_{$capability_type}s",
            'delete_published_posts' => "delete_published_{$capability_type}s",
            'delete_others_posts' => "delete_others_{$capability_type}s",
            'edit_private_posts' => "edit_private_{$capability_type}s",
            'edit_published_posts' => "edit_published_{$capability_type}s",
            'create_posts' => "edit_{$capability_type}s",
        );

        // gets the admin and shop_mamager roles
        $admin = get_role('administrator');
        $shop_manager = get_role('shop_manager');

        foreach ($caps as $key => $cap) {
            $admin->add_cap($cap);
            $shop_manager->add_cap($cap);
        }
    }

    public function cb_size_chart_manage_column($column)
    {
        global $post;
        if ($column == 'action'){
            if (isset($post) && !empty($post)) {
                if ('' !== $post->post_title) {
                    echo sprintf(
                        "<a href='%s' class='cb-clone-chart' title='%s' rel='permalink'></a>",
                        esc_url(wp_nonce_url(add_query_arg(array(
                            'action' => 'cb_size_charts_copy',
                            'post' => $post->ID,
                        ), admin_url('admin.php')), 'size_chart_duplicate_post_callback')),
                        esc_attr__('Clone', 'size-chart-for-woocommerce')
                    );
                }
            }
        }
    }

    public function cb_size_chart_column($columns)
    {
        $new_columns = (is_array($columns) ? $columns : array());
        $temp = $new_columns['date'];
        unset( $new_columns['date'] );
        $new_columns['action'] = __('action', 'size-chart-for-woocommerce');
        $new_columns['date'] = $temp;
        return $new_columns;
    }

    public function cb_stylesheet_and_script_register(){
        $css1 = 'coupon-birds-size-chart-style';
        wp_register_style(
            $css1,
            CBPSC_PLUGIN_ROOT_URL.'/asset/css/woo-product-size-chart-by-couponbirds.css',
            array(),
            '1.0.3',
            'all'
        );
        wp_register_style(
            'coupon-birds-select2-style',
            CBPSC_PLUGIN_ROOT_URL.'/asset/css/select2.css',
            array(),
            '1.0.3',
            'all'
        );
        wp_enqueue_style($css1);
        wp_enqueue_style('coupon-birds-select2-style');
        wp_register_script(
            'coupon-birds-size-chart-description-script',
            CBPSC_PLUGIN_ROOT_URL.'/asset/js/cb-size-charts-description.js',
            array('select2'),
            '1.0.2',
            true
        );
        wp_register_script(
            'coupon-birds-size-chart-show-modal-script',
            CBPSC_PLUGIN_ROOT_URL.'/asset/js/cb-size-chart-show-modal.js',
            array(),
            '1.0.2',
            true
        );
    }

    public function cb_size_chart_boxes() {
        add_meta_box('cb-chart-label','Chart Label',array($this->view_chart, 'cb_size_chart_label'),'cb-size-charts','normal','high');
        add_meta_box('cb-chart-tab','Size Chart',array($this->view_chart, 'cb_size_chart_tab'),'cb-size-charts','normal');
        add_meta_box('cb-chart-categories','Chart Categories',array($this->view_chart, 'cb_size_chart_select_category'),'cb-size-charts','normal');
        add_meta_box('cb-chart-products','Chart Products',array($this->view_chart, 'cb_size_chart_select_product'),'cb-size-charts','normal');
        add_meta_box('cb-chart-position','Chart Position',array($this->view_chart, 'cb_size_chart_select_position'),'cb-size-charts','normal');
        add_meta_box('cb-chart-style','Chart Table Style',array($this->view_chart, 'cb_size_chart_select_style'),'cb-size-charts','normal');
        add_meta_box('cb-chart-link-show','Enable  Hyperlink',array($this->view_chart, 'cb_size_chart_link_show'),'cb-size-charts','normal','low');
    }
}
