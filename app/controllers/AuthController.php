<?php

session_start(); // ¡Importante! Inicia la sesión al principio de la página
require_once '../models/Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {

    $accion = $_POST['accion'];

    // --- Lógica de Registro (Ya la tienes) ---
    if ($accion === 'registrar') {
        // ... (el código de registro que ya te di) ...
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];

        if (empty($nombre) || empty($email) || empty($contrasena)) {
            header('Location: ../views/registro.php?error=campos_vacios');
            exit();
        }

        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        try {
            $db = new Conexion();
            $conn = $db->getConexion();
            $sql = "INSERT INTO usuarios (nombre, email, contrasena, rol) VALUES (?, ?, ?, 'cliente')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $email, $hashed_password);

            if ($stmt->execute()) {
                header('Location: ../views/inicio-sesion.php?registro=exitoso');
            } else {
                if ($conn->errno == 1062) {
                    header('Location: ../views/registro.php?error=email_duplicado');
                } else {
                    header('Location: ../views/registro.php?error=desconocido');
                }
            }
            $stmt->close();
            $db->cerrarConexion();
        } catch (Exception $e) {
            header('Location: ../views/registro.php?error=conexion');
            exit();
        }
    }

    // --- Lógica de Inicio de Sesión ---
    if ($accion === 'iniciar_sesion') {
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];

        // 1. Validar que los campos no estén vacíos
        if (empty($email) || empty($contrasena)) {
            header('Location: ../views/inicio-sesion.php?error=credenciales');
            exit();
        }

        try {
            // 2. Conectar a la base de datos
            $db = new Conexion();
            $conn = $db->getConexion();
            
            // 3. Buscar el usuario por email
            $sql = "SELECT id, nombre, email, contrasena, rol FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $usuario = $resultado->fetch_assoc();

                // 4. Verificar la contraseña hasheada
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    // 5. Iniciar la sesión si la contraseña es correcta
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_rol'] = $usuario['rol'];
                    
                    // 6. Redireccionar al usuario a la página principal
                    header('Location: ../views/index.php'); // O a donde quieras que vaya
                    exit();
                } else {
                    // Contraseña incorrecta
                    header('Location: ../views/inicio-sesion.php?error=credenciales');
                    exit();
                }
            } else {
                // No se encontró el usuario
                header('Location: ../views/inicio-sesion.php?error=credenciales');
                exit();
            }

            $stmt->close();
            $db->cerrarConexion();

        } catch (Exception $e) {
            header('Location: ../views/inicio-sesion.php?error=conexion');
            exit();
        }
    }
}
?>