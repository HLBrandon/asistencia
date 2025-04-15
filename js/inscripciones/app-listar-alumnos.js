
const params = new URLSearchParams(window.location.search);
const clase_id = params.get('clase');

function listar_estudiantes(clase_id) {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/inscripciones/control_listar_estudiantes.php",
        data: { clase_id },
        success: function (response) {
            let data = JSON.parse(response);
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.matricula}</td>
                        <td>${element.nombre_estudiante}</td>
                        <td>
                            ${activo(element.status, element.id)}
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

function activo(params, id) {
    if (params == 1) {
        return `<button class="btn btn-sm btn-danger rounded-0 text-uppercase mb-2 mb-sm-0" onclick="cancelar_inscripcion(${id})"><i class="bi bi-trash-fill me-2"></i>Eliminar</button>`;
    } else {
        return `<button class="btn btn-sm btn-success rounded-0 text-uppercase mb-2 mb-sm-0" onclick="activar_inscripcion(${id})"><i class="bi bi-check-circle me-2"></i>Activar</button>`;
    }
}

listar_estudiantes(clase_id);

function cancelar_inscripcion(id) {
    let inscripcion_id = id;
    Swal.fire({
        title: "Se cancelará la inscripción",
        text: "¿Estás seguro de cancelar esta inscripción?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, cancelar!",
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: URL_RAIZ + "php/inscripciones/control_cancelar_inscripcion.php",
                data: { inscripcion_id },
                success: function (response) {
                    let data = JSON.parse(response);
                    if (data.status) {
                        listar_estudiantes(clase_id);
                    }
                }
            });
        }
    });
}

function activar_inscripcion(id) {
    let inscripcion_id = id;
    Swal.fire({
        title: "Se activará la inscripción",
        text: "¿Estás seguro de activar esta inscripción?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, activar!",
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: URL_RAIZ + "php/inscripciones/control_activar_inscripcion.php",
                data: { inscripcion_id },
                success: function (response) {
                    let data = JSON.parse(response);
                    if (data.status) {
                        listar_estudiantes(clase_id);
                    }
                }
            });
        }
    });
}
