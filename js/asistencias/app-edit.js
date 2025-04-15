const params = new URLSearchParams(window.location.search);
const clase = params.get('clase');
const asistencia = params.get('asistencia');


$("#form_asistencia").submit(function (e) {
    e.preventDefault();
    console.log("Click");

    let formulario = new FormData(this);
    formulario.append('clase_id', clase); // Agregar el id al formulario
    formulario.append('asistencia_id', asistencia); // Agregar el id al formulario
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/asistencias/control_editar_asistencia.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            if (!response.error) {
                let data = JSON.parse(response);
                Swal.fire({
                    title: data.titulo,
                    text: data.texto,
                    icon: data.icono
                });
            }
        }
    });
});