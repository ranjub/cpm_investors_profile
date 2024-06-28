<?php
/*
Plugin Name: CPM Investors Profile
Description: A plugin to create a custom post type for Investors.
Version: 1.0
Author: Ranju and Prashna
License: GPL2
Text Domain: cpm_investors
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants for plugin paths and URLs
define('CPM_INVESTORS_DIR', plugin_dir_path(__FILE__));
define('CPM_INVESTORS_URL', plugin_dir_url(__FILE__));
define('CPM_INVESTORS_ADMIN_DIR', CPM_INVESTORS_DIR . 'admin/');
define('CPM_INVESTORS_PUBLIC_DIR', CPM_INVESTORS_DIR . 'public/');
define('CPM_INVESTORS_TEMPLATES_DIR', CPM_INVESTORS_DIR . 'templates/');

// Include admin and public files
if (is_admin()) {
    require_once CPM_INVESTORS_ADMIN_DIR . 'cpm-investor-admin.php';
} else {
    require_once CPM_INVESTORS_PUBLIC_DIR . 'cpm-investor-public.php';
}

// Enqueue scripts and styles
function cpm_investors_enqueue_scripts() {
    // Enqueue admin scripts and styles
    if (is_admin()) {
        wp_enqueue_script('cpm-investors-admin-script', CPM_INVESTORS_URL . 'admin/cpm-initializer-admin.js', array('jquery'), '1.0', true);
        wp_enqueue_style('cpm-investors-admin-style', CPM_INVESTORS_URL . 'admin/cpm-styles-admin.css');
    }

    // Enqueue public scripts and styles
    else {
        wp_enqueue_script('cpm-investors-public-script', CPM_INVESTORS_URL . 'public/cpm-initializer-public.js', array('jquery'), '1.0', true);
        wp_enqueue_style('cpm-investors-public-style', CPM_INVESTORS_URL . 'public/cpm-styles-public.css');
    }

    // Enqueue archive-specific stylesheet
    if (is_post_type_archive('cpm_investor')) {
        wp_enqueue_style('cpm-investors-archive-style', CPM_INVESTORS_URL . 'templates/archive-cpm_investor.css');
    }

    // Enqueue single-specific stylesheet
    if (is_singular('cpm_investor')) {
        wp_enqueue_style('cpm-investors-single-style', CPM_INVESTORS_URL . 'templates/single-cpm_investor.css');
    }
}
add_action('wp_enqueue_scripts', 'cpm_investors_enqueue_scripts');