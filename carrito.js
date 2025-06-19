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

function cambiarCantidad(nombre, cambio) {
  const item = carrito.find((item) => item.nombre === nombre);
  if (!item) return;
  item.cantidad += cambio;
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
    total += item.precio * item.cantidad;

    const div = document.createElement("div");
    div.className = "item";
    div.innerHTML = `
      <span>${item.nombre}</span>
      <div class="item-cantidad">
        <button onclick="cambiarCantidad('${item.nombre}', -1)">-</button>
        <span>${item.cantidad}</span>
        <button onclick="cambiarCantidad('${item.nombre}', 1)">+</button>
      </div>
      <span>$${item.precio * item.cantidad}</span>
      <button onclick="eliminarItem('${item.nombre}')">X</button>
    `;
    contenedor.appendChild(div);
  });

  totalEl.textContent = total;
}
