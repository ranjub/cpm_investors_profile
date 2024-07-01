<?php
/* Template Name: Investor Archive */
get_header(); ?>

<div class="investors-archive">
    <h1>Investors</h1>
    <div class="investors-grid">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
        <?php endwhile; else: ?>
        <p><?php esc_html_e('No investors found.', 'cpm_investors'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>