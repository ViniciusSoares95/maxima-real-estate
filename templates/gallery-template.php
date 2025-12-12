<?php
/**
 * Template da Galeria
 */

// Recuperar atributos
global $maxima_galeria_atts;

// Query
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'galeria_item',
    'posts_per_page' => !empty($maxima_galeria_atts['itens_por_pagina']) ? intval($maxima_galeria_atts['itens_por_pagina']) : 6,
    'paged' => $paged,
    'post_status' => 'publish'
);

if (!empty($maxima_galeria_atts['categoria'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'categoria_galeria',
            'field' => 'slug',
            'terms' => $maxima_galeria_atts['categoria']
        )
    );
}

$gallery_query = new WP_Query($args);
?>

<section class="maxima-gallery-section">
    <div class="container">
        <div class="gallery-grid" id="galleryGrid">
            <?php if ($gallery_query->have_posts()) : ?>
                <?php while ($gallery_query->have_posts()) : $gallery_query->the_post(); ?>
                    <?php include get_template_directory() . '/templates/gallery-item.php'; ?>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="no-items">
                    <p class="lead"><?php _e('Nenhum item encontrado na galeria.', 'maxima'); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($gallery_query->max_num_pages > 1) : ?>
            <nav class="gallery-pagination" id="galleryPagination">
                <?php
                echo paginate_links(array(
                    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'format' => '?paged=%#%',
                    'current' => $paged,
                    'total' => $gallery_query->max_num_pages,
                    'prev_text' => __('‹', 'maxima'),
                    'next_text' => __('›', 'maxima'),
                    'type' => 'list',
                    'add_args' => false
                ));
                ?>
            </nav>
        <?php endif; ?>
    </div>
</section>

<!-- Lightbox -->
<div class="gallery-lightbox" id="galleryLightbox">
    <div class="lightbox-container">
        <span class="lightbox-counter" id="lightboxCounter"></span>
        <button class="lightbox-close" id="lightboxClose">&times;</button>
        <button class="lightbox-nav lightbox-prev" id="lightboxPrev">‹</button>
        <button class="lightbox-nav lightbox-next" id="lightboxNext">›</button>
        <div class="lightbox-content">
            <img src="" alt="" id="lightboxImage">
            <div class="lightbox-info" id="lightboxInfo">
                <h3 id="lightboxTitle"></h3>
                <p id="lightboxDescription"></p>
            </div>
        </div>
    </div>
</div>

<?php wp_reset_postdata(); ?>