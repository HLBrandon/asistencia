function listar_clases() {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/clases/control_listar_clases.php",
        success: function (response) {
            let data = JSON.parse(response);
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.nombre}</td>
                        <td>${element.nombre_asignatura}</td>
                        <td>${element.carrera_id}</td>
                        <td>${element.semestre_id}</td>
                        <td>${element.nombre_sistema}</td>
                        <td>${element.periodo}</td>
                        <td>${element.salon_id}</td>
                        <td>${(element.activo == 1) ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <a class="btn btn-sm btn-primary rounded-0 text-uppercase mb-2 mb-sm-0" href="${URL_RAIZ}view/clases/edit.php?id=${element.id}">Editar</a>
                            <a class="btn btn-sm btn-success rounded-0 text-uppercase" href="${URL_RAIZ}view/horario/index.php?clase_id=${element.id}">Ver horario</a>
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

listar_clases();
