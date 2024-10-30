<?php
/*
Plugin Name: CouponBirds Product Size Charts for WooCommerce
Plugin URI: https://www.couponbirds.com/size-charts
Description: CouponBirds Product Size Charts for WooCommerce allows you to easily create custom size charts for all the products you have available.
Version: 1.0.4
Author: CouponBirds
Author URI: https://www.couponbirds.com
License: GPLv3

CouponBirds Product Size Charts for WooCommerce is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

CouponBirds Product Size Charts for WooCommerce is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CouponBirds Product Size Charts for WooCommerce. If not, see https://www.gnu.org/licenses/gpl.html.
 **/
defined('ABSPATH') or die('Access denied');

!defined('CBPSC_PLUGIN_ROOT_PATH') && define('CBPSC_PLUGIN_ROOT_PATH', dirname(__FILE__));
!defined('CBPSC_PLUGIN_ROOT_URL') && define('CBPSC_PLUGIN_ROOT_URL', untrailingslashit(plugins_url('/', __FILE__)));

register_activation_hook(__FILE__,
    function () {
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')), true) && !is_plugin_active_for_network('woocommerce/woocommerce.php')) {
            die('Require Woocommerce');
        } else {
            $coupon_birds_size_chart_options = get_option('coupon_birds_size_chart_options');
            $coupon_birds_size_chart_options['template'] = [];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Empty", 'data' => '[[""]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Men's T-Shirts & Polo Shirts", 'data' => '[["TO FIT CHEST SIZE","INCHES","CM"],["XXXS","30-32","76-81"],["XXS","32-34","81-86"],["XS","34-36","86-91"],["S","36-38","91-96"],["M","38-40","96-101"],["L","40-42","101-106"],["XL","42-44","106-111"],["XXL","44-46","111-116"],["XXXL","46-48","116-121"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Women's T-Shirts Sizes", 'data' => '[["UK SIZE","BUST","BUST","WAIST","WAIST","HIPS","HIPS"],["","INCHES","CM","INCHES","CM","INCHES","CM"],["4","31","78","24","60","33","83.5"],["6","32","80.5","25","62.5","34","86"],["8","33","83","26","65","35","88.5"],["10","35","88","28","70","37","93.5"],["12","37","93","30","75","39","98.5"],["14","39","98","31","80","41","103.5"],["16","41","103","33","85","43","108.5"],["18","44","110.5","36","92.5","46","116"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Men's Shirts", 'data' => '[["TO FIT CHEST SIZE","INCHES","CM","TO FIT NECK SIZE","INCHES","CM"],["XXXS","30-32","76-81","XXXS","14","36"],["XXS","32-34","81-86","XXS","14.5","37.5"],["XS","34-36","86-91","XS","15","38.5"],["S","36-38","91-96","S","15.5","39.5"],["M","38-40","96-101","M","16","41.5"],["L","40-42","101-106","L","17","43.5"],["XL","42-44","106-111","XL","17.5","45.5"],["XXL","44-46","111-116","XXL","18.5","47.5"],["XXXL","46-48","116-121","XXXL","19.5","49.5"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Women's Dress Sizes", 'data' => '[["SIZE","NUMERIC SIZE","BUST","WAIST","HIP"],["XXXS","000","30","23","33"],["XXS","00","31.5","24","34"],["XS","0","32.5","25","35"],["XS","2","33.5","26","36"],["S","4","34.5","27","37"],["S","6","35.5","28","38"],["M","8","36.5","29","39"],["M","10","37.5","30","40"],["L","12","39","31.5","41.5"],["L","14","40.5","33","43"],["XL","16","42","34.5","44.5"],["XL","18","44","36","46.5"],["XXL","20","46","37.5","48.5"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Men's Jeans & Trousers Size", 'data' => '[["TO FIT WAIST SIZE","INCHES","CM"],["26","26","66"],["28","28","71"],["29","29","73.5"],["30","30","76"],["31","31","78.5"],["32","32","81"],["33","33","83.5"],["34","34","86"],["36","36","91"],["38","38","96"],["40","40","101"],["","",""],["TO FIT INSIDE LEG LENGTH","INCHES","CM"],["Short","30","76"],["Regular","32","81"],["Long","34","86"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Women's Jeans Sizes", 'data' => '[["Size","Waist","Hip"],["24","24","35"],["25","25","36"],["26","26","37"],["27","27","38"],["28","28","39"],["29","29","40"],["30","30","41"],["31","31","42"],["32","32","43"],["33","33","44"],["34","34","45"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Men's Waistcoats", 'data' => '[["CHEST MEASUREMENT","INCHES","CM"],["32","32","81"],["34","34","86"],["36","36","91"],["38","38","96"],["40","40","101"],["42","42","106"],["44","44","111"],["46","46","116"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Women's Clothes Sizes", 'data' => '[["UK SIZE","BUST","BUST","WAIST","WAIST","HIPS","HIPS"],["","INCHES","CM","INCHES","CM","INCHES","CM"],["4","31","78","24","60","33","83.5"],["6","32","80.5","25","62.5","34","86"],["8","33","83","26","65","35","88.5"],["10","35","88","28","70","37","93.5"],["12","37","93","30","75","39","98.5"],["14","39","98","31","80","41","103.5"],["16","41","103","33","85","43","108.5"],["18","44","110.5","36","92.5","46","116"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Men's Shoes Size", 'data' => '[["US","Euro","UK","Inches","CM"],["6","39","5.5","9.25","23.5"],["6.5","39","6","9.5","24.1"],["7","40","6.5","9.625","24.4"],["7.5","40-41","7","9.75","24.8"],["8","41","7.5","9.9375","25.4"],["8.5","41-42","8","10.125","25.7"],["9","42","8.5","10.25","26"],["9.5","42-43","9","10.4375","26.7"],["10","43","9.5","10.5625","27"],["10.5","43-44","10","10.75","27.3"],["11","44","10.5","10.9375","27.9"],["11.5","44-45","11","11.125","28.3"],["12","45","11.5","11.25","28.6"],["13","46","12.5","11.5625","29.4"],["14","47","13.5","11.875","30.2"],["15","48","14.5","12.1875","31"],["16","49","15.5","12.5","31.8"]]'];
            $coupon_birds_size_chart_options['template'][] = ['name' => "Women's Shoes Sizes", 'data' => '[["US","Euro","UK","Inches","CM"],["4","35","2","8.1875","20.8"],["4.5","35","2.5","8.375","21.3"],["5","35-36","3","8.5","21.6"],["5.5","36","3.5","8.75","22.2"],["6","36-37","4","8.875","22.5"],["6.5","37","4.5","9.0625","23"],["7","37-38","5","9.25","23.5"],["7.5","38","5.5","9.375","23.8"],["8","38-39","6","9.5","24.1"],["8.5","39","6.5","9.6875","24.6"],["9","39-40","7","9.875","25.1"],["9.5","40","7.5","10","25.4"],["10","40-41","8","10.1875","25.9"],["10.5","41","8.5","10.3125","26.2"],["11","41-42","9","10.5","26.7"],["11.5","42","9.5","10.6875","27.1"],["12","42-43","10","10.875","27.6"]]'];
            update_option('coupon_birds_size_chart_options', $coupon_birds_size_chart_options);
        }
    }
);

require_once('includes/class-coupon-birds-size-chart-register.php');
new CouponBirds_Size_Chart_Register();

