<?php
/* Template Name: Investor Archive */
get_header(); ?>

<div class="investors-archive">
    <h1>Investors</h1>
    <!-- filter for search area  -->
   
     <h3>Search</h3>
     <div>
        <!-- for searching freely -->
            <div>
                         <input type="text" id="searchFilter" name="search" placeholder="Search"value="<?php echo get_search_query(); ?>" />
                         
           </div>

           <!-- for filtering with country -->
            <div>
            <input type="text" id="searchFilter" name="investor_country" placeholder="Country" value="<?php echo get_search_query(); ?>" />
           
            </div>

            <!-- filter to search the investing  status  -->
            <div>
            <input type="text" id="searchFilter" name="investing_status" placeholder="Investing Status" value="<?php echo get_search_query(); ?>" />
            
            </div>

             <!-- filter to search the investment type  -->
            <div>
            <input type="text" id="searchFilter" name="investor_type" placeholder="Investment Type" value="<?php echo get_search_query(); ?>" />
           
            </div>
            <!-- search button -->
            <!-- <div>
            <button>Filter</button>
            </div> -->

            <!-- handiling the search filter form -->
             <?php
 function filter_posts_by_country( $query ) {
    global $pagenow;

    // Check if we're on the edit screen and the query is the main query
    if ( is_admin() ||!$query->is_main_query() ) return;

    // Check if the country parameter is present
    if ( isset($_GET['investor_country']) &&!empty($_GET['investor_country']) ) {
        $investor_country = sanitize_text_field($_GET['investor_country']);

        // Modify the query to include posts from the specified country
        $query->set('meta_key', 'country'); // Assuming 'country' is the meta key
        $query->set('meta_value', $country);
    }
}

add_action('pre_get_posts', 'filter_posts_by_country');

?>

    </div>
   <!-- to display investor with logo and having valid days on -->
    <div class="investors-grid">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php
                  $investor_id = get_the_ID();
                  $valid_days = get_post_meta($investor_id, 'cpm_investor_valid_for', true);  // get the data from the db
                 if( $valid_days >= 0):
            ?>
        <div class="investor-item">
            <a href="<?php the_permalink(); ?>">
                <div class="investor-container">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="investor-logo">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                    <?php endif; ?>
                    <h2 class="investor-title"><?php the_title(); ?></h2>
                </div>
            </a>
        </div>
        <?php
            endif;
            ?>
        <?php endwhile; else: ?>
        <p><?php esc_html_e('No investors found.', 'cpm_investors'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>