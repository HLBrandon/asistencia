function listar_estudiantes() {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/estudiantes/control_listar_estudiantes.php",
        success: function (response) {
            let data = JSON.parse(response);
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.matricula}</td>
                        <td>${element.nombre}</td>
                        <td>${element.carrera_id}</td>
                        <td>${element.semestre_id}</td>
                        <td>${element.sistema_id}</td>
                        <td>${(element.activo == 1) ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <a class="btn btn-sm btn-primary rounded-0 text-uppercase mb-2 mb-sm-0" href="${URL_RAIZ}view/estudiantes/edit.php?id=${element.id}">Editar</a>
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

listar_estudiantes();
