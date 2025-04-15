
const params = new URLSearchParams(window.location.search);
const id = params.get('id');

$("#form_asignatura").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    formulario.append('id_url', id); // Agregar el id al formulario
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/asignaturas/control_editar_asignatura.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {         
            console.log(response);
               
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