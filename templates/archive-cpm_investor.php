<?php
/* Template Name: Investor Archive */
get_header(); ?>

<div class="investors-archive">
    <h1>Investors</h1>
    <!-- filter for search area  -->
   
     <h3>Search</h3>
     <div>
        
     </div>
            <!-- handiling the search filter form -->
             <?php
// Check if the form was submitted
if (isset($_GET['searchstatus'])) {
    $searchTerm = sanitize_text_field($_GET['searchstatus']);
    
    // Query posts by meta key value
    $args = array(
        'post_type'  => 'cpm_investor', // Adjust according to your needs
        'meta_query' => array(
            array(
                'key'     => 'cpm_investing_status', 
                'value'   => $searchTerm,
                'compare' => '=',
            ),
        ),
    );
    $query = new WP_Query($args);

    // Check if any posts were found
    if ($query->have_posts()) {
        // Start output buffering to capture the post content
        ob_start();

        // Loop through the posts and display them
        while ($query->have_posts()) {
            $query->the_post();
            get_the_post_thumbnail();
        }

        // End output buffering and display the captured content
        echo '<div>'. ob_get_clean(). '</div>';

        // Reset post data to avoid conflicts with other loops
        wp_reset_postdata();
    } else {
        echo "No posts found with the entered input.";
    }
}



?>

   
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