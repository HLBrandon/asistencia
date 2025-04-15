$("#form_perfil").submit(function (e) {
    e.preventDefault();
    let formulario_perfil = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/configuracion/control_modificar_perfil.php",
        data: formulario_perfil,
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

$("#form_contrasenia").submit(function (e) {
    e.preventDefault();

    Swal.fire({
        title: "¿Cambiar Contraseña?",
        text: "Se cerrará sesión cuando se actualice",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, cambiar"
    }).then((result) => {
        if (result.isConfirmed) {
            let formulario_contrasenia = new FormData(this);
            $.ajax({
                type: "POST",
                url: URL_RAIZ + "php/configuracion/control_modificar_contrasenia.php",
                data: formulario_contrasenia,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (!response.error) {
                        let data = JSON.parse(response);

                        $('#form_contrasenia')[0].reset();
                        Swal.fire({
                            title: data.titulo,
                            text: data.texto,
                            icon: data.icono
                        });
                        if (data.status) {
                            setTimeout(function () {
                                window.location.href = URL_RAIZ + "php/auth/cerrar_sesion.php";
                            }, 1600);
                        }
                    }
                }
            });
        }
    });

});