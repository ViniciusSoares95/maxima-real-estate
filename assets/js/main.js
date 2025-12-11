document.addEventListener('DOMContentLoaded', function() {
    
    // ===== ELEMENTOS =====
    const navbar = document.getElementById('maxima-navbar');
    const hamburger = document.querySelector('.hamburger');
    const menubar = document.querySelector('.menubar');
     
    // ===== TOGGLE MENU MOBILE =====
    if (hamburger && menubar) {
        hamburger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle classes
            menubar.classList.toggle('active');
            hamburger.classList.toggle('hamburger-active');
            
            // Bloquear/liberar scroll do body
            if (menubar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
        
        // ===== FECHAR MENU =====
        
        // 1. Ao clicar em links do menu
        document.querySelectorAll('.menubar a').forEach(link => {
            link.addEventListener('click', () => {
                if (menubar.classList.contains('active')) {
                    menubar.classList.remove('active');
                    hamburger.classList.remove('hamburger-active');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // 2. Ao clicar fora do menu
        document.addEventListener('click', function(e) {
            if (menubar.classList.contains('active')) {
                const isClickInsideMenu = menubar.contains(e.target);
                const isClickOnHamburger = hamburger.contains(e.target);
                
                if (!isClickInsideMenu && !isClickOnHamburger) {
                    menubar.classList.remove('active');
                    hamburger.classList.remove('hamburger-active');
                    document.body.style.overflow = '';
                }
            }
        });
        
        // 3. Com tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menubar.classList.contains('active')) {
                menubar.classList.remove('active');
                hamburger.classList.remove('hamburger-active');
                document.body.style.overflow = '';
            }
        });
        
        // 4. Ao redimensionar para desktop
        function handleResize() {
            if (window.innerWidth > 768 && menubar.classList.contains('active')) {
                menubar.classList.remove('active');
                hamburger.classList.remove('hamburger-active');
                document.body.style.overflow = '';
            }
        }
        
        // Debounce para performance
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        window.addEventListener('resize', debounce(handleResize, 250));
        
    }
    
    // ===== SCROLL EFFECT =====
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Inicializar estado do scroll
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        }
    }
    
    // ===== SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            if (targetId === '#' || targetId === '#!') return;
            
            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                // Fecha menu mobile se estiver aberto
                if (menubar && menubar.classList.contains('active')) {
                    menubar.classList.remove('active');
                    if (hamburger) hamburger.classList.remove('hamburger-active');
                    document.body.style.overflow = '';
                }
                
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                const targetPosition = targetElement.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});