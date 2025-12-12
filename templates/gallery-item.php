<?php
/**
 * Template para item individual da galeria
 */
$area = get_post_meta(get_the_ID(), '_gallery_area', true);
$suites = get_post_meta(get_the_ID(), '_gallery_suites', true);
$location = get_post_meta(get_the_ID(), '_gallery_location', true);

// Construir descrição
$details = array();
if ($area) $details[] = $area . 'm²';
if ($suites) $details[] = $suites . ' ' . _n('suíte', 'suítes', $suites, 'maxima');
if ($location) $details[] = $location;

$description = implode(' | ', $details);

// Obter imagem grande para o lightbox
$large_image_url = '';
if (has_post_thumbnail()) {
    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'maxima-gallery-large');
    $large_image_url = $large_image_url ? $large_image_url[0] : '';
}
?>

<article class="gallery-item" data-id="<?php the_ID(); ?>" style="cursor: pointer;">
    <div class="gallery-item-inner">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('maxima-gallery-thumb', array(
                'class' => 'gallery-image',
                'loading' => 'lazy',
                'alt' => get_the_title(),
                'data-large' => $large_image_url // Adicionado para lightbox grande
            )); ?>
        <?php else : ?>
            <div class="gallery-image" style="background: #1a1a1a; display: flex; align-items: center; justify-content: center; color: #666;">
                <i class="fas fa-home" style="font-size: 3rem;"></i>
            </div>
        <?php endif; ?>
        
        <div class="gallery-overlay">
            <h3 class="gallery-item-title"><?php the_title(); ?></h3>
            <?php if ($description) : ?>
                <p class="gallery-item-details"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
            <span class="gallery-view-more">
                <?php _e('Ver detalhes', 'maxima'); ?>
            </span>
        </div>
    </div>
</article>