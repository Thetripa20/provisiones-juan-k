let carrito = [];

function agregarAlCarrito(nombre, precio) {
  const itemExistente = carrito.find((item) => item.nombre === nombre);
  if (itemExistente) {
    itemExistente.cantidad++;
  } else {
    carrito.push({ nombre, precio, cantidad: 1 });
  }
  renderCarrito();
}

function agregarConBarra(boton) {
  const producto = boton.closest(".producto");
  const slider = producto.querySelector("input[type='range']");
  const nombre = slider.getAttribute("data-nombre");
  const precio = parseFloat(slider.getAttribute("data-precio"));
  const cantidad = parseFloat(slider.value);
  const itemExistente = carrito.find((item) => item.nombre === nombre);
  if (itemExistente) {
    itemExistente.cantidad += cantidad;
  } else {
    carrito.push({ nombre, precio, cantidad });
  }
  renderCarrito();
}

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

function cambiarCantidad(nombre, cambio) {
  const item = carrito.find((item) => item.nombre === nombre);
  if (!item) return;

  item.cantidad = parseFloat((item.cantidad + cambio).toFixed(1));
  if (item.cantidad <= 0) {
    carrito = carrito.filter((i) => i.nombre !== nombre);
  }
  renderCarrito();
}

function eliminarItem(nombre) {
  carrito = carrito.filter((item) => item.nombre !== nombre);
  renderCarrito();
}

function vaciarCarrito() {
  carrito = [];
  renderCarrito();
}

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
}