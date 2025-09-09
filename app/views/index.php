<?php
// Inicia la sesión de PHP. Esto es necesario para acceder a las variables de sesión que guardan la información del usuario (como si ha iniciado sesión o no).
session_start();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Provisiones Juan-k</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar color-fondo text-light fixed-top" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../assets/img/logo provisiones juan-k.jpg" alt="Logo" class="logo" />
                <span style="color: #fff;">Provisiones Juan-k</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menú</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="carnes.php">Carnes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="electrodomesticos.php">Electrodomésticos</a>
                        </li>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/LogoutController.php">Cerrar Sesión</a>
                            </li>
                            <?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin_panel.php">Panel Admin</a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="inicio-sesion.php">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="registro.php">Registrarse</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

<section class="inicio-hero">
        <div class="container text-center">
            <h1>Bienvenidos al supermercado mayorista Provisiones-Juan-k</h1>
            <p>Donde podrá encontrar grandes ofertas en productos de calidad.</p>
            <a href="carnes.php" class="btn btn-primary btn-lg">Ver Ofertas</a>
        </div>
    </section>

    <section class="marcas-aliadas py-5 text-center">
        <div class="container">
            <h2>Nuestras Marcas Aliadas</h2>
            <div class="d-flex justify-content-around flex-wrap mt-4">
                <img src="../assets/img/alpina.png" alt="Alpina" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/postobon.png" alt="Postobon" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/colombina.png" alt="Colombina" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/incel.png" alt="Incel" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/zenu.png" alt="Zenu" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/italmo.png" alt="Italmo" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/doria.png" alt="Doria" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/bimbo.png" alt="Bimbo" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/cocacola.png" alt="Coca-Cola" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/ariel.png" alt="Ariel" class="img-fluid m-2" style="max-height: 60px;">
                <img src="../assets/img/colgate.png" alt="Colgate" class="img-fluid m-2" style="max-height: 60px;">
            </div>
        </div>
    </section>

<footer class="bg-dark text-light text-center py-3 mt-5">
        <p>&copy; <?php echo date("Y"); ?> Provisiones Juan-k. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>