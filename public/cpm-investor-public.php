<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Enqueue Public Scripts and Styles
function cpm_enqueue_public_scripts() {
    wp_enqueue_script('cpm-public-js', plugin_dir_url(__FILE__) . 'cpm-initializer-public.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);
    wp_enqueue_style('cpm-public-css', plugin_dir_url(__FILE__) . 'cpm-styles-public.css');
    wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
}
add_action('wp_enqueue_scripts', 'cpm_enqueue_public_scripts');