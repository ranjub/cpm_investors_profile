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
if (!defined('ABSPATH')) {
    exit;
}

// Define constants for plugin paths and URLs
define('CPM_INVESTORS_DIR', plugin_dir_path(__FILE__));
define('CPM_INVESTORS_URL', plugin_dir_url(__FILE__));
define('CPM_INVESTORS_ADMIN_DIR', CPM_INVESTORS_DIR . 'admin/');
define('CPM_INVESTORS_PUBLIC_DIR', CPM_INVESTORS_DIR . 'public/');
define('CPM_INVESTORS_TEMPLATES_DIR', CPM_INVESTORS_DIR . 'templates/');

// Load single template
function cpm_investors_load_template($template) {
    if (is_singular('cpm_investor')) {
        $template = CPM_INVESTORS_TEMPLATES_DIR . 'single-cpm_investor.php';
    }
    return $template;
}
add_filter('template_include', 'cpm_investors_load_template');

// Load archive template
function cpm_investors_load_archive_template($template) {
    if (is_post_type_archive('cpm_investor')) {
        $template = CPM_INVESTORS_TEMPLATES_DIR . 'archive-cpm_investor.php';
    }
    return $template;
}
add_filter('template_include', 'cpm_investors_load_archive_template');

// Register sidebar
function cpm_investors_register_sidebar() {
    register_sidebar(array(
        'name'          => __('Investor Sidebar', 'cpm_investors'),
        'id'            => 'investor-sidebar',
        'description'   => __('Widgets in this area will be shown on the single investor pages.', 'cpm_investors'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'cpm_investors_register_sidebar');

// Enqueue scripts and styles
function cpm_investors_enqueue_scripts() {
    // Enqueue public scripts and styles
    wp_enqueue_script('cpm-investors-public-script', CPM_INVESTORS_URL . 'public/cpm-initailizer-public.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);
    wp_enqueue_style('cpm-investors-public-style', CPM_INVESTORS_URL . 'public/cpm-investor-public.css');
    wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');

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

// Enqueue admin scripts and styles separately
function cpm_investors_enqueue_admin_scripts() {
    wp_enqueue_script('cpm-investors-admin-script', CPM_INVESTORS_URL . 'admin/cpm-initializer-admin.js', array('jquery'), '1.0', true);
    wp_enqueue_style('cpm-investors-admin-style', CPM_INVESTORS_URL . 'admin/cpm-styles-admin.css');
}
add_action('admin_enqueue_scripts', 'cpm_investors_enqueue_admin_scripts');

// Include admin and public files
if (is_admin()) {
    require_once CPM_INVESTORS_ADMIN_DIR . 'cpm-investor-admin.php';
} else {
    require_once CPM_INVESTORS_PUBLIC_DIR . 'cpm-investor-public.php';
}