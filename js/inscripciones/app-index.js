function listar_inscripciones() {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/inscripciones/control_listar_inscripciones.php",
        success: function (response) {
            let data = JSON.parse(response);
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.clase_id}</td>
                        <td>${element.nombre_asignatura}</td>
                        <td>${element.carrera_id}</td>
                        <td>${element.semestre_id}</td>
                        <td>${element.nombre_sistema}</td>
                        <td>${element.periodo}</td>
                        <td>${element.total_alumnos}</td>
                        <td>
                            <a class="btn btn-sm btn-success rounded-0 text-uppercase mb-2 mb-sm-0" href="${URL_RAIZ}view/inscripciones/listar-alumnos.php?clase=${element.clase_id}">Listar Alumnos</a>
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

listar_inscripciones();
