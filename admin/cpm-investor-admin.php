<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Enqueue Admin Scripts and Styles
function cpm_enqueue_admin_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('cpm-admin-js', plugin_dir_url(__FILE__) . 'admin/cpm-initializer-admin.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);
    wp_enqueue_style('cpm-admin-css', plugin_dir_url(__FILE__) . 'cpm-styles-admin.css');
    wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-datepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');
    wp_localize_script('jquery-ui-datepicker', 'datepicker_args', array('dateFormat' => 'yy-mm-dd'));

    global $post;
    if ($post && $post->post_type == 'cpm_investor') {
        $country_value = get_post_meta($post->ID, 'cpm_investor_country', true);
        wp_localize_script('cpm-initializer', 'cpm_investor_country', $country_value);
    }
    if (is_post_type_archive('cpm_investor')) {
        wp_enqueue_style('archive-investor-style', plugin_dir_url(__FILE__) . '../templates/archive-cpm_investor.css', array(), '1.0.0', 'all');
    }
}
add_action('admin_enqueue_scripts', 'cpm_enqueue_admin_scripts');


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
add_action('add_meta_boxes', 'cpm_investor_add_meta_box');

// Save the data as post meta admin side
function cpm_investor_meta_box_callback( $post ) {
    wp_nonce_field('cpm_investor_nonce_action', 'cpm_investor_nonce');

    $founded_value = get_post_meta($post->ID, 'cpm_investor_founded', true);
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
        <!-- Options will be populated by JS -->
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
<script type="text/javascript">
var cpm_investor_country = "<?php echo esc_js($country_value); ?>";
</script>
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
function cpm_investor_save_meta_box_data($post_id) {
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

    if (array_key_exists('cpm_investor_founded', $_POST)) {
        update_post_meta($post_id, 'cpm_investor_founded', sanitize_text_field($_POST['cpm_investor_founded']));
    }

    if (array_key_exists('cpm_investor_type', $_POST)) {
        $investor_type = array_map('sanitize_text_field', $_POST['cpm_investor_type']);
        update_post_meta($post_id, 'cpm_investor_type', $investor_type);
    }

    if (array_key_exists('cpm_investing_status', $_POST)) {
        update_post_meta($post_id, 'cpm_investing_status', sanitize_text_field($_POST['cpm_investing_status']));
    }

    if (array_key_exists('cpm_investor_country', $_POST)) {
        update_post_meta($post_id, 'cpm_investor_country', sanitize_text_field($_POST['cpm_investor_country']));
    }

    if (array_key_exists('cpm_investor_publish_date', $_POST)) {
        update_post_meta($post_id, 'cpm_investor_publish_date', sanitize_text_field($_POST['cpm_investor_publish_date']));
    }

    if (isset($_POST['cpm_investor_valid_for'])) {
        update_post_meta($post_id, 'cpm_investor_valid_for', sanitize_text_field($_POST['cpm_investor_valid_for']));
    }
}
add_action('save_post', 'cpm_investor_save_meta_box_data');

// Remove Custom Fields meta box for custom post type 'cpm_investor'
function cpm_investor_remove_custom_fields_meta_box() {
    remove_meta_box('postcustom', 'cpm_investor', 'normal');
}
add_action('do_meta_boxes', 'cpm_investor_remove_custom_fields_meta_box');