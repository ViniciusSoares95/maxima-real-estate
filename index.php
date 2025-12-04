<?php
/**
 * The main template file (fallback)
 */
get_header();
?>

<main id="primary" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;
        
        // Paginação (se necessário)
        the_posts_navigation();
    else :
        // Se não houver conteúdo
        get_template_part('template-parts/content', 'none');
    endif;
    ?>
</main>

<?php
get_sidebar(); // Se você usa sidebar
get_footer();
