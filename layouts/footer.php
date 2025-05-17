<?php
// filepath: c:\laragon\www\Pritec\layouts\footer.php
$year = date('Y');
?>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?php echo $year; ?> Pritec. Todos los derechos reservados.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">
                    Desarrollado por 
                    <a href="https://miksoftware.com/" target="_blank" class="text-white text-decoration-none">
                        MikSoftware
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: var(--sidebar-bg, #121212);
        color: #ffffff;
        text-align: center;
        padding: 1rem 0;
        position: fixed;
        bottom: 0;
        width: calc(100% - var(--sidebar-width, 250px));
        margin-left: var(--sidebar-width, 250px);
        z-index: 1000;
        transition: all var(--transition-speed, 0.3s) ease-in-out;
        font-size: 14px;
    }

    .footer-content {
        padding: 0 15px;
    }

    .footer i {
        color: #ff6b6b;
        margin: 0 3px;
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    #content {
        padding-bottom: 60px;
    }
    
    /* Responsive styles */
    @media (max-width: 991px) {
        .footer {
            width: 100% !important;
            margin-left: 0 !important;
        }
    }
    
    @media (max-width: 767px) {
        .footer {
            padding: 0.75rem 0;
        }
        
        .footer p {
            font-size: 12px;
        }
    }
</style>

<script>
    // Esta función se ejecuta al finalizar la carga del DOM
    document.addEventListener('DOMContentLoaded', function() {
        // Función para ajustar el footer
        function adjustFooter() {
            const contentElement = document.getElementById('content');
            const footerElement = document.querySelector('.footer');
            const sidebarElement = document.getElementById('sidebar');
            
            if (!contentElement || !footerElement) return;
            
            const contentHeight = contentElement.scrollHeight;
            const windowHeight = window.innerHeight;
            const footerHeight = footerElement.offsetHeight;
            
            // Posición del footer basada en el contenido
            if (contentHeight < windowHeight - footerHeight) {
                footerElement.style.position = 'static';
                contentElement.style.paddingBottom = '10px';
            } else {
                footerElement.style.position = 'fixed';
                contentElement.style.paddingBottom = (footerHeight + 10) + 'px';
            }
            
            // Ancho y margen basados en el sidebar
            if (window.innerWidth >= 992) { // Solo en desktop
                if (sidebarElement && sidebarElement.classList.contains('collapsed')) {
                    footerElement.style.width = 'calc(100% - var(--sidebar-collapsed-width))';
                    footerElement.style.marginLeft = 'var(--sidebar-collapsed-width)';
                } else {
                    footerElement.style.width = 'calc(100% - var(--sidebar-width))';
                    footerElement.style.marginLeft = 'var(--sidebar-width)';
                }
            }
        }
        
        // Aplicar los ajustes iniciales
        setTimeout(adjustFooter, 100);
        
        // Ajustar en eventos relevantes
        window.addEventListener('resize', adjustFooter);
        document.addEventListener('sidebar-toggled', adjustFooter);
        document.addEventListener('sidebar-mobile-toggled', adjustFooter);
        
        // Observer para cambios en el contenido
        if (document.getElementById('content')) {
            const observer = new MutationObserver(function(mutations) {
                adjustFooter();
            });
            
            observer.observe(document.getElementById('content'), { 
                childList: true, 
                subtree: true,
                attributes: true,
                characterData: true
            });
        }
    });
</script>

</body>
</html>