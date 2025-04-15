$("#form_usuario").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/usuarios/control_registrar_usuarios.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            if (!response.error) {
                let data = JSON.parse(response);
                if (data.status) {
                    $('#form_usuario')[0].reset();
                }
                Swal.fire({
                    title: data.titulo,
                    text: data.texto,
                    icon: data.icono
                });
            }
        }
    });
});