<?php
session_start();
// Proteger la página
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once '../models/Conexion.php';

$producto = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Conectar a la base de datos y obtener los datos del producto
    $db = new Conexion();
    $conn = $db->getConexion();
    
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows === 1) {
        $producto = $resultado->fetch_assoc();
    }
    
    $stmt->close();
    $db->cerrarConexion();
}

if ($producto === null) {
    // Si no se encontró el producto, redirigir
    header('Location: admin_panel.php');
    exit();
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Producto</h1>
        <div class="card p-4">
            <form action="../controllers/AdminController.php" method="post">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Nombre de Archivo de Imagen</label>
                    <input type="text" class="form-control" id="imagen" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>">
                    <small class="form-text text-muted">Ejemplo: `mi_producto.jpg`</small>
                </div>
                <button type="submit" class="btn btn-warning">Actualizar Producto</button>
                <a href="admin_panel.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>