$("#form_clase").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);

    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/clases/control_registrar_clase.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);

            if (!response.error) {
                let data = JSON.parse(response);
                if (data.status) {
                    $('#form_clase')[0].reset();
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
