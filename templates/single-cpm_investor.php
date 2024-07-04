<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
   exit;
}
get_header();

?>
<!-- Investors profile header -->
<section class="singlepage_profile">
    <div class= "mainsingle-page">
            <div class="investor-profile_maindiv">
                    <div class="profile_header">
                            <h2 class="investor_profile">CPM Investor Profile</h2>
                            <!-- <p class="investor_moto">No.1 Investing Platform</p> -->
                    </div>

             </div>
             <h2 class="cpm_investor_details">Investor Details</h2>
   
    <!-- condition to check if the investor date is valid or not -->
    <?php
          //assigning the 
          $investor_id = get_the_ID();
          $publish_date_admin  = get_post_meta($investor_id, 'cpm_investor_publish_date', true);   
          $valid_days = get_post_meta($investor_id, 'cpm_investor_valid_for', true);  // get the data from the db
          $investor_type = get_post_meta( $investor_id, 'cpm_investor_type', true); // This will be an array
         //  $total_valid_days = $publish_date_admin ." " .  $valid_days ;
         // echo $valid_days;

          if( have_posts() ):?>
    <div class="investor_content_div">
        <?php
            if( $valid_days >= 0):
            ?>
        <div class="cpm_investor_logo">

            <?php echo '<p class= "investor_logo">' . get_the_post_thumbnail(); '</p>'; ?>

            <?php   
                     //   echo '<h2 class="investor_username">' . get_the_title() . '</h2>'; 
                        ?>


        </div>
        <div class="investor_details_div">
           
            <!-- for the title -->
            <h3 class="cpminvestor_title"> <?php the_title(); ?></h3>

            <!-- founded date -->
            <p class="cpm_investor_foundedin" id="investor_attr"><strong>Founded In: </strong>
                <?php echo esc_html(get_post_meta($investor_id, 'cpm_investor_founded', true)); ?></p>

            <!-- investor type -->
            <?php if (!empty($investor_type)) : ?>
            <p class="cpm_investor_type" id="investor_attr"><strong>Investor Type:</strong>
                <?php echo implode(', ', array_map('esc_html', $investor_type)); ?></p>
            <?php 
                            endif;
                         ?>
            <!-- Investor country -->
            <p class="cpm_investor_country" id="investor_attr"><strong> Country: </strong>
                <?php echo esc_html(get_post_meta( $investor_id, 'cpm_investor_country', true)); ?></p>

            <!-- Investing Status -->
            <p class="cpm_investing_status" id="investor_attr"><strong>Investing Status: </strong>
                <?php echo esc_html(get_post_meta($investor_id, 'cpm_investing_status', true)); ?></p>

            <!-- Investment Type -->
            <p class="cpm_investment_type" id="investor_attr"><strong>Investment Type: </strong>
                <?php echo esc_html(get_post_meta( $investor_id, 'investment_type', true)); ?></p>

            <!-- for the description -->
            <p class="cpm_investment_content" id="investor_attr"><strong>Description:<strong><br>
                        <?php the_content(); ?></p>

        </div>
        <div class="side-bar">
            <aside id="secondary" class="widget-area">
                <?php dynamic_sidebar('investor-sidebar'); 
                get_sidebar();
                ?>
            </aside>
        </div>


        <?php
               else :
                  // If no posts found
                  // <p class="cpm_investment_content" id="investor_attr">Description:</p>
                  
                  echo '<p class = "expire_message">';
                  echo "Session Expired " ;
                  echo '<br>';
                  echo "Please Contact HO";
                  echo '<p>';
                 
            endif;
           
                  
         endif;
            
          
         // while( $publish_date_admin<= $total_valid_day){
         //    echo '<h2>' . the_title() . '</h2>';
         //    break;
         // }

         ?>

    </div>

    <?php
        
         ?>
</div>
</section>
<?php
  get_footer();     