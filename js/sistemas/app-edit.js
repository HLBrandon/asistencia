const params = new URLSearchParams(window.location.search);
const id = params.get('id');

$("#form_sistema").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    formulario.append('id', id); // Agregar el id al formulario
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/sistemas/control_editar_sistema.php",
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
