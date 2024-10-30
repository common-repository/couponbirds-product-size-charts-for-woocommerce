<?php
defined( 'WP_UNINSTALL_PLUGIN' ) or die('Access denied');

delete_option('coupon_birds_size_chart_options');
unregister_post_type('cb-size-charts');