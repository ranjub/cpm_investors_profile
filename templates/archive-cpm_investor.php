<?php
/* Template Name: Investor Archive */
get_header();
?>

<div class="investors-archive">
    <h1><?php _e('Investors', 'cpm_investors'); ?></h1>
    <!-- Filter for search area -->
    <h3><?php _e('Search By', 'cpm_investors'); ?></h3>
    <div class="filter-search">
        <form id="searchform" method="get">
            <input type="text" id="searchFilter" name="searcharea"
                placeholder="<?php esc_attr_e('Free text search', 'cpm_investors'); ?>"
                value="<?php echo get_search_query(), esc_attr($_GET['searcharea'] ?? ''); ?>" />

            <?php
            // Fetch unique countries
            $countries = get_posts(array(
                'post_type' => 'cpm_investor',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'meta_key' => 'cpm_investor_country',
                'meta_value' => '',
                'meta_compare' => '!=',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'distinct' => true,
            ));
            $unique_countries = array();
            foreach ($countries as $country_id) {
                $country = get_post_meta($country_id, 'cpm_investor_country', true);
                if (!in_array($country, $unique_countries)) {
                    $unique_countries[] = $country;
                }
            }
            ?>

            <select id="searchFilter" name="country">
                <option value=""><?php esc_html_e('Select Country', 'cpm_investors'); ?></option>
                <?php foreach ($unique_countries as $country) : ?>
                <option value="<?php echo esc_attr($country); ?>"
                    <?php selected(esc_attr($_GET['country'] ?? ''), $country); ?>>
                    <?php echo esc_html($country); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select id="searchFilter" name="searchinvestortype">
                <option value=""><?php esc_html_e('Select Investor Type', 'cpm_investors'); ?></option>
                <option value="VC" <?php selected(esc_attr($_GET['searchinvestortype'] ?? ''), 'VC'); ?>>
                    <?php esc_html_e('VC', 'cpm_investors'); ?></option>
                <option value="Accelerator"
                    <?php selected(esc_attr($_GET['searchinvestortype'] ?? ''), 'Accelerator'); ?>>
                    <?php esc_html_e('Accelerator', 'cpm_investors'); ?></option>
            </select>

            <select id="searchFilter" name="searchstatus">
                <option value=""><?php esc_html_e('Select Investing Status', 'cpm_investors'); ?></option>
                <option value="Actively Investing"
                    <?php selected(esc_attr($_GET['searchstatus'] ?? ''), 'Actively Investing'); ?>>
                    <?php esc_html_e('Actively Investing', 'cpm_investors'); ?></option>
                <option value="Relaxed Investing"
                    <?php selected(esc_attr($_GET['searchstatus'] ?? ''), 'Relaxed Investing'); ?>>
                    <?php esc_html_e('Relaxed Investing', 'cpm_investors'); ?></option>
            </select>

            <button type="submit"><?php esc_html_e('Filter', 'cpm_investors'); ?></button>
        </form>
    </div>

    <!-- Display investors with logo and valid days on -->
    <div class="investors-grid">
        <?php
        // Initialize WP_Query based on search filters
        $meta_query = array('relation' => 'AND');

        if (!empty($_GET['country'])) {
            $meta_query[] = array(
                'key'     => 'cpm_investor_country',
                'value'   => sanitize_text_field($_GET['country']),
                'compare' => 'LIKE',
            );
        }

        if (!empty($_GET['searchinvestortype'])) {
            $meta_query[] = array(
                'key'     => 'cpm_investor_type',
                'value'   => sanitize_text_field($_GET['searchinvestortype']),
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
        );

        if (!empty($_GET['searcharea'])) {
            $args['s'] = sanitize_text_field($_GET['searcharea']);
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) :
                $query->the_post();
                $investor_id = get_the_ID();
                $valid_days = get_post_meta($investor_id, 'cpm_investor_valid_for', true);  // Get the data from the DB
                $investing_status = get_post_meta($investor_id, 'cpm_investing_status', true); // Get the investing status
                if ($valid_days >= 0) :
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
                                    if ($investing_status == "Actively Investing") { ?>
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
        else :
            ?>
        <p><?php esc_html_e('No investors found.', 'cpm_investors'); ?></p>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php get_footer(); ?>