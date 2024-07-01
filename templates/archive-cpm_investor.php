<?php
/* Template Name: Investor Archive */
get_header(); ?>

<div class="investors-archive">
    <h1>Investors</h1>
    <!-- filter for search area  -->

    <h3>Search By</h3>
    <div class="filter-search">
        <form id="searchform" method="get">
            <input type="text" id="searchFilter" name="s" placeholder="Free text search"
                value="<?php echo get_search_query(); ?>" />
            <input type="text" id="searchFilter" name="country" placeholder="Investor Country"
                value="<?php echo esc_attr($_GET['country'] ?? ''); ?>" />
            <input type="text" id="searchFilter" name="investment-type" placeholder="Investment Type"
                value="<?php echo esc_attr($_GET['investment-type'] ?? ''); ?>" />
            <input type="text" id="searchFilter" name="searchstatus" placeholder="Investing Status"
                value="<?php echo esc_attr($_GET['searchstatus'] ?? ''); ?>" />
            <button type="submit">Filter</button>
        </form>
    </div>

    <!-- to display investor with logo and having valid days on -->
    <div class="investors-grid">
        <?php
        // Modify the query to include search parameters
        $meta_query = array();

        if (!empty($_GET['country'])) {
            $meta_query[] = array(
                'key'     => 'cpm_investor_country',
                'value'   => sanitize_text_field($_GET['country']),
                'compare' => 'LIKE',
            );
        }

        if (!empty($_GET['investment-type'])) {
            $meta_query[] = array(
                'key'     => 'investment_type',
                'value'   => sanitize_text_field($_GET['investment-type']),
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

        $query = new WP_Query($args);

        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            $investor_id = get_the_ID();
            $valid_days = get_post_meta($investor_id, 'cpm_investor_valid_for', true);  // get the data from the db
            $investing_status = get_post_meta($investor_id, 'cpm_investing_status', true); // get the investing status
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
                        if($investing_status == "Actively Investing")
                        {?>
                        <i class="fa-solid fa-circle active-investing"></i>
                        <?php
                    }
                    else{?>
                        <i class="fa-solid fa-circle relaxed-investing"></i>
                        <?php }
                        ?>

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