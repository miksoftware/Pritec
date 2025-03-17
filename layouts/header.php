<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['usuario'])) {
  header('Location: ../pritec/login.php');
  exit();
}

$menu_items = [
  ['icon' => 'fa-home', 'text' => 'Dashboard', 'link' => '#'],
  ['icon' => 'fa-file-lines', 'text' => 'Peritaje Basico', 'link' => 'L_peritajeB.php'],
  ['icon' => 'fa-file-lines', 'text' => 'Peritaje Completo', 'link' => 'L_peritajeC.php'],
  ['icon' => 'fa-print', 'text' => 'Impresion en Blanco', 'link' => 'P_peritajesBlanks.php'],
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>

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
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      min-height: 100vh;
      overflow: hidden;
    }

    #sidebar {
      width: 250px;
      height: 100vh;
      background-color: rgb(0, 0, 0);
      color: white;
      transition: all 0.3s;
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
    }

    #sidebar.collapsed {
      width: 60px;
    }

    #sidebar .logo {
      padding: 15px;
      background-color: rgb(12, 12, 12);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    #sidebar.collapsed .logo {
      justify-content: center;
      padding: 15px 0;
    }

    #toggle-btn {
      background-color: transparent;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 20px;
      padding: 5px 10px;
      transition: 0.3s;
    }

    #toggle-btn:hover {
      color: #ccc;
    }

    #sidebar ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      overflow-y: auto;
      max-height: calc(100vh - 60px);
    }

    #sidebar ul li {
      padding: 10px 15px;
      transition: 0.3s;
    }

    #sidebar ul li:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    #sidebar ul li a {
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    #sidebar ul li a i {
      width: 20px;
      text-align: center;
    }

    #sidebar.collapsed .menu-text,
    #sidebar.collapsed ul li a span {
      display: none;
    }

    #content {
      flex-grow: 1;
      padding: 20px;
      margin-left: 250px;
      height: 100vh;
      overflow-y: auto;
      background-color: rgb(255, 255, 255);
      transition: all 0.3s;
    }

    #sidebar.collapsed+#content {
      margin-left: 60px;
    }

    .card {
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #f8f9fa;
      font-weight: bold;
    }

    .form-label {
      font-weight: 500;
    }

    #content .container {
      max-width: 1200px;
      margin: 0 auto;
    }
  </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
  <div id="sidebar">
    <div class="logo">
      <span class="menu-text">PRITEC</span>
      <button id="toggle-btn"><i class="fas fa-bars"></i></button>
    </div>
    <ul>
      <?php foreach ($menu_items as $item): ?>
        <li>
          <a href="<?php echo $item['link']; ?>">
            <i class="fas <?php echo $item['icon']; ?>"></i>
            <span><?php echo $item['text']; ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
