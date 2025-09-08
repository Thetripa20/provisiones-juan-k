<?php

session_start(); // Inicia la sesión para poder destruirla

// Elimina todas las variables de la sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no solo los datos de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión.
session_destroy();

// Redirecciona al usuario a la página de inicio o a la de inicio de sesión
header('Location: ../views/index.php'); // Puedes redirigir a inicio-sesion.php si prefieres
exit();

?>