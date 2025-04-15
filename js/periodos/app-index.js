function listar_periodos() {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/periodos/control_listar_periodos.php",
        success: function (response) {
            let data = JSON.parse(response);
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.fecha_inicio}</td>
                        <td>${element.fecha_fin}</td>
                        <td>${(element.activo == 1) ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <a class="btn btn-sm btn-primary rounded-0 text-uppercase mb-2 mb-sm-0" href="${URL_RAIZ}view/periodos/edit.php?id=${element.id}">Editar</a>
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

listar_periodos();
