<?php
get_header();
?>

<div class="content-area">
    <main class="site-main">
        <header class="page-header">
            <h1 class="page-title">Investors</h1>
        </header>
        <?php if ( have_posts() ) : ?>
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