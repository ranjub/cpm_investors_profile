<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
   exit;
}
get_header();
?>
 <section class="cpm_investor_section">
<div class = "cpm_investor">
   <h2 class="cpm_investor_heading">Investor Details</h2>
   <?php
   $investor_type = get_post_meta(get_the_ID(), 'cpm_investor_type', true); // This will be an array
      ?>

  <h2 class="cpminvestor_title"> <?php the_title(); ?></h2>
  <div class="cpm_investor_content">
  <p > <?php the_content(); ?> <p>
  </div>
  <p class = "cpm_investor_foundedin"><strong>Founded In: </strong><?php echo esc_html(get_post_meta(get_the_ID(), 'cpm_investor_founded', true)); ?></p>
  <?php if (!empty($investor_type)) : ?>
                    <p class="cpm_investor_type"><strong>Investor Type:</strong> <?php echo implode(', ', array_map('esc_html', $investor_type)); ?></p>
                <?php endif; ?>
   <p class = "cpm_investor_country"><strong>Country: </strong><?php echo esc_html(get_post_meta(get_the_ID(), 'cpm_investor_country', true)); ?></p>
   <p class = "cpm_investing_status"><strong>Investing Status: </strong><?php echo esc_html(get_post_meta(get_the_ID(), 'cpm_investing_status', true)); ?></p>
   <p class = "cpm_investmet_type"><strong>Investment Type: </strong><?php echo esc_html(get_post_meta(get_the_ID(), 'investment_type', true)); ?></p>

 </div>
  <!-- for sidebar  -->
      <div class="investor_sidebar">
              <aside id="secondary" class="widget-area">
                     <?php dynamic_sidebar('investor-sidebar'); ?>
            </aside>
      </div>
</section>

<?php
get_footer();
?>