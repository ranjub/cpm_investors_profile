<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
   exit;
}
get_header();
?>
 <section class="cpm_investor_section">
<div class = "cpm_investor">
   <h1 class="cpm_investor_heading">Investor Details</h1>
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
 </div>
  <!-- for sidebar  -->
      <div class="investor_sidebar">
              <aside id="secondary" class="widget-area">
                     <?php dynamic_sidebar('investor-sidebar'); ?>
            </aside>
      </div>
</section>
<section class="cpm_investor_sidebar">
   
</section>
<?php
get_footer();
?>