<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
get_header();

?>
<!-- Investors profile header -->
<section class="singlepage_profile">
    <div class="mainsingle-page">
        <div class="investor-profile_maindiv">
            <div class="profile_header">
                <h2 class="investor_profile"><?php _e('CPM Investor Profile', 'cpm_investor'); ?></h2>
                <!-- <p class="investor_moto">No.1 Investing Platform</p> -->
            </div>
        </div>
        <h2 class="cpm_investor_details"><?php _e('Investor Details', 'cpm_investor'); ?></h2>

        <!-- condition to check if the investor date is valid or not -->
        <?php
        $investor_id = get_the_ID();
        $publish_date_admin  = get_post_meta($investor_id, 'cpm_investor_publish_date', true);
        $valid_days = get_post_meta($investor_id, 'cpm_investor_valid_for', true);  // get the data from the db
        $investor_type = get_post_meta($investor_id, 'cpm_investor_type', true); // This will be an array

        if (have_posts()) : ?>
        <div class="investor_content_div">
            <?php if ($valid_days >= 0) : ?>
            <div class="cpm_investor_logo">
                <?php echo '<p class= "investor_logo">' . get_the_post_thumbnail() . '</p>'; ?>
            </div>
            <div class="investor_details_div">
                <!-- for the title -->
                <h3 class="cpminvestor_title"> <?php the_title(); ?></h3>

                <!-- founded date -->
                <p class="cpm_investor_foundedin" id="investor_attr"><strong><?php _e('Founded In:', 'cpm_investor'); ?>
                    </strong>
                    <?php echo esc_html(get_post_meta($investor_id, 'cpm_investor_founded', true)); ?></p>

                <!-- investor type -->
                <?php if (!empty($investor_type)) : ?>
                <p class="cpm_investor_type" id="investor_attr">
                    <strong><?php _e('Investor Type:', 'cpm_investor'); ?></strong>
                    <?php echo implode(', ', array_map('esc_html', $investor_type)); ?>
                </p>
                <?php endif; ?>

                <!-- Investor country -->
                <p class="cpm_investor_country" id="investor_attr"><strong><?php _e('Country:', 'cpm_investor'); ?>
                    </strong>
                    <?php echo esc_html(get_post_meta($investor_id, 'cpm_investor_country', true)); ?></p>

                <!-- Investing Status -->
                <p class="cpm_investing_status" id="investor_attr">
                    <strong><?php _e('Investing Status:', 'cpm_investor'); ?> </strong>
                    <?php echo esc_html(get_post_meta($investor_id, 'cpm_investing_status', true)); ?>
                </p>

                <!-- Capital (USD) -->
                <strong><?php _e('Capital (USD):', 'cpm_investor'); ?> </strong>
                <div class="currency-exchange">
                    <p class="currency" id="investor_currency" name="usd_amount"
                        data-usd-amount="<?php echo esc_html(get_post_meta($investor_id, 'cpm_capital_usd', true)); ?>">
                        <strong>$</strong><?php echo esc_html(get_post_meta($investor_id, 'cpm_capital_usd', true)); ?>
                    </p>
                    <button id="onclick-exchange" class="exchange-button">
                        <img class="dollar-exchange"
                            src="<?php echo plugin_dir_url(__FILE__) . 'images/icons8-dollar-euro-exchange-50.png'; ?>"
                            alt="<?php _e('Currency Exchange Logo', 'cpm_investor'); ?>">
                    </button>
                </div>

                <!-- for the description -->
                <p class="cpm_investment_content" id="investor_attr">
                    <strong><?php _e('Description:', 'cpm_investor'); ?><strong><br>
                            <?php the_content(); ?>
                </p>
            </div>
            <!-- <div class="side-bar">
                <aside id="secondary" class="widget-area">
                    <?php 
                    // dynamic_sidebar('investor-sidebar');
                            // get_sidebar(); ?>
                </aside>
            </div> -->

            <?php else : ?>
            <!-- If no posts found -->
            <p class="expire_message">
                <?php _e('Session Expired', 'cpm_investor'); ?><br>
                <?php _e('Please Contact HO', 'cpm_investor'); ?>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>