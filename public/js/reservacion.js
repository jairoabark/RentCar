const IVA = 0.13;

const fechasOcupadas = {
    rav4: [["2026-11-20", "2026-11-25"]],
    montero: [["2026-11-14", "2026-11-18"], ["2026-12-20", "2026-12-31"]],
    hiace: [["2026-12-01", "2026-12-07"]]
};

const formReserva = document.getElementById("form-reserva");
const selectVehiculo = document.getElementById("vehiculo");
const fechaInicio = document.getElementById("fecha-inicio");
const fechaFin = document.getElementById("fecha-fin");
const btnDisponibilidad = document.getElementById("btn-disponibilidad");
const mensaje = document.getElementById("mensaje");
const opcionesSeguro = document.querySelectorAll('input[name="seguro"]');

const ahora = new Date();
const hoy = ahora.getFullYear() + "-" + String(ahora.getMonth() + 1).padStart(2, "0") + "-" + String(ahora.getDate()).padStart(2, "0");
fechaInicio.min = hoy;
fechaFin.min = hoy;

function formatoDinero(monto) {
    return "$" + monto.toFixed(2);
}

function formatoFecha(fecha) {
    if (fecha === "") {
        return "-";
    }
    const partes = fecha.split("-");
    return partes[2] + "/" + partes[1] + "/" + partes[0];
}

function obtenerDias() {
    if (fechaInicio.value === "" || fechaFin.value === "") {
        return 0;
    }
    const inicio = new Date(fechaInicio.value);
    const fin = new Date(fechaFin.value);
    const dias = (fin - inicio) / (1000 * 60 * 60 * 24);
    if (dias > 0) {
        return dias;
    }
    return 0;
}

function obtenerPrecioSeguro() {
    const seguro = document.querySelector('input[name="seguro"]:checked');
    if (seguro) {
        return Number(seguro.dataset.precio);
    }
    return 0;
}

function calcularTotal() {
    const vehiculo = selectVehiculo.options[selectVehiculo.selectedIndex];
    const precioDia = Number(vehiculo.dataset.precio) || 0;
    const dias = obtenerDias();

    const alquiler = precioDia * dias;
    const seguro = obtenerPrecioSeguro() * dias;
    const subtotal = alquiler + seguro;
    const impuesto = subtotal * IVA;
    const total = subtotal + impuesto;

    document.getElementById("res-vehiculo").textContent = vehiculo.dataset.nombre || "-";
    document.getElementById("res-inicio").textContent = formatoFecha(fechaInicio.value);
    document.getElementById("res-fin").textContent = formatoFecha(fechaFin.value);
    document.getElementById("res-dias").textContent = dias;
    document.getElementById("res-alquiler").textContent = formatoDinero(alquiler);
    document.getElementById("res-seguro").textContent = formatoDinero(seguro);
    document.getElementById("res-subtotal").textContent = formatoDinero(subtotal);
    document.getElementById("res-iva").textContent = formatoDinero(impuesto);
    document.getElementById("res-total").textContent = formatoDinero(total);
}

function mostrarMensaje(texto, tipo) {
    mensaje.textContent = texto;
    mensaje.className = "mensaje mensaje-" + tipo;
}

function limpiarMensaje() {
    mensaje.textContent = "";
    mensaje.className = "mensaje";
}

function validarDatos() {
    if (selectVehiculo.value === "") {
        mostrarMensaje("Debe seleccionar un vehículo.", "error");
        return false;
    }
    if (fechaInicio.value === "" || fechaFin.value === "") {
        mostrarMensaje("Debe seleccionar la fecha de retiro y la de devolución.", "error");
        return false;
    }
    if (fechaInicio.value < hoy) {
        mostrarMensaje("La fecha de retiro no puede ser anterior a hoy.", "error");
        return false;
    }
    if (obtenerDias() === 0) {
        mostrarMensaje("La fecha de devolución debe ser posterior a la fecha de retiro.", "error");
        return false;
    }
    return true;
}

function estaDisponible() {
    const reservas = fechasOcupadas[selectVehiculo.value] || [];
    for (let i = 0; i < reservas.length; i++) {
        if (fechaInicio.value <= reservas[i][1] && fechaFin.value >= reservas[i][0]) {
            return false;
        }
    }
    return true;
}

btnDisponibilidad.addEventListener("click", function () {
    if (!validarDatos()) {
        return;
    }
    if (estaDisponible()) {
        mostrarMensaje("El vehículo está disponible para las fechas seleccionadas.", "exito");
    } else {
        mostrarMensaje("El vehículo no está disponible en esas fechas. Pruebe con otras fechas u otro vehículo.", "error");
    }
});

formReserva.addEventListener("submit", function (evento) {
    evento.preventDefault();
    if (!validarDatos()) {
        return;
    }
    if (!estaDisponible()) {
        mostrarMensaje("El vehículo no está disponible en esas fechas. Pruebe con otras fechas u otro vehículo.", "error");
        return;
    }
    if (formReserva.dataset.accion === "modificar") {
        mostrarMensaje("Los cambios de la reservación se guardaron correctamente.", "exito");
    } else {
        const codigo = "RT-" + Math.floor(1000 + Math.random() * 9000);
        mostrarMensaje("Reservación confirmada. Su código de reserva es " + codigo + ".", "exito");
    }
});

fechaInicio.addEventListener("change", function () {
    if (fechaInicio.value !== "") {
        fechaFin.min = fechaInicio.value;
    }
    limpiarMensaje();
    calcularTotal();
});

fechaFin.addEventListener("change", function () {
    limpiarMensaje();
    calcularTotal();
});

selectVehiculo.addEventListener("change", function () {
    limpiarMensaje();
    calcularTotal();
});

for (let i = 0; i < opcionesSeguro.length; i++) {
    opcionesSeguro[i].addEventListener("change", calcularTotal);
}

calcularTotal();
