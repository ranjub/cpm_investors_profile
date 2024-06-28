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
// Enqueue Select2 for both front-end and admin
function cpm_investor_enqueue_scripts() {
    wp_enqueue_script('jquery');
    // Enqueue jQuery UI CSS
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    // Enqueue jQuery UI JS
    wp_enqueue_script('jquery-ui-js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), null, true);
    // Enqueue Select2 CSS
    wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
    
    // Enqueue Select2 JS
    wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), null, true);
    
    // Enqueue custom script for initializing Select2
    wp_enqueue_script('cpm-initializer', plugin_dir_url(__FILE__) . 'cpm-initializer.js', array('jquery', 'select2'), null, true);
    wp_enqueue_style('cpm-styles', plugin_dir_url(__FILE__) . 'cpm-styles.css');

    // Enqueue jQuery UI Datepicker
    wp_enqueue_script('jquery-ui-datepicker');

    // Enqueue Datepicker style
    wp_enqueue_style('jquery-ui-datepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');

    // Localize datepicker script
    wp_localize_script('jquery-ui-datepicker', 'datepicker_args', array(
        'dateFormat' => 'yy-mm-dd', // Adjust date format as needed
    ));

    
    if (is_admin()) {
        global $post;
        if ($post && $post->post_type == 'cpm_investor') {
            $country_value = get_post_meta($post->ID, 'cpm_investor_country', true);
            wp_localize_script('cpm-initializer', 'cpm_investor_country', $country_value);
        }
    }
    if (is_post_type_archive('cpm_investor')) {
        wp_enqueue_style('archive-investor-style', plugin_dir_url(__FILE__) . 'archive-cpm_investor.css', array(), '1.0.0', 'all');
        
    }

}
add_action('wp_enqueue_scripts', 'cpm_investor_enqueue_scripts');
add_action('admin_enqueue_scripts', 'cpm_investor_enqueue_scripts');



// Function to register the custom post type
function cpm_investor_register_post_type() {

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
        'description'           => __( 'Post Type for Investors', 'cpm_investors' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
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

// Hook into the 'init' action
add_action( 'init', 'cpm_investor_register_post_type', 0 );

// Register the Investment Type taxonomy
function cpm_investor_register_taxonomy() {
    $labels = array(
        'name'              => _x('Investment Types', 'taxonomy general name', 'cpm_investor'),
        'singular_name'     => _x('Investment Type', 'taxonomy singular name', 'cpm_investor'),
        'search_items'      => __('Search Investment Types', 'cpm_investor'),
        'all_items'         => __('All Investment Types', 'cpm_investor'),
        'parent_item'       => __('Parent Investment Type', 'cpm_investor'),
        'parent_item_colon' => __('Parent Investment Type:', 'cpm_investor'),
        'edit_item'         => __('Edit Investment Type', 'cpm_investor'),
        'update_item'       => __('Update Investment Type', 'cpm_investor'),
        'add_new_item'      => __('Add New Investment Type', 'cpm_investor'),
        'new_item_name'     => __('New Investment Type Name', 'cpm_investor'),
        'menu_name'         => __('Investment Type', 'cpm_investor'),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'         => true,
        'rewrite'           => array('slug' => 'investment-type'),
    );

    register_taxonomy('investment_type', 'cpm_investor', $args);
}
add_action('init', 'cpm_investor_register_taxonomy');

// Ensure taxonomy is displayed as tags
function cpm_investor_add_taxonomy_to_post_type() {
    register_taxonomy_for_object_type('investment_type', 'cpm_investor');
}
add_action('init', 'cpm_investor_add_taxonomy_to_post_type');

// Shortcode to display the form
function cpm_investor_submission_form() {
    ob_start();

    $terms = get_terms(array(
        'taxonomy' => 'investment_type',
        'hide_empty' => false,
    ));
    ?>

<!-- frontend form -->
<div class="cpm-form-container">
    <!-- Form title -->
    <h2 class="form-title">Investor Submission Form</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="investor_name">Name of Investor:</label>
        <input type="text" id="investor_name" name="investor_name" required>

        <label for="investor_description">Short Description:</label>
        <textarea id="investor_description" name="investor_description" rows="4" cols="50"></textarea>

        <label for="investor_founded">Founded in:</label>
        <input type="text" id="investor_founded" name="investor_founded" required>


        <label for="investor_type">Investor Type:</label>
        <select id="investor_type" name="investor_type[]" multiple="multiple" class="cpm-select2" required>
            <option value="VC">VC</option>
            <option value="Accelerator">Accelerator</option>
        </select>

        <label for="investor_logo">Logo:</label>
        <input type="file" id="investor_logo" name="investor_logo" accept="image/*" required>

        <label for="investing_status">Investing Status:</label>
        <select id="investing_status" name="investing_status" required>
            <option value="Actively Investing">Actively Investing</option>
            <option value="Relaxed Investing">Relaxed Investing</option>
        </select>

        <label for="investor_country">Country:</label>
        <select id="investor_country" name="investor_country" class="cpm-select2" required></select>

        <label for="investment_type">Type of Investment:</label>
        <select id="investment_type" name="investment_type[]" multiple="multiple">
            <?php foreach ($terms as $term) : ?>
            <option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" name="submit_investor" value="Submit">
    </form>
</div>
<?php
    return ob_get_clean();
}
add_shortcode('cpm_investor_form', 'cpm_investor_submission_form');

// Handle form submission
function cpm_investor_handle_form_submission() {
    if ( isset( $_POST['submit_investor'] ) && isset( $_POST['investor_name'] ) && isset( $_POST['investor_description'] ) && isset( $_POST['investor_founded'] ) ) {
        $investor_name = sanitize_text_field( $_POST['investor_name'] );
        $investor_description = sanitize_textarea_field( $_POST['investor_description'] );
        $investor_founded = sanitize_text_field( $_POST['investor_founded'] );
        $investor_type = array_map( 'sanitize_text_field', $_POST['investor_type'] );
        $investing_status = sanitize_text_field( $_POST['investing_status'] );
        $investor_country = sanitize_text_field( $_POST['investor_country'] );
        $investment_types = array_map('sanitize_text_field', $_POST['investment_type']);
        
        // Create a new post of type 'cpm_investor'
        $new_post = array(
            'post_title'   => $investor_name,
            'post_content' => $investor_description,
            'post_status'  => 'draft',
            'post_type'    => 'cpm_investor'
        );

        // Insert the post into the database
        $post_id = wp_insert_post( $new_post );

        // Save the 'founded in' year as post meta
        if ( ! is_wp_error( $post_id ) ) {
            update_post_meta( $post_id, 'cpm_investor_founded', $investor_founded );
            update_post_meta( $post_id, 'cpm_investor_type', $investor_type );
            update_post_meta( $post_id, 'cpm_investor_country', $investor_country );
            update_post_meta( $post_id, 'cpm_investing_status', $investing_status );

            // // Handle the investment type taxonomy terms
            // if ( isset( $_POST['investment_type'] ) ) {
            //     $investment_types = array_map( 'intval', $_POST['investment_type'] );
            //     wp_set_object_terms( $post_id, $investment_types, 'investment_type' );
            // }

           // Set taxonomy terms
        $term_ids = array();
        foreach ($investment_types as $investment_type) {
            if (is_numeric($investment_type)) {
                $term_ids[] = intval($investment_type);
            } else {
                $new_term = wp_insert_term($investment_type, 'investment_type');
                if (!is_wp_error($new_term)) {
                    $term_ids[] = $new_term['term_id'];
                }
        }
    }
    
    wp_set_post_terms($post_id, $term_ids, 'investment_type');
       
    

        // Handle the logo upload and set it as the featured image
        if ( ! empty( $_FILES['investor_logo']['name'] ) ) {
            $file = $_FILES['investor_logo'];
            $upload = wp_handle_upload( $file, array( 'test_form' => false ) );

            if ( ! isset( $upload['error'] ) && isset( $upload['file'] ) ) {
                $filetype = wp_check_filetype( basename( $upload['file'] ), null );
                $wp_upload_dir = wp_upload_dir();

                $attachment = array(
                    'guid'           => $wp_upload_dir['url'] . '/' . basename( $upload['file'] ),
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload['file'] ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );

                $attach_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                $attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
                wp_update_attachment_metadata( $attach_id, $attach_data );
                set_post_thumbnail( $post_id, $attach_id );
            }
        }
    }
}
// echo "Investor registered successsfully";
}
    
add_action( 'init', 'cpm_investor_handle_form_submission' );

// Display the 'founded in' year in the post edit screen
function cpm_investor_add_meta_box() {
    add_meta_box(
       'cpm_investor_meta_box',
        'Investor Details',
        'cpm_investor_meta_box_callback',
        'cpm_investor',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'cpm_investor_add_meta_box' );


 // Save the data as post meta admin side 

function cpm_investor_meta_box_callback( $post ) {
    wp_nonce_field('cpm_investor_nonce_action', 'cpm_investor_nonce');

    $founded_value = get_post_meta( $post->ID, 'cpm_investor_founded', true );
    $type_value = get_post_meta($post->ID, 'cpm_investor_type', true);
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $investing_status_value = get_post_meta($post->ID, 'cpm_investing_status', true);
    $country_value = get_post_meta($post->ID, 'cpm_investor_country', true);
    $publish_date = get_post_meta($post->ID, 'cpm_investor_publish_date', true);
    $valid_for = get_post_meta($post->ID, 'cpm_investor_valid_for', true);
    if (!is_array($type_value)) {
        $type_value = array();
    }
    
    wp_nonce_field('cpm_investor_save_meta_box_data', 'cpm_investor_meta_box_nonce');

    ?>
<div class="cpm-meta-box-container">
    <label for="cpm_investor_founded">Founded in:</label>
    <input type="text" id="cpm_investor_founded" name="cpm_investor_founded"
        value="<?php echo esc_attr($founded_value); ?>">


    <label for="cpm_investor_type">Investor Type:</label>
    <select id="cpm_investor_type" name="cpm_investor_type[]" multiple="multiple" class="cpm-select2">
        <option value="VC" <?php echo in_array('VC', $type_value) ? 'selected' : ''; ?>>VC</option>
        <option value="Accelerator" <?php echo in_array('Accelerator', $type_value) ? 'selected' : ''; ?>>Accelerator
        </option>
    </select>

    <label for="cpm_investor_logo">Logo:</label>
    <?php if ($thumbnail_id): ?>
    <img src="<?php echo wp_get_attachment_url($thumbnail_id); ?>" alt="Logo"
        style="max-width: 100px; max-height: 100px;">
    <?php endif; ?>

    <label for="cpm_investing_status">Investing Status:</label>
    <select id="cpm_investing_status" name="cpm_investing_status">
        <option value="Actively Investing" <?php selected($investing_status_value, 'Actively Investing'); ?>>Actively
            Investing</option>
        <option value="Relaxed Investing" <?php selected($investing_status_value, 'Relaxed Investing'); ?>>Relaxed
            Investing</option>
    </select>

    <label for="cpm_investor_country">Country:</label>
    <select id="cpm_investor_country" name="cpm_investor_country" class="cpm-select2">
        <!-- Options will be populated by JavaScript -->
    </select>

    <p>
        <label for="cpm_investor_publish_date">Publish Date:</label>
        <input type="date" id="cpm_investor_publish_date" name="cpm_investor_publish_date"
            value="<?php echo esc_attr($publish_date); ?>">
    </p>
    <p>
        <label for="cpm_investor_valid_for">Valid for (days):</label>
        <input type="number" id="cpm_investor_valid_for" name="cpm_investor_valid_for"
            value="<?php echo esc_attr($valid_for); ?>">
    </p>

</div>
<?php
}
// Fetch terms for the form
function cpm_get_investment_terms() {
    $terms = get_terms(array(
        'taxonomy' => 'investment_type',
        'hide_empty' => false,
    ));
    return $terms;
}

// Save the 'founded in' year from the post edit screen
function cpm_investor_save_meta_box_data( $post_id ) {

    if (!isset($_POST['cpm_investor_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['cpm_investor_meta_box_nonce'], 'cpm_investor_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'cpm_investor' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

if ( array_key_exists( 'cpm_investor_founded', $_POST ) ) {
update_post_meta(
$post_id,
'cpm_investor_founded',
sanitize_text_field( $_POST['cpm_investor_founded'] )
);
}

if (array_key_exists('cpm_investor_type', $_POST)) {
$investor_type = array_map('sanitize_text_field', $_POST['cpm_investor_type']);
update_post_meta(
$post_id,
'cpm_investor_type',
$investor_type
);
}
if (array_key_exists('cpm_investing_status', $_POST)) {
    update_post_meta(
        $post_id,
        'cpm_investing_status',
        sanitize_text_field($_POST['cpm_investing_status'])
    );
}

if (array_key_exists('cpm_investor_country', $_POST)) {
    update_post_meta(
        $post_id,
        'cpm_investor_country',
        sanitize_text_field($_POST['cpm_investor_country'])
    );
}
// Update 'Publish Date'
if (array_key_exists('cpm_investor_publish_date', $_POST)) {
    update_post_meta(
        $post_id,
        'cpm_investor_publish_date',
        sanitize_text_field($_POST['cpm_investor_publish_date'])
    );
}

if (isset($_POST['cpm_investor_publish_date'])) {
    update_post_meta($post_id, 'cpm_investor_publish_date', sanitize_text_field($_POST['cpm_investor_publish_date']));
}
if (isset($_POST['cpm_investor_valid_for'])) {
    update_post_meta($post_id, 'cpm_investor_valid_for', sanitize_text_field($_POST['cpm_investor_valid_for']));
}

    $terms = cpm_get_investment_terms();
    $selected_terms = wp_get_post_terms($post_id, 'investment_type', array('fields' => 'ids'));
   
}

add_action('save_post', 'cpm_investor_save_meta_box_data');


// Remove Custom Fields meta box for custom post type 'cpm_investor'
function cpm_investor_remove_custom_fields_meta_box() {
remove_meta_box( 'postcustom', 'cpm_investor', 'normal' );
}
add_action( 'do_meta_boxes', 'cpm_investor_remove_custom_fields_meta_box' );

//to load the single page
function load_investor_template($template) {
    if (is_singular('cpm_investor')) {
        $plugin_path = plugin_dir_path(__FILE__);
        $template_name = 'single-cpm_investor.php';
        $template = $plugin_path . $template_name;
    }
    return $template;
}
add_filter('template_include', 'load_investor_template');
//enqueue styles for single page
function cpm_investor_enqueue_styles() {
    if (is_singular('cpm_investor')) {
        wp_enqueue_style('single-investor-style', plugin_dir_url(__FILE__) . 'single-cpm_investor.css', array(), '1.0.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'cpm_investor_enqueue_styles');


//to register the sidebar in widgets for single page

function cpm_investor_register_sidebar() {
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
add_action('widgets_init', 'cpm_investor_register_sidebar');

// to add archieve page 
function cpm_investors_template( $template ) {
    if ( is_post_type_archive( 'cpm_investor' ) ) {
        $archive_template = plugin_dir_path( __FILE__ );
        if ( file_exists( $archive_template ) ) {
            return $archive_template;
        }
    }
    return $template;
}
add_filter( 'archive_template', 'cpm_investors_template' );