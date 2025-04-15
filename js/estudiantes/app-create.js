$("#form_estudiante").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/estudiantes/control_registrar_estudiante.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            if (!response.error) {
                let data = JSON.parse(response);
                if (data.status) {
                    $('#form_estudiante')[0].reset();
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

$("#form_estudiantes").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/estudiantes/control_registrar_varios_estudiantes.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);

            if (!response.error) {
                let data = JSON.parse(response);
                if (data.status) {
                    $('#form_estudiantes')[0].reset();
                }

                let timerInterval;
                Swal.fire({
                    icon: "info",
                    title: "En proceso",
                    text: "Estamos procesando su solicitud, espere por favor...",
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        Swal.fire({
                            title: data.titulo,
                            text: data.texto,
                            icon: data.icono
                        });
                    }
                });

            }
        }
    });
});
