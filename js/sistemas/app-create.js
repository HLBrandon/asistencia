$("#form_sistema").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/sistemas/control_registrar_sistema.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            if (!response.error) {
                let data = JSON.parse(response);
                if (data.status) {
                    $('#form_sistema')[0].reset();
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
