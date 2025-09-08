<?php
session_start();
require_once '../models/Conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carnes - Juan-k</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/carnes.css" />
  <link rel="stylesheet" href="../assets/css/carrito.css" />
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

<section class="productos">
  <h2>Carnes</h2>
  <div class="contenedor-productos">
    <?php
    $db = new Conexion();
    $conn = $db->getConexion();
    $sql = "SELECT * FROM productos WHERE categoria = 'Carnes'";
    $resultado = $conn->query($sql);
    
    if ($resultado->num_rows > 0) {
      while($producto = $resultado->fetch_assoc()) {
        $precio_mostrar = $producto['precio'];
        $clase_precio = '';
        $precio_normal_tag = '';

        if ($producto['en_promocion'] && $producto['precio_promocion'] !== null) {
            $precio_mostrar = $producto['precio_promocion'];
            $clase_precio = 'precio-promocion';
            $precio_normal_tag = "<span class='precio-normal'>$" . number_format($producto['precio'], 0, ',', '.') . "</span>";
        }
    ?>
    <div class="producto">
      <img src="../assets/img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
      <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
      <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
      
      <?php if ($producto['en_promocion'] && $producto['precio_promocion'] !== null): ?>
        <p class="etiqueta-promocion">¡Oferta!</p>
      <?php endif; ?>
      
      <label>Cantidad: <span class="cantidad-kilos">1</span> kg</label>
      <input type="range" min="0.5" max="5" step="0.5" value="1" class="form-range" 
             data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
             data-precio="<?php echo htmlspecialchars($producto['precio']); ?>"
             data-precio-promocion="<?php echo htmlspecialchars($producto['precio_promocion']); ?>"
             oninput="actualizarPrecio(this)">
      
      <span class="precio-actual <?php echo $clase_precio; ?>">
        $<?php echo number_format($precio_mostrar, 0, ',', '.'); ?>
      </span>
      <?php echo $precio_normal_tag; ?>
      <br>
      <button class="btn btn-success mt-2" 
              onclick="agregarCarne('<?php echo htmlspecialchars($producto['nombre']); ?>', '<?php echo $precio_mostrar; ?>', this)">
          Agregar al carrito
      </button>
    </div>
    <?php
      }
    } else {
      echo "<p class='text-center'>No hay productos de esta categoría.</p>";
    }
    $db->cerrarConexion();
    ?>
  </div>
</section>

<section class="carrito" id="carrito">
  <h2>Carrito de Compras</h2>
  <div id="carrito-items" class="items"></div>
  <div class="total">
    <strong>Total:</strong> $<span id="carrito-total">0</span>
  </div>
  <button class="btn btn-danger mt-3" onclick="vaciarCarrito()">Vaciar carrito</button>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/carrito.js"></script>
<script>
function actualizarPrecio(rango) {
  const tarjeta = rango.closest(".producto");
  const precioNormal = parseFloat(rango.getAttribute("data-precio"));
  const precioPromocion = parseFloat(rango.getAttribute("data-precio-promocion"));
  const kilos = parseFloat(rango.value);
  const cantidadKilosSpan = tarjeta.querySelector(".cantidad-kilos");
  const precioActualSpan = tarjeta.querySelector(".precio-actual");
  
  cantidadKilosSpan.textContent = kilos;

  let precioCalculado = 0;
  if (!isNaN(precioPromocion) && rango.closest(".producto").querySelector('.etiqueta-promocion')) {
    precioCalculado = precioPromocion * kilos;
  } else {
    precioCalculado = precioNormal * kilos;
  }

  precioActualSpan.textContent = `$${precioCalculado.toLocaleString('es-CO')}`;
}
</script>
</body>
</html>