<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Custom Post Type
function cpm_register_investor_post_type() {
    $labels = array(
        'name'                  => _x( 'Investors', 'Post Type General Name', 'cpm_investors' ),
        'singular_name'         => _x( 'Investor', 'Post Type Singular Name', 'cpm_investors' ),
        'menu_name'             => __( 'Investors', 'cpm_investors' ),
        'name_admin_bar'        => __( 'Investor', 'cpm_investors' ),
        'archives'              => __( 'Investor Archives', 'cpm_investors' ),
        'attributes'            => __( 'Investor Attributes', 'cpm_investors' ),
        'parent_item_colon'     => __( 'Parent Investor:', 'cpm_investors' ),
        'all_items'             => __( 'All Investors', 'cpm_investors' ),
        'add_new_item'          => __( 'Add New Investor', 'cpm_investors' ),
        'add_new'               => __( 'Add New', 'cpm_investors' ),
        'new_item'              => __( 'New Investor', 'cpm_investors' ),
        'edit_item'             => __( 'Edit Investor', 'cpm_investors' ),
        'update_item'           => __( 'Update Investor', 'cpm_investors' ),
        'view_item'             => __( 'View Investor', 'cpm_investors' ),
        'view_items'            => __( 'View Investors', 'cpm_investors' ),
        'search_items'          => __( 'Search Investor', 'cpm_investors' ),
        'not_found'             => __( 'Not found', 'cpm_investors' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'cpm_investors' ),
        'featured_image'        => __( 'Featured Image', 'cpm_investors' ),
        'set_featured_image'    => __( 'Set featured image', 'cpm_investors' ),
        'remove_featured_image' => __( 'Remove featured image', 'cpm_investors' ),
        'use_featured_image'    => __( 'Use as featured image', 'cpm_investors' ),
        'insert_into_item'      => __( 'Insert into investor', 'cpm_investors' ),
        'uploaded_to_this_item' => __( 'Uploaded to this investor', 'cpm_investors' ),
        'items_list'            => __( 'Investors list', 'cpm_investors' ),
        'items_list_navigation' => __( 'Investors list navigation', 'cpm_investors' ),
        'filter_items_list'     => __( 'Filter investors list', 'cpm_investors' ),
    );
    $args = array(
        'label'                 => __( 'Investor', 'cpm_investors' ),
        'description'           => __( 'Post Type Description', 'cpm_investors' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'cpm_investor', $args );
}
add_action( 'init', 'cpm_register_investor_post_type', 0 );

// Enqueue Admin Scripts and Styles
function cpm_enqueue_admin_scripts() {
    wp_enqueue_script('cpm-admin-js', plugin_dir_url(__FILE__) . 'cpm-initializer-admin.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);
    wp_enqueue_style('cpm-admin-css', plugin_dir_url(__FILE__) . 'cpm-styles-admin.css');
    wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
}
add_action('admin_enqueue_scripts', 'cpm_enqueue_admin_scripts');