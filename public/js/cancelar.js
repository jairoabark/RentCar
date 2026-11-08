const formCancelar = document.getElementById("form-cancelar");
const mensaje = document.getElementById("mensaje");
const btnCancelar = document.getElementById("btn-cancelar");
const estadoReserva = document.getElementById("estado-reserva");

formCancelar.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const motivo = document.getElementById("motivo").value;
    if (motivo === "") {
        mensaje.textContent = "Debe seleccionar un motivo para cancelar.";
        mensaje.className = "mensaje mensaje-error";
        return;
    }

    if (confirm("¿Está seguro de que desea cancelar la reservación RT-1024?")) {
        mensaje.textContent = "La reservación RT-1024 fue cancelada correctamente.";
        mensaje.className = "mensaje mensaje-exito";
        estadoReserva.textContent = "Cancelada";
        estadoReserva.className = "estado estado-cancelada";
        btnCancelar.disabled = true;
    }
});
