<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
   exit;
}
get_header();
?>
 <!-- Investors profile header -->
  <section class="singlepage_profile">
      <div class="investor-profile_maindiv">
         <div class="profile_header">
             <h2 class="investor_profile">CPM Investor Profile</h2>
             <p class="investor_moto">No.1 Investing Platform</p>
         </div>
      </div>
         <!-- condition to check if the investor date is valid or not -->
         <?php
          //assigning the 
          $investor_id = get_the_ID();
          $publish_date_admin  = get_post_meta($investor_id, 'cpm_investor_publish_date', true);   
          $valid_days = get_post_meta($investor_id, 'cpm_investor_valid_for', true);  // get the data from the db
  
         //  $total_valid_days = $publish_date_admin ." " .  $valid_days ;
         // echo $valid_days;

          if( have_posts() ):?>
   <div class="investor_content_div">
           <?php
            if( $valid_days >= 0):
            ?>
               <div class="cpm_investor_logo">

                       <?php echo '<p class= "investor_logo">' . get_the_post_thumbnail(); '</p>'; ?>

                       <?php   echo '<h2 class="investor_username">' . get_the_title() . '</h2>';  ?>

                        
               </div>
               <div>

               </div>

              
               <?php
               else :
                  // If no posts found
                  echo 'No posts found.';          
            endif;
             

         endif;
          
         // while( $publish_date_admin<= $total_valid_day){
         //    echo '<h2>' . the_title() . '</h2>';
         //    break;
         // }

      
         ?>
   </div>  
  </section>
  <?php
  get_footer();     

