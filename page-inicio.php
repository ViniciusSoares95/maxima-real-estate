<?php
get_header();
?>
<main>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background"></div>

        <div class="hero-content">
            <div class="container">
                <!-- Título Principal -->
                <div class="hero-title-section text-center" data-aos="fade-up">
                    <h1 class="hero-title">
                        Investimentos Imobiliários com Alta Rentabilidade e Segurança
                    </h1>
                    <p class="hero-subtitle" data-aos-delay="200">
                        DE ALTO PADRÃO
                    </p>
                </div>

                <!-- Descrição -->
                <div class="hero-description-section text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="description-box">
                        <p class="description-text">
                            Descubra um mundo de <strong>investimentos imobiliários exclusivos e rentáveis</strong>. <br>
                            Junte-se à nossa elite de investidores e esteja à frente, aproveitando <strong>oportunidades únicas <br>
                            em ativos premium</strong> que moldam o mercado e estabelecem <strong> <span>novos padrões de excelência</span></strong>.

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Triângulo -->
        <div class="hero-triangle"></div>
    </section>

    <!-- Services Section -->
    <section class="services-section" id="servicos">
        <div class="container">
            <!-- Título da Seção -->
            <div class="services-header text-center" data-aos="fade-up">
                <h2 class="services-title">Soluções em Investimentos <br> Imobiliários Premium</h2>
                <p class="services-subtitle">Mais de 10 anos de excelência oferecendo soluções rentáveis e sustentáveis para investidores exigentes.</p>
            </div>

            <div class="row">
                <!-- Card 1: Built To Suit -->
                <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
                    <div class="service-card-wrapper">
                        <div class="service-icon-external">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/BuiltToSuit.webp" alt="Built To Suit" class="service-icon-img">
                        </div>
                        <div class="service-card d-flex flex-column justify-content-center">
                            <h3>Built To Suit</h3>
                            <p class="service-subtitle">(SLB)</p>
                            <p class="service-description">Projetos personalizados para construção de imóveis conforme as necessidades do locatário, com contratos de longo prazo.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Sale & Leaseback -->
                <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card-wrapper">
                        <div class="service-icon-external">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/Sale&Leaseback.webp" alt="Sale & Leaseback" class="service-icon-img">
                        </div>
                        <div class="service-card d-flex flex-column justify-content-center">
                            <h3>Sale & Leaseback</h3>
                            <p class="service-subtitle">(SLB)</p>
                            <p class="service-description">Oportunidades de investimento em imóveis comerciais e residenciais em diversos países, principalmente EUA e Europa, através de ações de empresas de incorporação, construtoras, ou REITs.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Imóveis com Renda -->
                <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card-wrapper">
                        <div class="service-icon-external">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/ImoveisComRenda.webp" alt="Imóveis com Renda" class="service-icon-img">
                        </div>
                        <div class="service-card d-flex flex-column justify-content-center">
                            <h3>Imóveis com Renda</h3>
                            <p class="service-description">Locação de imóveis comerciais para instituições sólidas, como instituições bancárias e grandes varejistas, com contratos de longo prazo.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Leilões -->
                <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
                    <div class="service-card-wrapper">
                        <div class="service-icon-external">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/Leiloes.webp" alt="Leilões" class="service-icon-img">
                        </div>
                        <div class="service-card d-flex flex-column justify-content-center">
                            <h3>Leilões</h3>
                            <p class="service-description">Venda de imóveis recuperados de dívidas, com assessoria completa no processo de compra e legalização.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Loteamentos -->
                <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card-wrapper">
                        <div class="service-icon-external">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/Loteamentos.webp" alt="Loteamentos" class="service-icon-img">
                        </div>
                        <div class="service-card d-flex flex-column justify-content-center">
                            <h3>Loteamentos</h3>
                            <p class="service-description">Prospecção de áreas para loteamentos e vendas de lotes, com um levantamento completo de áreas possíveis de urbanização.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6: Investimentos no Exterior -->
                <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card-wrapper">
                        <div class="service-icon-external">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/InvestimentosNoExterior.webp" alt="Investimentos no Exterior" class="service-icon-img">
                        </div>
                        <div class="service-card d-flex flex-column justify-content-center">
                            <h3>Investimentos<br>no Exterior</h3>
                            <p class="service-description">Oportunidades de investimento em imóveis comerciais e residenciais em diversos países, principalmente EUA e Europa, através de ações de empresas de incorporação, construtoras, ou REITs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <section class="about-section" id="sobre">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Coluna do texto com fundo escuro que invade a imagem -->
                <div class="col-lg-7 about-text-column">
                    <div class="about-content">
                        <h2>Exclusividade,<br>Gestão<br>e Rentabilidade</h2>
                        <p>A trajetória da Máxima Real Estate é uma narrativa de visão, expertise e comprometimento inabalável com a excelência. 
                            Fundada por sócios com vasta experiência no segmento imobiliário e competências administrativas de destaque, 
                            a empresa nasceu com o propósito de criar um nicho exclusivo no mercado para investidores exigentes. 
                            <strong>O diferencial da Máxima Real Estate reside na oferta de produtos e serviços meticulosamente selecionados</strong>, 
                            projetados para atender às necessidades de um público que busca mais do que apenas retorno financeiro: 
                            <strong class="destaqueCor">busca segurança, inovação e sustentabilidade em seus investimentos.</strong></p>
                    </div>
                </div>
                
                <!-- Coluna da imagem -->
                <div class="about-image-column">
                    <div class="about-image"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Triângulo -->
        <div class="about-section-triangle"></div>


<?php echo do_shortcode('[maxima_galeria]'); ?>

<!-- Portfolio Section -->
<?php echo do_shortcode('[maxima_logos]'); ?>

<!-- Contact Section --->
<section class="contact-section" id="contato">
    <div class="container">
        <h2>FALE CONOSCO</h2>
        <div class="contact-box">
            <div class="contact-item">
                <i class="fab fa-instagram"></i>
                <span>@maximarealestate_</span>
            </div>
            <div class="contact-item">
                <i class="fab fa-whatsapp"></i>
                <span>44 3029-5999</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-globe"></i>
                <span>www.maximaemp.com.br</span>
            </div>
        </div>
    </div>
</section>

</main>

<?php get_footer(); ?>