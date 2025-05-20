<?php
// filepath: c:\laragon\www\Pritec\layouts\header.php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario'])) {
  header('Location: ../pritec/index.php');
  exit();
}

$menu_items = [
  ['icon' => 'fa-home', 'text' => 'Dashboard', 'link' => 'dashboard.php'],
  ['icon' => 'fa-file-lines', 'text' => 'Peritaje Básico', 'link' => 'l_peritajeB.php'],
  ['icon' => 'fa-file-lines', 'text' => 'Peritaje Completo', 'link' => 'l_peritajeC.php'],
  ['icon' => 'fa-print', 'text' => 'Impresión en Blanco', 'link' => 'p_peritajesBlanks.php'],
  ['icon' => 'fa-users', 'text' => 'Usuarios', 'link' => 'usuarios.php'],
];

// Obtener nombre del usuario para mostrar
$nombreUsuario = $_SESSION['nombre_completo'] ?? $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PRITEC - Panel de Administración</title>

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">

  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
      --sidebar-width: 250px;
      --sidebar-collapsed-width: 60px;
      --sidebar-bg: #121212;
      --sidebar-header-bg: #0a0a0a;
      --sidebar-hover: rgba(255, 255, 255, 0.1);
      --primary-color: #3f51b5;
      --primary-hover: #303f9f;
      --transition-speed: 0.3s;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      min-height: 100vh;
      overflow: hidden;
      background-color: #f8f9fa;
    }

    #sidebar {
      width: var(--sidebar-width);
      height: 100vh;
      background-color: var(--sidebar-bg);
      color: white;
      transition: width var(--transition-speed) ease-in-out;
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      display: flex;
      flex-direction: column;
    }

    #sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }

    #sidebar .logo {
      padding: 15px;
      background-color: var(--sidebar-header-bg);
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 60px;
    }

    #sidebar.collapsed .logo {
      justify-content: center;
      padding: 15px 0;
    }

    #sidebar .logo img {
      height: 30px;
      width: auto;
    }

    #toggle-btn {
      background-color: transparent;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 20px;
      padding: 5px 10px;
      transition: var(--transition-speed);
    }

    #toggle-btn:hover {
      color: #ccc;
    }

    #sidebar-content {
      display: flex;
      flex-direction: column;
      height: calc(100% - 60px);
      overflow-y: auto;
    }

    #sidebar ul.nav-menu {
      list-style-type: none;
      padding: 0;
      margin: 0;
      flex-grow: 1;
    }

    #sidebar ul.user-menu {
      list-style-type: none;
      padding: 0;
      margin: 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    #sidebar ul li {
      padding: 0;
      transition: var(--transition-speed);
    }

    #sidebar ul li:hover {
      background-color: var(--sidebar-hover);
    }

    #sidebar ul li.active {
      border-left: 3px solid var(--primary-color);
      background-color: rgba(255, 255, 255, 0.05);
    }

    #sidebar ul li a {
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
      padding: 12px 15px;
      gap: 10px;
    }

    #sidebar ul li a i {
      width: 20px;
      text-align: center;
    }

    #sidebar.collapsed .menu-text,
    #sidebar.collapsed ul li a span,
    #sidebar.collapsed .user-info {
      display: none;
    }

    #sidebar .user-profile {
      padding: 10px 15px;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: var(--transition-speed);
    }

    #sidebar .user-profile:hover {
      background-color: var(--sidebar-hover);
    }

    #sidebar .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background-color: var(--primary-color);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 500;
    }

    #sidebar .user-info {
      flex-grow: 1;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    #sidebar.collapsed .user-profile {
      justify-content: center;
      padding: 10px 0;
    }

    #content {
      flex-grow: 1;
      padding: 20px;
      margin-left: var(--sidebar-width);
      height: 100vh;
      overflow-y: auto;
      transition: margin-left var(--transition-speed) ease-in-out;
    }

    #sidebar.collapsed+#content {
      margin-left: var(--sidebar-collapsed-width);
    }

    .card {
      margin-bottom: 20px;
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #f8f9fa;
      font-weight: 500;
      padding: 15px 20px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      border-radius: 8px 8px 0 0 !important;
    }

    .form-label {
      font-weight: 500;
    }

    #content .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .btn-logout {
      color: #ff6b6b;
    }
    
    .user-name {
      font-weight: 500;
      font-size: 14px;
      margin: 0;
    }
    
    .user-role {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.6);
      margin: 0;
    }

    /* Responsive styles */
    @media (max-width: 991px) {
      #sidebar {
        transform: translateX(-100%);
        position: fixed;
      }
      
      #sidebar.active {
        transform: translateX(0);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      }
      
      #content {
        margin-left: 0;
        width: 100%;
      }
      
      #mobile-toggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        border: none;
        z-index: 1001;
        transition: all var(--transition-speed);
      }
      
      #mobile-toggle:hover {
        background-color: var(--primary-hover);
        transform: scale(1.05);
      }
      
      #mobile-toggle:focus {
        outline: none;
      }
    }
    
    @media (min-width: 992px) {
      #mobile-toggle {
        display: none;
      }
    }

    /* Loader para transiciones de página */
    .page-loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      visibility: hidden;
      opacity: 0;
      transition: visibility 0s 0.3s, opacity 0.3s linear;
    }

    .page-loader.active {
      visibility: visible;
      opacity: 1;
      transition: opacity 0.3s linear;
    }
    
    .loader {
      border: 5px solid #f3f3f3;
      border-radius: 50%;
      border-top: 5px solid var(--primary-color);
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>

<body>
  <!-- Loader para transiciones de página -->
  <div class="page-loader">
    <div class="loader"></div>
  </div>

  <!-- Sidebar navigation -->
  <div id="sidebar">
    <div class="logo">
      <span class="menu-text">PRITEC</span>
      <button id="toggle-btn" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    
    <div id="sidebar-content">
      <!-- Main navigation -->
      <ul class="nav-menu">
        <?php 
        // Obtener la página actual para resaltar el menú activo
        $current_page = basename($_SERVER['PHP_SELF']);
        
        foreach ($menu_items as $item): 
          $is_active = ($current_page === $item['link']) ? 'active' : '';
        ?>
          <li class="<?php echo $is_active; ?>">
            <a href="<?php echo $item['link']; ?>">
              <i class="fas <?php echo $item['icon']; ?>"></i>
              <span><?php echo $item['text']; ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      
      <!-- User profile and logout -->
      <ul class="user-menu">
        <li>
          <div class="user-profile">
            <div class="user-avatar">
              <?php echo strtoupper(substr($nombreUsuario, 0, 1)); ?>
            </div>
            <div class="user-info">
              <p class="user-name"><?php echo htmlspecialchars($nombreUsuario); ?></p>
              <p class="user-role">Usuario</p>
            </div>
          </div>
        </li>
        <li>
          <a href="javascript:void(0)" id="btnLogout" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Cerrar Sesión</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
  
  <!-- Mobile toggle button -->
  <button id="mobile-toggle" aria-label="Show menu">
    <i class="fas fa-bars"></i>
  </button>

  <script>
    // Event Dispatcher para sincronización de componentes
    const eventDispatcher = {
      dispatch: function(event) {
        document.dispatchEvent(new CustomEvent(event));
      }
    };
  
    // Toggle sidebar con función actualizada
    document.getElementById('toggle-btn').addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
      
      // Guardar preferencia en localStorage
      localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
      
      // Notificar a otros componentes sobre el cambio
      setTimeout(function() {
        eventDispatcher.dispatch('sidebar-toggled');
      }, 50);
    });
    
    // Mobile sidebar toggle
    document.getElementById('mobile-toggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('active');
      
      // Cambiar el icono
      const icon = this.querySelector('i');
      if (document.getElementById('sidebar').classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
      } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
      
      // Notificar a otros componentes
      eventDispatcher.dispatch('sidebar-mobile-toggled');
    });
    
    // Función para actualizar la posición del contenido y footer
    function updateLayoutOnToggle() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      const footer = document.querySelector('.footer');
      
      if (sidebar.classList.contains('collapsed')) {
        content.style.marginLeft = 'var(--sidebar-collapsed-width)';
        if (footer) {
          footer.style.width = 'calc(100% - var(--sidebar-collapsed-width))';
          footer.style.marginLeft = 'var(--sidebar-collapsed-width)';
        }
      } else {
        content.style.marginLeft = 'var(--sidebar-width)';
        if (footer) {
          footer.style.width = 'calc(100% - var(--sidebar-width))';
          footer.style.marginLeft = 'var(--sidebar-width)';
        }
      }
    }
    
    // Inicialización y configuración al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      // Restaurar estado del sidebar desde localStorage
      const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (sidebarCollapsed) {
        document.getElementById('sidebar').classList.add('collapsed');
        
        // Asegurarse de que el layout esté actualizado inmediatamente
        setTimeout(updateLayoutOnToggle, 0);
      }
      
      // Cerrar el menú en móviles al hacer clic en un elemento
      const navLinks = document.querySelectorAll('.nav-menu a');
      navLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (window.innerWidth < 992) {
            document.getElementById('sidebar').classList.remove('active');
            const icon = document.querySelector('#mobile-toggle i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
          }
        });
      });
      
      // Escuchar eventos de cambio de sidebar
      document.addEventListener('sidebar-toggled', updateLayoutOnToggle);
    });
    
    // Logout functionality
    document.getElementById('btnLogout').addEventListener('click', function() {
      Swal.fire({
        title: '¿Cerrar sesión?',
        text: "¿Estás seguro que deseas cerrar sesión?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3f51b5',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          // Mostrar loader
          document.querySelector('.page-loader').classList.add('active');
          
          // Redirigir al logout
          window.location.href = 'logout.php';
        }
      });
    });
    
    // Mostrar loader al cambiar de página
    document.addEventListener('DOMContentLoaded', function() {
      const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="javascript"])');
      links.forEach(link => {
        link.addEventListener('click', function(e) {
          // No activar para links con preventDefault o que abren modales
          if (link.getAttribute('data-bs-toggle') === 'modal') {
            return;
          }
          
          document.querySelector('.page-loader').classList.add('active');
        });
      });
    });
  </script>