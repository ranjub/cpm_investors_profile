<?php
get_header();
?>

<div class="content-area">
    <main class="site-main">
        <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <h1 class="page-title">Investors</h1>
        </header>

        <?php
            // Start the Loop.
            while ( have_posts() ) :
                the_post();
            endwhile;
        endif;
        ?>
    </main>
</div>

<?php

get_footer();
?>