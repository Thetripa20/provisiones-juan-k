<?php
session_start();
require_once '../models/Conexion.php';

// Redireccionar si no es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../views/index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    // Lógica para agregar un producto
    if ($accion === 'agregar') {
        // ... (Tu código de agregar producto ya está aquí) ...
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['imagen'];

        $db = new Conexion();
        $conn = $db->getConexion();
        
        $sql = "INSERT INTO productos (nombre, precio, stock, categoria, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdisss", $nombre, $precio, $stock, $categoria, $descripcion, $imagen);

        if ($stmt->execute()) {
            header('Location: ../views/admin_panel.php?exito=producto_agregado');
        } else {
            header('Location: ../views/agregar_producto.php?error=db_error');
        }

        $stmt->close();
        $db->cerrarConexion();
    }

    // --- LÓGICA PARA EDITAR UN PRODUCTO ---
    if ($accion === 'editar') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['imagen'];

        // Conectar a la base de datos
        $db = new Conexion();
        $conn = $db->getConexion();

        $sql = "UPDATE productos SET nombre = ?, precio = ?, stock = ?, categoria = ?, descripcion = ?, imagen = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdisssi", $nombre, $precio, $stock, $categoria, $descripcion, $imagen, $id);

        if ($stmt->execute()) {
            header('Location: ../views/admin_panel.php?exito=producto_actualizado');
        } else {
            header('Location: ../views/editar_producto.php?id=' . $id . '&error=db_error');
        }

        $stmt->close();
        $db->cerrarConexion();
    }

} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    // Lógica para eliminar un producto
    if ($accion === 'eliminar' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $db = new Conexion();
        $conn = $db->getConexion();
        
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: ../views/admin_panel.php?exito=producto_eliminado');
        } else {
            header('Location: ../views/admin_panel.php?error=db_error');
        }

        $stmt->close();
        $db->cerrarConexion();
    }
}
?>