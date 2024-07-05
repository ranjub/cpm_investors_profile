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
        echo '<div class="cpm-form-success">Your form submission was successful!</div>';
    }

?>



    <!-- frontend form -->

    <div class="cpm-form-container">

        <!-- Form title -->

        <h2 class="form-title">Investor Submission Form</h2>

        <form action="" method="post" id="cpm_investor_form" enctype="multipart/form-data">

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
            <label for="investment_type">Type of Investment</label>
            <select id="investment_type" name="investment_type[]" multiple="multiple">
                <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                    <?php foreach ($terms as $term) : ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <!-- New field for Capital (USD) -->
            <label for="capital_usd">Capital (USD):</label>
            <div class="usd_capital_public">
                <i class="fa-solid fa-dollar-sign"></i> <input type="number" id="capital_usd" name="capital_usd" min="0" required><br />
            </div>
            <span id="capital_usd_error" style="color: red; display: none;">Please enter a valid
                number.</span><br />
            <input type="submit" name="submit_investor" value="Submit">

        </form>

    </div>

<?php

    return ob_get_clean();
}

add_shortcode('cpm_investor_form', 'cpm_investor_submission_form');



// Handle form submission
function cpm_investor_handle_form_submission()
{
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


            // Redirect to the form with a success message
            wp_redirect(add_query_arg('submission', 'success', wp_get_referer()));
            exit;
        }
    }
}
add_action('init', 'cpm_investor_handle_form_submission');
