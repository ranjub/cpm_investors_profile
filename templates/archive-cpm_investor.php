<?php
/* Template Name: Investor Archive */
get_header(); 
global $wpdb;
$investor_country_values = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'cpm_investor_country'");
$investortypes = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'investor_type'");
$investing_status = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'cpm_investing_status'");
//var_dump($investor_country_values);
?>

<div class="investors-archive">
    <h1>Investors</h1>
    <!-- Filter for search area -->
    <h3>Search By</h3>
    <div class="filter-search">
        <form id="searchform" method="get">
            <input type="text" id="searchFilter" name="searcharea" placeholder="Free text search"
                value="<?php echo get_search_query(); ?>" />
               

            <!-- <input type="text" id="searchFilter" name="country" placeholder="Investor Country"
                value="<?php //echo esc_attr($_GET['country'] ?? ''); ?>" /> -->


<?php
//investor country dropdown

echo '<select class="investor-dropdown" id="searchFilter" name="country" placeholder="Investor Country">';
foreach ($investor_country_values as $key => $unique_value) {
echo '<option value="'.$unique_value.'">'.$unique_value.'</option>';

}
// investor country dropdown
echo '<select class="investor-dropdown" id="searchFilter" name="investor_type" placeholder="investor-type">';
foreach ($investortypes as $key => $investortypes) {
echo '<option value="'.$investortypes.'">'.$investortypes.'</option>';

}

//investor-status

echo '<select class="investor-dropdown" id="searchFilter" name="searchstatus" placeholder="Investing Status">';
foreach ($investing_status as $key => $investing_status) {
echo '<option value="'.$investing_status.'">'.$investing_status.'</option>';

}
echo '</select>';
?>





                <!-- <div id="suggestions-list"></div> -->

            <!-- <input type="text" id="searchFilter" name="investment-type" placeholder="Investor Type"
                value="
                <?php 
                // echo esc_attr($_GET['investor_type'] ?? ''); ?>" /> -->
                <!-- <div id="suggestions-list1"></div> -->

            <!-- <input type="text" id="searchFilter" name="searchstatus" placeholder="Investing Status" -->
                <!-- value="<?php 
                // echo esc_attr($_GET['searchstatus'] ?? ''); ?>" /> -->
                <!-- <div id="suggestions-list2"></div> -->

            <button type="submit">Filter</button>
        </form>
    </div>

    <!--  to show suggestion in the search bar -->
         <?php
           

            // Replace 'your_meta_key' with your actual meta key
 
//                $dropdown = '<select id="meta-dropdown" name="meta_dropdown">';

//                   foreach ($unique_values as $value) {
//                     $dropdown .= "<option value='{$value}'>{$value}</option>";
//             }

// $dropdown .= '</select>';
         ?>
    <!-- Display investors with logo and valid days on -->
    <div class="investors-grid">
        <?php
          $investor_id = get_the_ID();
          $option = get_post_meta($investor_id, 'cpm_investor_country', true); 
          //var_dump($option);
        // Modify the query to include search parameters
        $meta_query = array('relation' => 'AND');

        if (!empty($_GET['country'])) {
            $meta_query[] = array(
                'key'     => 'cpm_investor_country',
                'value'   => sanitize_text_field($_GET['country']),
                'compare' => 'LIKE',
                'term' => $option,
            );
        }

        if (!empty($_GET['investor-type'])) {
            $meta_query[] = array(
                'key'     => 'investor_type',
                'value'   => sanitize_text_field($_GET['investor_type']),
                'compare' => 'LIKE',
            );
        }

        if (!empty($_GET['searchstatus'])) {
            $meta_query[] = array(
                'key'     => 'cpm_investing_status',
                'value'   => sanitize_text_field($_GET['searchstatus']),
                'compare' => 'LIKE',
            );
        }

        $args = array(
            'post_type'  => 'cpm_investor',
            'meta_query' => $meta_query,
            's' => isset($_GET['searcharea']) ? sanitize_text_field($_GET['searcharea']) : '',
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            $investor_id = get_the_ID();
            $valid_days = get_post_meta($investor_id, 'cpm_investor_valid_for', true);  // Get the data from the DB
            $investing_status = get_post_meta($investor_id, 'cpm_investing_status', true); // Get the investing status
            if ($valid_days >= 0):
        ?>
        <div class="investor-item">
            <a href="<?php the_permalink(); ?>">
                <div class="investor-container">
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="investor-logo">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                    <?php endif; ?>
                    <h2 class="investor-title">
                        <?php the_title(); 
                        if ($investing_status == "Actively Investing") {?>
                        <i class="fa-solid fa-circle active-investing"></i>
                        <?php } else { ?>
                        <i class="fa-solid fa-circle relaxed-investing"></i>
                        <?php } ?>
                    </h2>
                </div>
            </a>
        </div>
        <?php
            endif;
        endwhile;
        else:
        ?>
        <p><?php esc_html_e('No investors found.', 'cpm_investors'); ?></p>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>