$("#form-horario").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/horario/control_registrar_horario.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            if (!response.error) {
                let data = JSON.parse(response);
                if (data.status) {
                    $('#form-horario')[0].reset();
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