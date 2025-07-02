let carrito = [];

// Para productos normales (sin barra)
function agregarAlCarrito(nombre, precio) {
  const itemExistente = carrito.find((item) => item.nombre === nombre);
  if (itemExistente) {
    itemExistente.cantidad++;
  } else {
    carrito.push({ nombre, precio, cantidad: 1 });
  }
  renderCarrito();
}

// Para productos con barra (como frutas y verduras)
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

// Para carnes (con kilos decimales)
function agregarCarne(nombre, precioPorKilo, boton) {
  const tarjeta = boton.closest(".producto");
  const slider = tarjeta.querySelector("input[type='range']");
  const kilos = parseFloat(slider.value);
  const itemExistente = carrito.find((item) => item.nombre === nombre);

  if (itemExistente) {
    itemExistente.cantidad += kilos;
  } else {
    carrito.push({ nombre, precio: precioPorKilo, cantidad: kilos });
  }
  renderCarrito();
}

// Cambiar cantidad con botones + o -
function cambiarCantidad(nombre, cambio) {
  const item = carrito.find((item) => item.nombre === nombre);
  if (!item) return;

  item.cantidad += cambio;
  if (item.cantidad <= 0) {
    carrito = carrito.filter((i) => i.nombre !== nombre);
  }
  renderCarrito();
}

// Eliminar un producto del carrito
function eliminarItem(nombre) {
  carrito = carrito.filter((item) => item.nombre !== nombre);
  renderCarrito();
}

// Vaciar todo el carrito
function vaciarCarrito() {
  carrito = [];
  renderCarrito();
}

// Mostrar los elementos en el carrito
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
      <span>$${subtotal.toLocaleString()}</span>
      <button onclick="eliminarItem('${item.nombre}')">X</button>
    `;
    contenedor.appendChild(div);
  });

  totalEl.textContent = total.toLocaleString();
}
