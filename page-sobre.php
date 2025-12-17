<?php get_header(); ?>
<?php
// Carregar dados do vídeo
$video = get_video_sobre_data();

// Classes condicionais
$section_classes = array('hero-about-section');
if (!$video['ativo'] || !$video['has_video']) {
    $section_classes[] = 'no-video';
}
$section_class_string = implode(' ', array_map('sanitize_html_class', $section_classes));

?>
<main>
<!-- Hero Section - Sobre Nós -->
<section class="<?php echo esc_attr($section_class_string); ?>">
    
    <?php if ($video['ativo'] && $video['has_video']) : ?>
        <!-- Video Background -->
        <div class="hero-video-wrapper">
            <video class="hero-video" autoplay muted loop playsinline 
                   <?php echo !empty($video['poster']) ? 'poster="' . esc_url($video['poster']) . '"' : ''; ?>
                   preload="metadata"
                   aria-label="<?php esc_attr_e('Vídeo de fundo da página sobre', 'maxima'); ?>">
                
                <!-- Vídeo MP4 -->
                <?php if (!empty($video['mp4'])) : ?>
                    <?php 
                    // Determinar tipo MIME corretamente
                    $mime_type = wp_check_filetype($video['mp4'], wp_get_mime_types());
                    $mime_type_value = !empty($mime_type['type']) ? $mime_type['type'] : 'video/mp4';
                    ?>
                    <source src="<?php echo esc_url($video['mp4']); ?>" 
                            type="<?php echo esc_attr($mime_type_value); ?>">
                <?php endif; ?>
                
                <!-- Vídeo WebM -->
                <?php if (!empty($video['webm'])) : ?>
                    <?php 
                    $mime_type_webm = wp_check_filetype($video['webm'], wp_get_mime_types());
                    $mime_type_webm_value = !empty($mime_type_webm['type']) ? $mime_type_webm['type'] : 'video/webm';
                    ?>
                    <source src="<?php echo esc_url($video['webm']); ?>" 
                            type="<?php echo esc_attr($mime_type_webm_value); ?>">
                <?php endif; ?>
                
                <!-- Mensagem de fallback -->
                <?php esc_html_e('Seu navegador não suporta vídeos HTML5.', 'maxima'); ?>
            </video>
            <div class="hero-video-overlay"></div>
        </div>
    
    <?php elseif (!empty($video['poster'])) : ?>
        <!-- Exibir apenas imagem de fallback se o vídeo estiver desativado -->
        <div class="hero-video-wrapper">
            <img src="<?php echo esc_url($video['poster']); ?>" 
                 alt="<?php esc_attr_e('Background da página sobre', 'maxima'); ?>" 
                 class="hero-background-image"
                 loading="lazy"
                 width="1920"
                 height="1080">
            <div class="hero-video-overlay"></div>
        </div>
    <?php endif; ?>
    
    <!-- Triângulo -->
    <div class="hero-about-triangle"></div>
</section>

<!-- Hero Section -->
    <section class="sobre-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h1>Sobre nós</h1>
                    <p class="subtitle">Conheça a Máxima</p>
                    <p class="intro-text">
                        A Máxima Real Estate está no mercado há 10 anos, tendo sido fundada por Fabrício Basano e Samuel Bello. 
                        Com vasta experiência no setor imobiliário e uma sólida base administrativa, os fundadores estabeleceram 
                        um empreendimento único voltado exclusivamente para investidores. Oferecendo uma seleção criteriosa 
                        de produtos e serviços, a empresa atende plenamente conceituada e reconhecida como referência nacional 
                        e internacional no setor de investimentos imobiliários premium. A equipe altamente qualificada 
                        da Máxima Real Estate é composta por profissionais altamente qualificados nas áreas jurídica, tributária e de 
                        engenharia, prontos para contar com uma equipe de brokers de elite, preparados para atender cada perfil de 
                        investidores com excelência.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="sobre-content">
        <div class="sobre-container">
            <div class="content-grid">
                <!-- Left Column - Valores -->
                <div class="content-text">
                    <h3 class="section-title">Nossos Valores</h3>
                    
                    <div class="value-item">
                        <h4>Atendimento Personalizado ao Investidor</h4>
                        <p>
                            Nos comprometemos a fornecer um atendimento exclusivo e personalizado, mantendo a confidencialidade das 
                            informações (NDA) e garantindo a satisfação e confiança dos nossos investidores.
                        </p>
                    </div>

                    <div class="value-item">
                        <h4>Transparência Total nos Investimentos</h4>
                        <p>
                            Nos esforçamos para garantir a máxima transparência em todas as etapas do processo de investimento, 
                            incluindo o acompanhamento rigoroso das diligências jurídicas e tributárias, para que nossos investidores 
                            estejam sempre informados e seguros em suas decisões.
                        </p>
                    </div>

                    <div class="value-item">
                        <h4>Foco na Rentabilidade do Investidor</h4>
                        <p>
                            Nossa operação é guiada pelo objetivo de maximizar a rentabilidade dos investidores, por meio da identificação e 
                            execução de oportunidades de investimento de alto potencial.
                        </p>
                    </div>

                    <div class="value-item">
                        <h4>Responsabilidade Social e Ambiental</h4>
                        <p>
                            A Máxima Real Estate está comprometida em atuar de forma responsável, contribuindo para o 
                            desenvolvimento sustentável e considerando os impactos sociais e ambientais de suas atividades.
                        </p>
                    </div>
                </div>

                <!-- Right Column - Image with Overlays -->
                <div class="content-image-wrapper">
                    <!-- Main Image -->
                    <div class="main-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/backgroundimages/testefachada.webp" alt="Fachada Máxima Real Estate">
                    </div>

                    <!-- Overlay Box - Left Side covering image -->
                    <div class="overlay-left">
                        <div class="vm-item">
                            <h3>Nossa Visão</h3>
                            <p>
                                A Máxima Real Estate aspira ser uma referência indiscutível na gestão de 
                                ativos e no desenvolvimento imobiliário, sempre priorizando soluções 
                                jurídicas e financeiras inovadoras nas operações que realiza.
                            </p>
                        </div>
                    </div>

                    <!-- Overlay Box - Bottom covering image -->
                    <div class="overlay-bottom">
                        <div class="vm-item">
                            <h3>Nossa Missão</h3>
                            <div class="vm-divider"></div>
                            <p>
                                A missão da Máxima Real Estate é colocar os interesses dos 
                                investidores em primeiro lugar, gerando rentabilidade sustentável a partir 
                                dos ativos imobiliários. Isso é alcançado por meio do trabalho meticuloso de 
                                uma equipe especializada, que se dedica a superar as expectativas dos 
                                investidores.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
<?php echo do_shortcode('[maxima_logos]'); ?>

 <?php get_template_part('templates/contact', 'section') ?>


</main>

<?php get_footer(); ?>