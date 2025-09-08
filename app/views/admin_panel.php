<?php
session_start();
// Redireccionar si el usuario no es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php'); // Redirecciona a la página de inicio
    exit();
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Panel de Administración</h1>
        <div class="d-flex justify-content-between mb-4">
            <a href="index.php" class="btn btn-secondary">Ir al Sitio Público</a>
            <a href="../controllers/LogoutController.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
        
        <div class="card p-4">
            <h2 class="mb-3">Gestión de Productos</h2>
            <div class="mb-4">
                <a href="agregar_producto.php" class="btn btn-primary">Agregar Nuevo Producto</a>
            </div>
            
            <h3 class="mt-4">Lista de Productos</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../models/Conexion.php';
                    $db = new Conexion();
                    $conn = $db->getConexion();
                    $sql = "SELECT id, nombre, precio, stock FROM productos";
                    $resultado = $conn->query($sql);
                    
                    if ($resultado->num_rows > 0) {
                        while($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $fila['id'] . "</td>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo "<td>$" . number_format($fila['precio'], 0, ',', '.') . "</td>";
                            echo "<td>" . $fila['stock'] . "</td>";
                            echo "<td>";
                            echo "<a href='editar_producto.php?id=" . $fila['id'] . "' class='btn btn-warning btn-sm'>Editar</a> ";
                            echo "<a href='../controllers/AdminController.php?accion=eliminar&id=" . $fila['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este producto?\")'>Eliminar</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay productos registrados.</td></tr>";
                    }
                    $db->cerrarConexion();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>