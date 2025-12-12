/**
 * Galeria Interativa - Paginação AJAX
 */
(function($) {
    'use strict';
    
    class MaximaGallery {
        constructor() {
            this.isLoading = false;
            this.init();
        }
        
        init() {
            console.log('Maxima Gallery inicializando...');
            this.setupEvents();
            this.setupLightboxItems();
        }
        
        setupEvents() {
            // Delegar evento para toda a área da paginação
            $(document).on('click', '#galleryPagination a', (e) => {
                this.handlePaginationClick(e);
            });
            
            // Lightbox events
            this.setupLightboxEvents();
        }
        
        handlePaginationClick(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Pagination click intercepted');
            
            if (this.isLoading) {
                return false;
            }
            
            const $link = $(e.currentTarget);
            
            // Ignorar links de página atual e dots
            if ($link.hasClass('current') || $link.hasClass('dots')) {
                return false;
            }
            
            const href = $link.attr('href');
            if (!href || href === '#') {
                return false;
            }
            
            // Extrair número da página da URL
            let pageNumber = 1;
            if (href.includes('paged=')) {
                const match = href.match(/paged=(\d+)/);
                pageNumber = match ? parseInt(match[1]) : 1;
            } else if (href.includes('/page/')) {
                const match = href.match(/\/page\/(\d+)/);
                pageNumber = match ? parseInt(match[1]) : 1;
            }
            
            console.log('Loading page:', pageNumber, 'from href:', href);
            this.loadPage(pageNumber);
            
            return false;
        }
        
        loadPage(page) {
            if (this.isLoading) return;
            
            this.isLoading = true;
            const $section = $('.maxima-gallery-section');
            const $grid = $('#galleryGrid');
            const $pagination = $('#galleryPagination');
            
            // Show loading state
            $section.addClass('loading');
            
            // Get current URL without pagination parameters
            let currentUrl = window.location.href;
            currentUrl = currentUrl.replace(/\?paged=\d+/, '').replace(/&paged=\d+/, '');
            currentUrl = currentUrl.replace(/\/page\/\d+\//, '/');
            
            // AJAX request
            $.ajax({
                url: window.maximaGallery.ajax_url,
                type: 'POST',
                data: {
                    action: 'maxima_load_gallery_page',
                    nonce: window.maximaGallery.nonce,
                    paged: page,
                    current_url: currentUrl
                },
                success: (response) => {
                    console.log('AJAX response:', response);
                    
                    if (response.success) {
                        // Update grid with fade effect
                        $grid.fadeOut(200, () => {
                            $grid.html(response.data.html);
                            $grid.fadeIn(200);
                            
                            // Update pagination
                            $pagination.html(response.data.pagination);
                            
                            // Update browser URL without reload
                            this.updateBrowserUrl(page);
                            
                            // Reload lightbox items
                            this.setupLightboxItems();
                        });
                    } else {
                        console.error('AJAX error:', response.data);
                        // Fallback to normal page load
                        window.location.href = currentUrl + (page > 1 ? `?paged=${page}` : '');
                    }
                },
                error: (xhr, status, error) => {
                    console.error('AJAX request failed:', error);
                    // Fallback to normal page load
                    window.location.href = currentUrl + (page > 1 ? `?paged=${page}` : '');
                },
                complete: () => {
                    this.isLoading = false;
                    $section.removeClass('loading');
                }
            });
        }
        
        updateBrowserUrl(page) {
            const currentUrl = window.location.pathname;
            let newUrl;
            
            if (page > 1) {
                newUrl = currentUrl + `?paged=${page}`;
            } else {
                newUrl = currentUrl;
            }
            
            window.history.pushState({ page: page }, '', newUrl);
        }
        
        setupLightboxEvents() {
            // Abrir lightbox ao clicar em um item
            $(document).on('click', '.gallery-item', (e) => {
                e.preventDefault();
                const $item = $(e.currentTarget);
                const index = $('.gallery-item').index($item);
                this.openLightbox(index);
            });
            
            // Fechar lightbox
            $(document).on('click', '#lightboxClose, #galleryLightbox', (e) => {
                if (e.target.id === 'lightboxClose' || e.target.id === 'galleryLightbox') {
                    this.closeLightbox();
                }
            });
            
            // Navegação do lightbox
            $(document).on('click', '#lightboxNext', () => this.nextImage());
            $(document).on('click', '#lightboxPrev', () => this.prevImage());
            
            // Teclado
            $(document).on('keydown', (e) => {
                if (!$('#galleryLightbox').hasClass('active')) return;
                
                switch(e.key) {
                    case 'Escape':
                        this.closeLightbox();
                        break;
                    case 'ArrowRight':
                        this.nextImage();
                        break;
                    case 'ArrowLeft':
                        this.prevImage();
                        break;
                }
            });
        }
        
        setupLightboxItems() {
            this.lightboxItems = [];
            $('.gallery-item').each((index, element) => {
                const $item = $(element);
                const $image = $item.find('img');
                
                this.lightboxItems.push({
                    id: $item.data('id'),
                    title: $item.find('.gallery-item-title').text(),
                    details: $item.find('.gallery-item-details').text(),
                    image: $image.attr('src') || '',
                    largeImage: $image.data('large') || $image.attr('src'), // Usa imagem grande se disponível
                    index: index
                });
            });
            this.currentLightboxIndex = 0;
        }
        
        openLightbox(index) {
            if (!this.lightboxItems || this.lightboxItems.length === 0) {
                this.setupLightboxItems();
            }
            
            this.currentLightboxIndex = index;
            const item = this.lightboxItems[index];
            
            if (!item) return;
            
            // Mostrar imagem de baixa resolução primeiro
            $('#lightboxImage').attr('src', item.image).attr('alt', item.title);
            
            // Carregar imagem grande em background se disponível
            if (item.largeImage && item.largeImage !== item.image) {
                const img = new Image();
                img.onload = () => {
                    $('#lightboxImage').attr('src', item.largeImage);
                };
                img.src = item.largeImage;
            }
            
            $('#lightboxTitle').text(item.title);
            $('#lightboxDescription').text(item.details);
            $('#lightboxCounter').text((index + 1) + ' / ' + this.lightboxItems.length);
            
            $('#galleryLightbox').addClass('active');
            $('body').css('overflow', 'hidden');
        }
        
        closeLightbox() {
            $('#galleryLightbox').removeClass('active');
            $('body').css('overflow', '');
        }
        
        nextImage() {
            this.currentLightboxIndex = (this.currentLightboxIndex + 1) % this.lightboxItems.length;
            this.updateLightboxContent();
        }
        
        prevImage() {
            this.currentLightboxIndex = (this.currentLightboxIndex - 1 + this.lightboxItems.length) % this.lightboxItems.length;
            this.updateLightboxContent();
        }
        
        updateLightboxContent() {
            const item = this.lightboxItems[this.currentLightboxIndex];
            
            // Mostrar imagem de baixa resolução primeiro
            $('#lightboxImage').attr('src', item.image).attr('alt', item.title);
            
            // Carregar imagem grande em background se disponível
            if (item.largeImage && item.largeImage !== item.image) {
                const img = new Image();
                img.onload = () => {
                    $('#lightboxImage').attr('src', item.largeImage);
                };
                img.src = item.largeImage;
            }
            
            $('#lightboxTitle').text(item.title);
            $('#lightboxDescription').text(item.details);
            $('#lightboxCounter').text((this.currentLightboxIndex + 1) + ' / ' + this.lightboxItems.length);
        }
    }
    
    // Initialize when DOM is ready
    $(document).ready(() => {
        console.log('DOM ready, initializing Maxima Gallery...');
        window.maximaGalleryInstance = new MaximaGallery();
    });
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.page && window.maximaGalleryInstance) {
            window.maximaGalleryInstance.loadPage(event.state.page);
        }
    });
    
})(jQuery);

// Global prevention - final safety net
$(document).on('click', '.gallery-pagination a', function(e) {
    e.preventDefault();
    return false;
});