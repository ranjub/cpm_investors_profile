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

// Register Custom Post Type
function cpm_investors_custom_post_type()
{
    $labels = array(
        'name'               => _x('Investors', 'post type general name', 'cpm_investors'),
        'singular_name'      => _x('Investor', 'post type singular name', 'cpm_investors'),
        'menu_name'          => _x('Investors', 'admin menu', 'cpm_investors'),
        'name_admin_bar'     => _x('Investor', 'add new on admin bar', 'cpm_investors'),
        'add_new'            => _x('Add New', 'investor', 'cpm_investors'),
        'add_new_item'       => __('Add New Investor', 'cpm_investors'),
        'new_item'           => __('New Investor', 'cpm_investors'),
        'edit_item'          => __('Edit Investor', 'cpm_investors'),
        'view_item'          => __('View Investor', 'cpm_investors'),
        'all_items'          => __('All Investors', 'cpm_investors'),
        'search_items'       => __('Search Investors', 'cpm_investors'),
        'parent_item_colon'  => __('Parent Investors:', 'cpm_investors'),
        'not_found'          => __('No investors found.', 'cpm_investors'),
        'not_found_in_trash' => __('No investors found in Trash.', 'cpm_investors')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'investors'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );

    register_post_type('cpm_investor', $args);
}
add_action('init', 'cpm_investors_custom_post_type');


// Load single template
function cpm_investors_load_template($template)
{
    if (is_singular('cpm_investor')) {
        $template = CPM_INVESTORS_TEMPLATES_DIR . 'single-cpm_investor.php';
    }
    return $template;
}
add_filter('template_include', 'cpm_investors_load_template');

// Load archive template
function cpm_investors_load_archive_template($template)
{
    if (is_post_type_archive('cpm_investor')) {
        $template = CPM_INVESTORS_TEMPLATES_DIR . 'archive-cpm_investor.php';
    }
    return $template;
}
add_filter('template_include', 'cpm_investors_load_archive_template');

// Register sidebar
function cpm_investors_register_sidebar()
{
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
function cpm_investors_enqueue_scripts()
{
    // Enqueue public scripts and styles
    wp_enqueue_script('jquery');
    wp_enqueue_script('cpm-investors-public-script', CPM_INVESTORS_URL . 'public/cpm-initailizer-public.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);
    wp_enqueue_style('cpm-investors-public-style', CPM_INVESTORS_URL . 'public/cpm-investor-public.css');
    wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
    //enqueue font awesome
    wp_enqueue_style('cpm_investor_font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
    // Enqueue archive-specific stylesheet
    if (is_post_type_archive('cpm_investor')) {
        wp_enqueue_style('cpm-investors-archive-style', CPM_INVESTORS_URL . 'templates/archive-cpm_investor.css');
    }

    // Enqueue single-specific stylesheet
    if (is_singular('cpm_investor')) {
        wp_enqueue_style('cpm-investors-single-style', CPM_INVESTORS_URL . 'templates/single-cpm_investor.css');
    }

    // js for search suggestion
    wp_enqueue_script('search-suggeston-public', plugin_dir_url(__FILE__) . '/public/search-suggeston-public.js', array('jquery'), null, true);
    wp_localize_script('search-suggeston-public', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

    //js file to make ajax request 
    wp_enqueue_script('currency-conversion-script', plugin_dir_url(__FILE__) . '/assets/currencyconverter.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'cpm_investors_enqueue_scripts');

// Enqueue admin scripts and styles separately
function cpm_investors_enqueue_admin_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('cpm-investors-admin-script', plugin_dir_url(__FILE__) . 'admin/cpm-initializer-admin.js', array('jquery'), '1.0', true);
    wp_enqueue_style('cpm-investors-admin-style', plugin_dir_url(__FILE__) . 'admin/cpm-styles-admin.css');
    wp_enqueue_style('images', plugin_dir_url(__FILE__) . 'money-exchange.png');
    wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-datepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');
    wp_localize_script('jquery-ui-datepicker', 'datepicker_args', array('dateFormat' => 'yy-mm-dd'));
    //enqueue font awesome
    wp_enqueue_style('cpm_investor_font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
    global $post;
    if ($post && $post->post_type == 'cpm_investor') {
        $country_value = get_post_meta($post->ID, 'cpm_investor_country', true);
        wp_localize_script('cpm-initializer', 'cpm_investor_country', $country_value);
    }
    if (is_post_type_archive('cpm_investor')) {
        wp_enqueue_style('archive-investor-style', plugin_dir_url(__FILE__) . '../templates/archive-cpm_investor.css', array(), '1.0.0', 'all');
    }
}
add_action('admin_enqueue_scripts', 'cpm_investors_enqueue_admin_scripts');

require_once CPM_INVESTORS_ADMIN_DIR . 'cpm-investor-admin.php';
require_once CPM_INVESTORS_PUBLIC_DIR . 'cpm-investor-public.php';


// Flush rewrite rules on activation
function cpm_investors_rewrite_flush()
{
    cpm_investors_custom_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'cpm_investors_rewrite_flush');
