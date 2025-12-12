<?php
/**
 * Template da Seção de Logos
 */

// Recuperar atributos
global $maxima_logos_atts;

// Query para logos
$args = array(
    'post_type' => 'logo_parceiro',
    'posts_per_page' => !empty($maxima_logos_atts['limite']) ? intval($maxima_logos_atts['limite']) : -1,
    'post_status' => 'publish',
    'orderby' => array(
        'meta_value_num' => 'DESC',
        'date' => 'DESC'
    ),
    'meta_key' => '_logo_destaque'
);

// Filtrar por categoria se especificado
if (!empty($maxima_logos_atts['categoria'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'categoria_logo',
            'field' => 'slug',
            'terms' => $maxima_logos_atts['categoria']
        )
    );
}

$logos_query = new WP_Query($args);

?>

<section class="maxima-logos-section">
    <div class="container">
        <div class="logos-section-title">
            <h2><?php _e('Faça parte do nosso portfólio de elite', 'maxima'); ?></h2>

        </div>
    </div>

    <?php if ($logos_query->have_posts()) : ?>
        <?php 
        $logos_array = array();
        while ($logos_query->have_posts()) : $logos_query->the_post();
            $logo_id = get_the_ID();
            $logo_title = get_the_title();
            $logo_image = get_the_post_thumbnail_url($logo_id, 'full');
            $logo_website = get_post_meta($logo_id, '_logo_website', true);
            
            if ($logo_image) {
                $logos_array[] = array(
                    'title' => $logo_title,
                    'image' => $logo_image,
                    'website' => $logo_website
                );
            }
        endwhile;
        wp_reset_postdata();
        
        // Dividir logos em duas linhas
        $logos_row1 = array();
        $logos_row2 = array();
        
        foreach ($logos_array as $index => $logo) {
            if ($index % 2 == 0) {
                $logos_row1[] = $logo;
            } else {
                $logos_row2[] = $logo;
            }
        }
        ?>
           
        <?php if (!empty($logos_row1)) : ?>
            <!-- Primeira linha de logos -->
            <div class="logos-carousel-wrapper">
                <div class="logos-track" id="logosTrack1">
                    <?php foreach ($logos_row1 as $logo) : ?>
                        <div class="logo-item">
                            <?php if (!empty($logo['website'])) : ?>
                                <a href="<?php echo esc_url($logo['website']); ?>" target="_blank" rel="noopener noreferrer">
                                    <img src="<?php echo esc_url($logo['image']); ?>" 
                                         alt="<?php echo esc_attr($logo['title']); ?>"
                                         title="<?php echo esc_attr($logo['title']); ?>">
                                </a>
                            <?php else : ?>
                                <img src="<?php echo esc_url($logo['image']); ?>" 
                                     alt="<?php echo esc_attr($logo['title']); ?>"
                                     title="<?php echo esc_attr($logo['title']); ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($logos_row2)) : ?>
            <!-- Segunda linha de logos (movimento reverso) -->
            <div class="logos-carousel-wrapper">
                <div class="logos-track reverse" id="logosTrack2">
                    <?php foreach ($logos_row2 as $logo) : ?>
                        <div class="logo-item">
                            <?php if (!empty($logo['website'])) : ?>
                                <a href="<?php echo esc_url($logo['website']); ?>" target="_blank" rel="noopener noreferrer">
                                    <img src="<?php echo esc_url($logo['image']); ?>" 
                                         alt="<?php echo esc_attr($logo['title']); ?>"
                                         title="<?php echo esc_attr($logo['title']); ?>">
                                </a>
                            <?php else : ?>
                                <img src="<?php echo esc_url($logo['image']); ?>" 
                                     alt="<?php echo esc_attr($logo['title']); ?>"
                                     title="<?php echo esc_attr($logo['title']); ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
    <?php else : ?>
        <div class="container">
            <div class="no-logos-message">
                <p><?php _e('Nenhum logo cadastrado.', 'maxima'); ?></p>
            </div>
        </div>
    <?php endif; ?>
</section>