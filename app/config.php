<?php
define('SERVIDOR', 'localhost');
define('USUARIO', 'root');
define('CONTRASENA', '');
define('DB', 'provisiones-juan-k');

$servidor = "mysql:host=" . SERVIDOR . ";dbname=" . DB;

try {
    $pdo = new PDO($servidor, USUARIO, CONTRASENA, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
    echo "✅ Conexión a la base de datos exitosa";
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>
