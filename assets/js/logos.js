/**
 * Carrossel de Logos - MAXIMA Real Estate
 */
(function($) {
    'use strict';
    
    class MaximaLogosCarousel {
        constructor() {
            console.log('Maxima Logos Carousel constructor');
            this.init();
        }
        
        init() {
            console.log('Inicializando carrossel de logos...');
            
            // Verifica se há tracks na página
            if ($('.logos-track').length > 0) {
                this.initializeAllTracks();
                this.setupHoverPause();
                console.log('Carrossel inicializado com sucesso');
            } else {
                console.log('Nenhum track de logos encontrado na página');
            }
        }
        
        initializeAllTracks() {
            $('.logos-track').each((index, element) => {
                const $track = $(element);
                const isReverse = $track.hasClass('reverse');
                
                console.log(`Inicializando track ${index + 1} (${isReverse ? 'reverse' : 'normal'})`);
                
                // Não re-inicializa se já foi feito
                if ($track.data('initialized')) {
                    console.log(`Track ${index + 1} já inicializado`);
                    return;
                }
                
                // Obtém os logos do HTML
                const logos = this.getLogosFromTrack($track);
                
                if (logos.length === 0) {
                    console.warn(`Track ${index + 1} não tem logos`);
                    return;
                }
                
                console.log(`Track ${index + 1} tem ${logos.length} logos`);
                
                // Duplica os logos para efeito infinito
                this.duplicateLogosInTrack($track, logos);
                
                // Marca como inicializado
                $track.data('initialized', true);
                
                // Garante que a animação esteja rodando
                $track.css('animation-play-state', 'running');
            });
        }
        
        getLogosFromTrack($track) {
            const logos = [];
            
            $track.find('.logo-item').each(function() {
                const $item = $(this);
                const $img = $item.find('img');
                const $link = $item.find('a');
                
                const logo = {
                    html: $item.html(),
                    hasLink: $link.length > 0,
                    src: $img.attr('src'),
                    alt: $img.attr('alt') || '',
                    title: $img.attr('title') || ''
                };
                
                logos.push(logo);
            });
            
            return logos;
        }
        
        duplicateLogosInTrack($track, logos) {
            // Primeiro, limpa o track (remove duplicações anteriores se houver)
            const originalLogos = $track.find('.logo-item').clone();
            $track.empty();
            
            // Adiciona os logos originais de volta
            originalLogos.each(function() {
                $track.append($(this));
            });
            
            // Adiciona uma cópia dos logos para criar o efeito infinito
            originalLogos.each(function() {
                $track.append($(this).clone(true));
            });
            
            // Ajusta a largura do track baseado no número de logos
            const totalLogos = originalLogos.length * 2;
            const logoWidth = 400; // Largura base do logo-item
            const gap = 40; // gap entre logos
            const totalWidth = (totalLogos * (logoWidth + gap)) - gap;
            
            $track.css('width', totalWidth + 'px');
            
            console.log(`Track configurado com ${totalLogos} logos (${originalLogos.length} originais * 2), largura: ${totalWidth}px`);
        }
        
        setupHoverPause() {
            $('.logos-carousel-wrapper').hover(
                function() {
                    $(this).find('.logos-track').css('animation-play-state', 'paused');
                    console.log('Carrossel pausado');
                },
                function() {
                    $(this).find('.logos-track').css('animation-play-state', 'running');
                    console.log('Carrossel retomado');
                }
            );
        }
    }
    
    // Initialize when DOM is ready
    $(document).ready(() => {
        console.log('DOM ready, inicializando Maxima Logos Carousel...');
        window.maximaLogosCarousel = new MaximaLogosCarousel();
    });
    
})(jQuery);