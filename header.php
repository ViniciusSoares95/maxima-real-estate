<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <nav id="maxima-navbar">
        <!-- Email no lado esquerdo -->
        <div class="navbar-email">
            <a href="mailto:contato@maximaemp.com.br">
                <i class="fas fa-envelope"></i>
                <span>contato@maximaemp.com.br</span>
            </a>
        </div>

        <!-- Container do menu COM LOGO NO MEIO -->
        <div class="navbar-menu-container">
            <div class="menu-center-wrapper">
                <!-- Menu Esquerdo WordPress -->
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'maxima_main_menu_left',
                    'container' => false,
                    'menu_class' => 'navbar-menu-left',
                    'items_wrap' => '<ul class="navbar-menu-left">%3$s</ul>',
                    'fallback_cb' => false,
                ));
                ?>

                <!-- LOGO NO MEIO -->
                <div class="nav-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-logo">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            echo '<span class="logo-text">MAXIMA</span>';
                        }
                        ?>
                    </a>
                </div>

                <!-- Menu Direito WordPress -->
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'maxima_main_menu_right',
                    'container' => false,
                    'menu_class' => 'navbar-menu-right',
                    'items_wrap' => '<ul class="navbar-menu-right">%3$s</ul>',
                    'fallback_cb' => false,
                ));
                ?>
            </div>
        </div>

        <!-- Telefone no lado direito -->
        <div class="navbar-phone">
            <a href="tel:+554430295999">
                <i class="fas fa-phone"></i>
                <span>+55 44 3029-5999</span>
            </a>
        </div>

        <!-- Logo para mobile (visível apenas em mobile) -->
        <div class="mobile-header-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<span class="logo-text">MAXIMA</span>';
                }
                ?>
            </a>
        </div>

        <!-- Botão hamburguer para mobile -->
        <div class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>

        <!-- Forma geométrica triangular -->
        <div class="nav-triangle"></div>
    </nav>

    <!-- Menu mobile -->
    <div class="menubar">
        <!-- Logo no mobile -->
        <div class="mobile-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<span class="logo-text">MAXIMA</span>';
                }
                ?>
            </a>
        </div>

        <!-- Menu Mobile (combina ambos os menus) -->
        <?php
        // Array para armazenar todos os itens dos menus
        $mobile_menu_items = array();

        // 1. Obter itens do menu esquerdo se existir
        if (has_nav_menu('maxima_main_menu_left')) {
            $locations = get_nav_menu_locations();
            $left_menu = wp_get_nav_menu_object($locations['maxima_main_menu_left']);

            if ($left_menu) {
                $left_items = wp_get_nav_menu_items($left_menu->term_id);
                if ($left_items) {
                    $mobile_menu_items = array_merge($mobile_menu_items, $left_items);
                }
            }
        }

        // 2. Obter itens do menu direito se existir
        if (has_nav_menu('maxima_main_menu_right')) {
            $locations = get_nav_menu_locations();
            $right_menu = wp_get_nav_menu_object($locations['maxima_main_menu_right']);

            if ($right_menu) {
                $right_items = wp_get_nav_menu_items($right_menu->term_id);
                if ($right_items) {
                    $mobile_menu_items = array_merge($mobile_menu_items, $right_items);
                }
            }
        }

        // 3. Mostrar os menus combinados se houver itens
        if (!empty($mobile_menu_items)) : ?>
            <ul class="mobile-menu">
                <?php foreach ($mobile_menu_items as $item) : ?>
                    <li>
                        <a href="<?php echo esc_url($item->url); ?>"
                            target="<?php echo esc_attr($item->target); ?>"
                            title="<?php echo esc_attr($item->title); ?>">
                            <?php echo esc_html($item->title); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif (has_nav_menu('maxima_main_menu_left')) : ?>
            <!-- Fallback: mostrar apenas menu esquerdo -->
            <?php
            wp_nav_menu(array(
                'theme_location' => 'maxima_main_menu_left',
                'container' => false,
                'menu_class' => 'mobile-menu',
                'items_wrap' => '<ul class="mobile-menu">%3$s</ul>',
                'fallback_cb' => false,
            ));
            ?>
        <?php elseif (has_nav_menu('maxima_main_menu_right')) : ?>
            <!-- Fallback: mostrar apenas menu direito -->
            <?php
            wp_nav_menu(array(
                'theme_location' => 'maxima_main_menu_right',
                'container' => false,
                'menu_class' => 'mobile-menu',
                'items_wrap' => '<ul class="mobile-menu">%3$s</ul>',
                'fallback_cb' => false,
            ));
            ?>
        <?php endif; ?>

        <!-- Contato mobile -->
        <div class="mobile-contact">
            <a href="mailto:contato@maximaemp.com.br" class="mobile-email">
                <i class="fas fa-envelope"></i>
                <span>contato@maximaemp.com.br</span>
            </a>
            <a href="tel:+554430295999" class="mobile-phone">
                <i class="fas fa-phone"></i>
                <span>+55 44 3029-5999</span>
            </a>
        </div>
    </div>