<?php
/**
 * Plugin Name: WooCommerce Shipping External Fetch
 * Plugin URI: https://github.com/michaelfranzl/woocommerce-shipping-external-fetch
 * Description: Fetch shipping rates from an external web service using JSON
 * Version: 0.2.0
 * Author: Michael Franzl and updated by Benjamin Sierra
 * Author URI: https://michaelfranzl.com
 * Requires at least: 4.0
 * Tested up to: 4.8
 * WC requires at least: 3.0
 * WC tested up to: 7.8.2
 * Copyright: 2023 Michael Franzl
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 */

if (!defined('ABSPATH')) {
    exit;
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('plugins_loaded', 'wc_external_fetch_shipping_init');

    function wc_external_fetch_shipping_init()
    {
        define('EXTERNAL_FETCH_SHIPPING_VERSION', '0.1.0');
        define('EXTERNAL_FETCH_SHIPPING_DEBUG', defined('WP_DEBUG') && WP_DEBUG && (!defined('WP_DEBUG_DISPLAY') || WP_DEBUG_DISPLAY));
        add_filter('woocommerce_shipping_methods', 'wc_external_fetch_shipping_add_to_shipping_methods');
        add_action('woocommerce_shipping_init', 'wc_external_fetch_shipping_shipping_init');
        add_action('wp_enqueue_scripts', 'wc_external_fetch_shipping_enqueue_scripts');
        add_action('plugins_loaded', 'wc_external_fetch_shipping_load_plugin_textdomain');
    }

    function wc_external_fetch_shipping_add_to_shipping_methods($shipping_methods)
    {
        $shipping_methods['external_fetch'] = 'WC_Shipping_External_Fetch';
        return $shipping_methods;
    }

    function wc_external_fetch_shipping_shipping_init()
    {
        include_once('includes/class-wc-shipping-external-fetch.php');
    }

    function wc_external_fetch_shipping_enqueue_scripts()
    {
        wp_enqueue_style('woocommerce-external-fetch-shipping-style', plugins_url('/assets/css/style.css', __FILE__));
    }

    function wc_external_fetch_shipping_load_plugin_textdomain()
    {
        load_plugin_textdomain('woocommerce-external-fetch-shipping', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
}
