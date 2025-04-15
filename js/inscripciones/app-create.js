$("#form_inscripcion").submit(function (e) {
    e.preventDefault();
    let formulario = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/inscripciones/control_registrar_inscripcion.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);

            if (!response.error) {
                let data = JSON.parse(response);
                if (data.status) {
                    let tmp = `
                        <li class="list-group-item">
                            <p class="text-center mb-0">No hay alumnos para inscribir</p>
                        </li>
                    `;
                    $("#contenedor-alumnos").html(tmp);
                    $('#form_inscripcion')[0].reset();
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

$("#carrera_id").change(function (e) {
    e.preventDefault();
    let carrera_id = $(this).val();
    let semestre_id = $("#semestre_id").val();
    let sistema_id = $("#sistema_id").val();
    listar_alumnos(carrera_id, semestre_id, sistema_id);
});

$("#semestre_id").change(function (e) {
    e.preventDefault();
    let semestre_id = $(this).val();
    let sistema_id = $("#sistema_id").val();
    let carrera_id = $("#carrera_id").val();
    listar_alumnos(carrera_id, semestre_id, sistema_id);
});

$("#sistema_id").change(function (e) {
    e.preventDefault();
    let sistema_id = $(this).val();
    let semestre_id = $("#semestre_id").val();
    let carrera_id = $("#carrera_id").val();
    listar_alumnos(carrera_id, semestre_id, sistema_id);
});

function listar_alumnos(carrera_id, semestre_id, sistema_id) {
    let tmp = ``;

    if (carrera_id != "" && semestre_id != "" && sistema_id != "") {
        let datos = {
            "carrera_id": carrera_id,
            "semestre_id": semestre_id,
            "sistema_id": sistema_id
        };
        $.ajax({
            type: "POST",
            url: URL_RAIZ + "php/inscripciones/control_llenar_lista_estudiantes.php",
            data: datos,
            dataType: "json",
            success: function (response) {
                response.forEach(element => {
                    tmp += `
                        <li class="list-group-item">
                            <input class="form-check-input me-1 check-estudiante" type="checkbox" value="${element.id}" name="estudiantes[]" id="check-${element.id}">
                            <label class="form-check-label" for="check-${element.id}">${element.nombre_estudiante}</label>
                        </li>
                    `;
                });
                $("#contenedor-alumnos").html(tmp);
            }
        });
    } else {
        tmp = `
        <li class="list-group-item">
            <p class="text-center mb-0">No hay alumnos para inscribir</p>
        </li>
        `;
    }

    $("#contenedor-alumnos").html(tmp);
}

$("#btn-seleccionar-todo").click(function (e) {
    e.preventDefault();
    $(".check-estudiante").prop("checked", true);
});

$("#btn-deseleccionar-todo").click(function (e) {
    e.preventDefault();
    $(".check-estudiante").prop("checked", false);
});
