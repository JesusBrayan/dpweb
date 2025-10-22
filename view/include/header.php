<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>view/bootstrap/css/bootstrap.min.css">
    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <!--ESTILO DE PAGINA -->
<style>
    /* ======== CONFIGURACIÓN GLOBAL ======== */
    body {
        background: 
            linear-gradient(rgba(0, 0, 0, 0.6), rgba(5, 20, 35, 0.8)),
            url('https://xmple.com/wallpaper/honeycomb-black-blue-hexagon-beehive-2240x1080-c2-000000-00ced1-l2-1-60-a-40-f-5.svg'); /* Fondo moderno celeste */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: 'Poppins', sans-serif;
        color: #e9f6ff;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* ======== NAVBAR ======== */
    .navbar {
        background: rgba(10, 35, 60, 0.8) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 25px rgba(0, 180, 255, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar-brand.styled-logo {
        font-size: 2.1rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: #b8e6ff !important;
        text-shadow: 0 0 10px rgba(0, 200, 255, 0.3);
        transition: all 0.3s ease;
    }

    .navbar-brand.styled-logo:hover {
        color: #66d1ff !important;
        text-shadow: 0 0 20px #66d1ff;
        transform: scale(1.05);
    }

    .nav-link {
        color: #e0f7ff !important;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: color 0.3s, text-shadow 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
        color: #7edcff !important;
        text-shadow: 0 0 8px #7edcff;
    }

    /* ======== TÍTULO ======== */
    .titulo-usuarios {
        background: rgba(25, 60, 90, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 
            inset 0 0 8px rgba(255, 255, 255, 0.05),
            0 4px 25px rgba(0, 150, 255, 0.3);
        color: #c8eeff !important;
        font-size: 2.2rem;
        font-weight: 600;
        letter-spacing: 1px;
        border-radius: 14px;
        padding: 1em 2em;
        margin: 1.5em auto;
        text-align: center;
        display: inline-block;
        position: relative;
        backdrop-filter: blur(8px);
    }

    .titulo-usuarios::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 50%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #66d1ff, transparent);
        transform: translateX(-50%);
    }

    /* ======== TABLAS ======== */
    .table {
        background: rgba(15, 40, 65, 0.8);
        border-radius: 14px;
        overflow: hidden;
        color: #e0f7ff;
        box-shadow: 0 4px 20px rgba(0, 180, 255, 0.25);
        backdrop-filter: blur(10px);
    }

    .table th {
        background: rgba(30, 80, 120, 0.9);
        color: #ffffff;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(0, 200, 255, 0.3);
    }

    .table td {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding: 0.8em;
        vertical-align: middle;
        text-align: center;
    }

    .table tr:hover td {
        background: rgba(0, 200, 255, 0.08);
        color: #b9efff;
        transition: all 0.3s;
    }

    /* ======== DROPDOWN ======== */
    .dropdown-menu {
        background: rgba(25, 50, 80, 0.95);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 20px rgba(0, 180, 255, 0.2);
    }

    .dropdown-item {
        color: #e0f7ff;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
    }

    .dropdown-item:hover {
        background: rgba(0, 180, 255, 0.15);
        color: #7edcff;
    }

    /* ======== CARD HEADER ======== */
    .card-header {
        background: rgba(25, 60, 90, 0.85);
        color: #c8eeff;
        font-weight: 600;
        border-bottom: 2px solid rgba(0, 200, 255, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        backdrop-filter: blur(8px);
    }

    /* ======== EFECTOS GLOBALES ======== */
    ::selection {
        background: #66d1ff;
        color: #000;
    }

    a {
        text-decoration: none;
        color: #66d1ff;
        transition: color 0.3s;
    }

    a:hover {
        color: #9de9ff;
    }
</style>


    <!--ESTILO DE PAGINA -->



    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand styled-logo" href="#">JB</a> <!-- vuelve al login-->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>new-user">Registrar</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>users">Usuarios</a>
                    </li>
   <!--edit producto 
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>edit-producto">edit-producto</a>
                    </li>-->

                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>producto">productos</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>categoria">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>clients">Clientes</a>
                    </li>

                    <!--<li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>new-client">Registrar clientes</a>
                    </li>-->


                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>proveedor">Proveedores</a>
                    </li>

                    <!--<li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>new-proveedor">Registrar proveedores</a>
                    </li>-->


                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>shops">Shops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>sales">Sales</a>
                    </li>

                </ul>
                <form class="d-flex" role="search">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>login">Cerrar</a></li>
                            </ul>


                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </nav>
    