function listar_carreras() {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/carreras/control_listar_carreras.php",
        success: function (response) {
            let data = JSON.parse(response);
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.nombre_carrera}</td>
                        <td>
                            <a class="btn btn-sm btn-primary rounded-0 text-uppercase mb-2 mb-sm-0" href="${URL_RAIZ}view/carreras/edit.php?id=${element.id}">Editar</a>
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

listar_carreras();
