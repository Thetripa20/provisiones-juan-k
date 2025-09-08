<form action="../controllers/AuthController.php" method="post">
    <input type="hidden" name="accion" value="registrar">
    
    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required/>
    </div>
    
    <div class="mb-3">
        <label for="nombre" class="form-label">Tu nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required/>
    </div>
    
    <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required/>
    </div>
    
    <div class="d-grid mt-3">
        <button type="submit" class="btn btn-success rounded-pill">Aceptar</button>
    </div>
</form>

<?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<div class='alert alert-danger mt-3' role='alert'>";
    if ($error === 'campos_vacios') {
        echo "Todos los campos son obligatorios.";
    } elseif ($error === 'email_duplicado') {
        echo "Este correo electrónico ya está registrado.";
    } else {
        echo "Ha ocurrido un error inesperado. Inténtalo de nuevo.";
    }
    echo "</div>";
}
?>