<form action="../controllers/AuthController.php" method="post">
    <input type="hidden" name="accion" value="iniciar_sesion">

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input
            type="email"
            class="form-control"
            id="email"
            name="email" placeholder="nombre@ejemplo.com"
            required
        />
    </div>

    <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input
            type="password"
            class="form-control"
            id="contrasena"
            name="contrasena" placeholder="Tu contraseña"
            required
        />
    </div>

    <a href="registro.php">Crea tu cuenta</a>

    <div class="d-grid mt-3">
        <button type="submit" class="btn btn-success rounded-pill">
            Iniciar Sesión
        </button>
    </div>
</form>

<?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<div class='alert alert-danger mt-3' role='alert'>";
    if ($error === 'credenciales') {
        echo "Correo o contraseña incorrectos.";
    } else {
        echo "Ha ocurrido un error inesperado. Inténtalo de nuevo.";
    }
    echo "</div>";
}
if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso') {
    echo "<div class='alert alert-success mt-3' role='alert'>¡Registro exitoso! Ya puedes iniciar sesión.</div>";
}
?>