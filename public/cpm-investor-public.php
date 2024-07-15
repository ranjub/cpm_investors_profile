<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to display the form
function cpm_investor_submission_form()
{
    ob_start();

    $terms = get_terms(array(
        'taxonomy' => 'investment_type',
        'hide_empty' => false,
    ));

    // Check if form was submitted successfully
    if (isset($_GET['submission']) && $_GET['submission'] == 'success') {
        echo '<div class="cpm-form-success">' . __('Your form submission was successful!', 'cpm_investor') . '</div>';
    }

?>

<!-- frontend form -->
<div class="cpm-form-container">

    <!-- Form title -->
    <h2 class="form-title"><?php _e('Investor Submission Form', 'cpm_investor'); ?></h2>

    <form action="" method="post" id="cpm_investor_form" enctype="multipart/form-data">
        <input type="hidden" name="form_type" value="investor_form">
        <label for="investor_name"><?php _e('Name of Investor:', 'cpm_investor'); ?></label>
        <input type="text" id="investor_name" name="investor_name" required>

        <label for="investor_description"><?php _e('Short Description:', 'cpm_investor'); ?></label>
        <textarea id="investor_description" name="investor_description" rows="4" cols="50"></textarea>

        <label for="investor_founded"><?php _e('Founded in:', 'cpm_investor'); ?></label>
        <input type="text" id="investor_founded" name="investor_founded" required>

        <label for="investor_type"><?php _e('Investor Type:', 'cpm_investor'); ?></label>
        <select id="investor_type" name="investor_type[]" multiple="multiple" class="cpm-select2" required>
            <option value="VC"><?php _e('VC', 'cpm_investor'); ?></option>
            <option value="Accelerator"><?php _e('Accelerator', 'cpm_investor'); ?></option>
        </select>

        <label for="investor_logo"><?php _e('Logo:', 'cpm_investor'); ?></label>
        <input type="file" id="investor_logo" name="investor_logo" accept="image/*" required>

        <label for="investing_status"><?php _e('Investing Status:', 'cpm_investor'); ?></label>
        <select id="investing_status" name="investing_status" required>
            <option value="Actively Investing"><?php _e('Actively Investing', 'cpm_investor'); ?></option>
            <option value="Relaxed Investing"><?php _e('Relaxed Investing', 'cpm_investor'); ?></option>
        </select>

        <label for="investor_country"><?php _e('Country:', 'cpm_investor'); ?></label>
        <select id="investor_country" name="investor_country" class="cpm-select2" required></select>

        <label for="investment_type"><?php _e('Type of Investment', 'cpm_investor'); ?></label>
        <select id="investment_type" name="investment_type[]" multiple="multiple">
            <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
            <?php foreach ($terms as $term) : ?>
            <option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <!-- New field for Capital (USD) -->
        <label for="capital_usd"><?php _e('Capital (USD):', 'cpm_investor'); ?></label>
        <div class="usd_capital_public">
            <i class="fa-solid fa-dollar-sign"></i> <input type="number" id="capital_usd" name="capital_usd" min="0"
                required><br />
        </div>
        <span id="capital_usd_error"
            style="color: red; display: none;"><?php _e('Please enter a valid number.', 'cpm_investor'); ?></span><br />
        <input type="submit" name="submit_investor" value="<?php _e('Submit', 'cpm_investor'); ?>">

    </form>

</div>

<?php

    return ob_get_clean();
}

add_shortcode('cpm_investor_form', 'cpm_investor_submission_form');

//new form with radio button and buy button
function cpm_display_radio_buttons_form($post_id)
{
    ob_start(); ?>
<form action="" method="post" id="cpm_radio_buttons_form">
    <input type="hidden" name="form_type" value="radio_buttons_form">
    <input type="hidden" name="investor_post_id" value="<?php echo $post_id; ?>">
    <label for="radio_option"><?php _e('Choose a Price:', 'cpm_investor'); ?></label>
    <div class="radio-option">
        <input type="radio" id="option1" name="radio_option" value="$ 500">
        <label for="option1"><?php _e('$500', 'cpm_investor'); ?></label>
    </div>
    <div class="radio-option">
        <input type="radio" id="option2" name="radio_option" value="$ 100">
        <label for="option2"><?php _e('$100', 'cpm_investor'); ?></label>
    </div>
    <div class="radio-option">
        <input type="radio" id="option3" name="radio_option" value="$ 200">
        <label for="option3"><?php _e('$200', 'cpm_investor'); ?></label>
    </div>
    <input type="submit" name="submit_radio" value="<?php _e('Buy', 'cpm_investor'); ?>">
</form>
<?php
    return ob_get_clean();
}





// Handle form submission
function cpm_investor_handle_form_submission()
{
    if (isset($_POST['form_type'])) {
        if ($_POST['form_type'] == 'investor_form') {
            if (isset($_POST['submit_investor']) && isset($_POST['investor_name']) && isset($_POST['investor_description']) && isset($_POST['investor_founded'])) {
                $investor_name = sanitize_text_field($_POST['investor_name']);
                $investor_description = sanitize_textarea_field($_POST['investor_description']);
                $investor_founded = sanitize_text_field($_POST['investor_founded']);
                $investor_type = array_map('sanitize_text_field', $_POST['investor_type']);
                $investing_status = sanitize_text_field($_POST['investing_status']);
                $investor_country = sanitize_text_field($_POST['investor_country']);
                $investment_types = array_map('sanitize_text_field', $_POST['investment_type']);
                $capital_usd = sanitize_text_field($_POST['capital_usd']);

                // Create a new post of type 'cpm_investor'
                $new_post = array(
                    'post_title'   => $investor_name,
                    'post_content' => $investor_description,
                    'post_status'  => 'draft',
                    'post_type'    => 'cpm_investor'
                );

                // Insert the post into the database
                $post_id = wp_insert_post($new_post);

                // Save the 'founded in' year as post meta
                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'cpm_investor_founded', $investor_founded);
                    update_post_meta($post_id, 'cpm_investor_type', $investor_type);
                    update_post_meta($post_id, 'cpm_investor_country', $investor_country);
                    update_post_meta($post_id, 'cpm_investing_status', $investing_status);
                    update_post_meta($post_id, 'cpm_capital_usd', $capital_usd);

                    // Handle the logo upload and set it as the featured image
                    if (!empty($_FILES['investor_logo']['name'])) {
                        // Ensure the function is available
                        if (!function_exists('wp_handle_upload')) {
                            require_once(ABSPATH . 'wp-admin/includes/file.php');
                        }

                        $file = $_FILES['investor_logo'];
                        $upload = wp_handle_upload($file, array('test_form' => false));
                        if ($upload && !isset($upload['error'])) {
                            $attachment = array(
                                'post_mime_type' => $upload['type'],
                                'post_title'     => sanitize_file_name($upload['file']),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            );
                            $attachment_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
                            require_once(ABSPATH . 'wp-admin/includes/image.php');
                            $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
                            wp_update_attachment_metadata($attachment_id, $attach_data);
                            set_post_thumbnail($post_id, $attachment_id);
                        }
                    }

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
                    // Display the radio buttons form
                    echo cpm_display_radio_buttons_form($post_id);
                    return; // Stop further execution to show the new form
                }
            }
        } elseif ($_POST['form_type'] == 'radio_buttons_form') {
            if (isset($_POST['submit_radio']) && isset($_POST['radio_option']) && isset($_POST['investor_post_id'])) {
                $radio_option = sanitize_text_field($_POST['radio_option']);
                $post_id = intval($_POST['investor_post_id']);

                // Save the radio option as post meta
                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'cpm_investor_radio_option', $radio_option);

                    // Redirect to the form with a success message
                    wp_redirect(add_query_arg('submission', 'success', wp_get_referer()));
                    exit;
                }
            }
        }
    }
}
add_action('init', 'cpm_investor_handle_form_submission');