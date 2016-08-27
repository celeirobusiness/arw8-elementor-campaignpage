<html>

    <head>
        <?php wp_head(); ?>
    </head>

    <body>
        <div id="primary" class="site-content">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; // End of the loop. ?>
        </div><!-- #primary -->
    </body>

</html>
