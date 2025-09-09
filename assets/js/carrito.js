// Array para almacenar los productos del carrito.
let carrito = [];

// Función para agregar un producto normal al carrito (sin barra de cantidad).
function agregarAlCarrito(nombre, precio) {
  const itemExistente = carrito.find((item) => item.nombre === nombre);
  if (itemExistente) {
    itemExistente.cantidad++;
  } else {
    carrito.push({ nombre, precio, cantidad: 1 });
  }
  renderCarrito();
}

// Función para agregar un producto con barra de cantidad (como frutas o verduras).
function agregarConBarra(boton) {
  const producto = boton.closest(".producto");
  const slider = producto.querySelector("input[type='range']");
  const nombre = slider.getAttribute("data-nombre");
  const precio = parseInt(slider.getAttribute("data-precio"));
  const cantidad = parseFloat(slider.value);

  const itemExistente = carrito.find((item) => item.nombre === nombre);
  if (itemExistente) {
    itemExistente.cantidad += cantidad;
  } else {
    carrito.push({ nombre, precio, cantidad });
  }
  renderCarrito();
}

// Función para agregar carnes al carrito, manejando precios de promoción.
function agregarCarne(nombre, precioPorKilo, boton) {
  const tarjeta = boton.closest(".producto");
  const slider = tarjeta.querySelector("input[type='range']");
  const kilos = parseFloat(slider.value);
  const precioPromocion = parseFloat(tarjeta.querySelector('.precio-actual').textContent.replace(/[$.]/g, ''));
  const precioFinal = precioPromocion / kilos;

  const itemExistente = carrito.find((item) => item.nombre === nombre);

  if (itemExistente) {
    itemExistente.cantidad += kilos;
  } else {
    carrito.push({ nombre, precio: precioFinal, cantidad: kilos });
  }
  renderCarrito();
}

// Función para cambiar la cantidad de un producto en el carrito.
function cambiarCantidad(nombre, cambio) {
  const item = carrito.find((item) => item.nombre === nombre);
  if (!item) return;

  item.cantidad = parseFloat((item.cantidad + cambio).toFixed(1));
  if (item.cantidad <= 0) {
    carrito = carrito.filter((i) => i.nombre !== nombre);
  }
  renderCarrito();
}

// Función para eliminar un producto del carrito.
function eliminarItem(nombre) {
  carrito = carrito.filter((item) => item.nombre !== nombre);
  renderCarrito();
}

// Función para vaciar todo el carrito.
function vaciarCarrito() {
  carrito = [];
  renderCarrito();
}

// Función para renderizar (mostrar) el carrito en la página.
function renderCarrito() {
  const contenedor = document.getElementById("carrito-items");
  const totalEl = document.getElementById("carrito-total");
  contenedor.innerHTML = "";
  let total = 0;

  carrito.forEach((item) => {
    const subtotal = item.precio * item.cantidad;
    total += subtotal;

    const div = document.createElement("div");
    div.className = "item";
    div.innerHTML = `
      <span>${item.nombre}</span>
      <div class="item-cantidad">
        <button onclick="cambiarCantidad('${item.nombre}', -1)">-</button>
        <span>${Number.isInteger(item.cantidad) ? item.cantidad : item.cantidad.toFixed(1)}</span>
        <button onclick="cambiarCantidad('${item.nombre}', 1)">+</button>
      </div>
      <span>$${subtotal.toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}</span>
      <button onclick="eliminarItem('${item.nombre}')">Eliminar</button>
    `;
    contenedor.appendChild(div);
  });

  totalEl.textContent = total.toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 });

  // Guarda el carrito en el almacenamiento local del navegador (localStorage).
  // Esto es para que la información persista entre páginas.
  localStorage.setItem('carrito', JSON.stringify(carrito));
}

// Función que se activa con el botón "Realizar Pedido".
function finalizarPedido() {
    // Si el carrito tiene productos, redirige al usuario a la página de pedido.
    if (carrito.length > 0) {
        window.location.href = 'realizar_pedido.php';
    } else {
        // Muestra una alerta si el carrito está vacío.
        alert('Tu carrito está vacío. Agrega productos para continuar.');
    }
}