function eliminarHorario(horario) {
    let horario_id = horario;
    Swal.fire({
        title: "¿Estás seguro de eliminar este horario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: URL_RAIZ + "php/horario/control_eliminar_horario.php",
                data: { horario_id },
                dataType: "json",
                success: function (response) {
                    if (!response.error) {
                        Swal.fire({
                            title: response.titulo,
                            text: response.texto,
                            icon: response.icono
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }
    });
}