<?php
session_start();
// Proteger la página
if (!isset($_SESSION['usuario_id'])) {
    header('Location: inicio-sesion.php');
    exit();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finalizar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Finalizar Pedido</h1>
        <div class="card p-4">
            <h2 class="mb-3">Información de Envío</h2>
            <form action="../controllers/PedidoController.php" method="post" id="form-pedido">
                
                <div class="mb-3">
                    <label for="nombre_cliente" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
                <div class="mb-3">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                </div>

                <h3 class="mt-4">Resumen del Pedido</h3>
                <div id="resumen-carrito" class="mb-3">
                    </div>
                
                <p class="h4">Total a Pagar: $<span id="total-pedido">0</span></p>

                <input type="hidden" name="carrito_json" id="carrito_json">
                
                <button type="submit" class="btn btn-success">Confirmar Pedido</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
            const resumenDiv = document.getElementById('resumen-carrito');
            const totalSpan = document.getElementById('total-pedido');
            const carritoInput = document.getElementById('carrito_json');

            let total = 0;
            resumenDiv.innerHTML = '';

            if (carrito.length === 0) {
                resumenDiv.innerHTML = '<p class="text-danger">Tu carrito está vacío.</p>';
            } else {
                carrito.forEach(item => {
                    const subtotal = item.precio * item.cantidad;
                    total += subtotal;
                    const p = document.createElement('p');
                    p.innerHTML = `${item.nombre} x ${item.cantidad} Kg - $${subtotal.toLocaleString('es-CO')}`;
                    resumenDiv.appendChild(p);
                });
            }

            totalSpan.textContent = total.toLocaleString('es-CO');
            carritoInput.value = JSON.stringify(carrito);
        });
    </script>
</body>
</html>