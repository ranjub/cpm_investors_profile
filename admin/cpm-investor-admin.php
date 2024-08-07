<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register the Investment Type taxonomy
function cpm_investor_register_taxonomy()
{
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
function cpm_investor_add_taxonomy_to_post_type()
{
    register_taxonomy_for_object_type('investment_type', 'cpm_investor');
}
add_action('init', 'cpm_investor_add_taxonomy_to_post_type');

// Display the 'founded in' year in the post edit screen
function cpm_investor_add_meta_box()
{
    add_meta_box(
        'cpm_investor_meta_box',
        __('Investor Details', 'cpm_investor'),
        'cpm_investor_meta_box_callback',
        'cpm_investor',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'cpm_investor_add_meta_box');

// Save the data as post meta admin side
function cpm_investor_meta_box_callback($post)
{
    wp_nonce_field('cpm_investor_nonce_action', 'cpm_investor_nonce');

    $founded_value = get_post_meta($post->ID, 'cpm_investor_founded', true);
    $type_value = get_post_meta($post->ID, 'cpm_investor_type', true);
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $investing_status_value = get_post_meta($post->ID, 'cpm_investing_status', true);
    $country_value = get_post_meta($post->ID, 'cpm_investor_country', true);
    $publish_date = get_post_meta($post->ID, 'cpm_investor_publish_date', true);
    $valid_for = get_post_meta($post->ID, 'cpm_investor_valid_for', true);
    $capital_usd = get_post_meta($post->ID, 'cpm_capital_usd', true);
    //radio button
    $radio_option = get_post_meta($post->ID, 'cpm_investor_radio_option', true);
    if (!is_array($type_value)) {
        $type_value = array();
    }

    wp_nonce_field('cpm_investor_save_meta_box_data', 'cpm_investor_meta_box_nonce');
?>
<div class="cpm-meta-box-container">
    <label for="cpm_investor_founded"><?php _e('Founded in:', 'cpm_investor'); ?></label>
    <input type="text" id="cpm_investor_founded" name="cpm_investor_founded"
        value="<?php echo esc_attr($founded_value); ?>">

    <label for="cpm_investor_type"><?php _e('Investor Type:', 'cpm_investor'); ?></label>
    <select id="cpm_investor_type" name="cpm_investor_type[]" multiple="multiple" class="cpm-select2">
        <option value="VC" <?php echo in_array('VC', $type_value) ? 'selected' : ''; ?>>
            <?php _e('VC', 'cpm_investor'); ?></option>
        <option value="Accelerator" <?php echo in_array('Accelerator', $type_value) ? 'selected' : ''; ?>>
            <?php _e('Accelerator', 'cpm_investor'); ?></option>
    </select>

    <label for="cpm_investor_logo"><?php _e('Logo:', 'cpm_investor'); ?></label>
    <?php if ($thumbnail_id) : ?>
    <img src="<?php echo wp_get_attachment_url($thumbnail_id); ?>" alt="Logo"
        style="max-width: 100px; max-height: 100px;">
    <?php endif; ?>

    <label for="cpm_investing_status"><?php _e('Investing Status:', 'cpm_investor'); ?></label>
    <select id="cpm_investing_status" name="cpm_investing_status">
        <option value="Actively Investing" <?php selected($investing_status_value, 'Actively Investing'); ?>>
            <?php _e('Actively Investing', 'cpm_investor'); ?></option>
        <option value="Relaxed Investing" <?php selected($investing_status_value, 'Relaxed Investing'); ?>>
            <?php _e('Relaxed Investing', 'cpm_investor'); ?></option>
    </select>

    <label for="cpm_investor_country"><?php _e('Country:', 'cpm_investor'); ?></label>
    <select id="cpm_investor_country" name="cpm_investor_country" class="cpm-select2">
        <!-- Options will be populated by JS -->
    </select>

    <!-- New field for Capital (USD) -->
    <p>
        <label for="cpm_capital_usd"><?php _e('Capital (USD):', 'cpm_investor'); ?></label>
    <div class="usd_capital">
        <i class="fa-solid fa-dollar-sign"></i>
        <input type="number" id="cpm_capital_usd" name="cpm_capital_usd" min="0"
            value="<?php echo esc_attr($capital_usd); ?>" required>
    </div>
    <div id="capital_usd_error" style="color: red; display: none;">
        <?php _e('Please enter a valid number for Capital (USD).', 'cpm_investor'); ?></div>
    </p>
    <p>
        <label for="cpm_investor_publish_date"><?php _e('Publish Date:', 'cpm_investor'); ?></label>
        <input type="date" id="cpm_investor_publish_date" name="cpm_investor_publish_date"
            value="<?php echo esc_attr($publish_date); ?>">
    </p>
    <p>
        <label for="cpm_investor_valid_for"><?php _e('Valid for (days):', 'cpm_investor'); ?></label>
        <input type="number" id="cpm_investor_valid_for" name="cpm_investor_valid_for"
            value="<?php echo esc_attr($valid_for); ?>">
    </p>
    <!-- radio button -->
    <p>
        <strong><?php _e('Price Choosen:', 'cpm_investor'); ?></strong>
        <?php echo esc_html($radio_option); ?>
    </p>
</div>
<script type="text/javascript">
var cpm_investor_country = "<?php echo esc_js($country_value); ?>";
</script>


<?php
}

// Fetch terms for the form
function cpm_get_investment_terms()
{
    $terms = get_terms(array(
        'taxonomy' => 'investment_type',
        'hide_empty' => false,
    ));
    return $terms;
}

// Save the 'founded in' year from the post edit screen
function cpm_investor_save_meta_box_data($post_id)
{
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
    if (array_key_exists('cpm_capital_usd', $_POST)) {
        update_post_meta($post_id, 'cpm_capital_usd', sanitize_text_field($_POST['cpm_capital_usd']));
    }
}
add_action('save_post', 'cpm_investor_save_meta_box_data');

// Remove Custom Fields meta box for custom post type 'cpm_investor'
function cpm_investor_remove_custom_fields_meta_box()
{
    remove_meta_box('postcustom', 'cpm_investor', 'normal');
}
add_action('do_meta_boxes', 'cpm_investor_remove_custom_fields_meta_box');