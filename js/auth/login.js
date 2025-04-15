$("#form_login").submit(function (e) {
    e.preventDefault();

    if ($("#email").val() == "" || $("#password").val() == "") {
        alerta("Campos vacios", "Debes completar todo el formulario", "info", 1500);
    } else {
        let formulario = new FormData(this);
        $.ajax({
            type: "POST",
            url: URL_RAIZ + "php/auth/control_login.php",
            data: formulario,
            processData: false,
            contentType: false,
            success: function (response) {
                if (!response.error) {

                    let data = JSON.parse(response);

                    alerta(data.titulo, data.texto, data.icono, 1500);

                    if (data.status) {
                        setTimeout(function () {
                            $('#form_login')[0].reset();
                            window.location.href = URL_RAIZ + "view/home/";
                        }, 1600); // 3000 milisegundos = 3 segundos
                    }
                }
            }
        });
    }
});

function alerta(titulo, texto, icono, tiempo) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icono,
        showConfirmButton: false,
        timer: tiempo
    });
}