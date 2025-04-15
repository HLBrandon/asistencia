document.addEventListener('DOMContentLoaded', function () {
    const horariosContainer = document.getElementById('horarios-container');
    const btnAgregar = document.getElementById('agregar-horario');

    function eliminarHorario(event) {
        const horarioItem = event.target.closest('.horario-item');
        if (horariosContainer.querySelectorAll('.horario-item').length > 1) {
            horarioItem.remove();
        } else {
            Swal.fire({
                title: "Alerta",
                text: "Debe haber por lo menos un horario",
                icon: "warning"
            });
        }
    }

    document.querySelectorAll('.eliminar-horario').forEach(btn => {
        btn.addEventListener('click', eliminarHorario);
    });

    btnAgregar.addEventListener('click', function () {
        const nuevoHorario = horariosContainer.querySelector('.horario-item').cloneNode(true);

        nuevoHorario.querySelectorAll('select, input').forEach(input => {
            input.value = '';
        });

        nuevoHorario.querySelector('.eliminar-horario').addEventListener('click', eliminarHorario);

        horariosContainer.appendChild(nuevoHorario);
    });
});