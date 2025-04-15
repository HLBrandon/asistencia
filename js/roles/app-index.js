function listar_roles() {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/roles/control_listar_roles.php",
        success: function (response) {
            let data = JSON.parse(response);
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.nombre_role}</td>
                        <td>
                            <a class="btn btn-sm btn-primary rounded-0 text-uppercase mb-2 mb-sm-0" href="${URL_RAIZ}view/roles/edit.php?id=${element.id}">Editar</a>
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

listar_roles();
