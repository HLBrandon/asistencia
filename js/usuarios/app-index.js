
function listar_usuarios() {
    $.ajax({
        type: "GET",
        url: URL_RAIZ + "php/usuarios/control_listar_usuarios.php",
        success: function (response) {
            console.log(response);
            
            let data = JSON.parse(response);
            console.log(data);
            
            let tmp = ``;
            data.forEach(element => {
                tmp += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.nombre}</td>
                        <td>${element.correo}</td>
                        <td>${element.nombre_role}</td>
                        <td>${(element.activo == 1) ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <a class="btn btn-sm btn-primary rounded-0 text-uppercase mb-2 mb-sm-0" href="${URL_RAIZ}view/usuarios/edit.php?id=${element.id}">Editar</a>
                            ${activo_usuario(element.activo, element.id)}
                        </td>
                    </tr>
                `;
            });
            $("#body-tabla").html(tmp);
        }
    });
}

listar_usuarios();

function activo_usuario(status, id) {
    if (status == 1) {
        return `
            <button class="btn btn-sm btn-danger rounded-0 text-uppercase" title="Quitar Acceso" onclick="quitar_acceso(${id})">
                Desactivar
            </button>
        `;
    } else if (status == 0) {
        return `
            <button class="btn btn-sm btn-success rounded-0 text-uppercase" title="Dar Acceso" onclick="dar_acceso(${id})">
                Activar
            </button>
        `;
    }
}

function quitar_acceso(id) {
    Swal.fire({
        title: "¿Quieres quitar el acceso?",
        text: "El usuario perderá su acceso al sistema",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d00000",
        cancelButtonColor: "#8b8b8b",
        confirmButtonText: "Sí, quitar acceso",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            updated_status(id);
        }
    });
}

function dar_acceso(id) {
    Swal.fire({
        title: "¿Quieres dar acceso?",
        text: "El usuario podrá acceder al sistema",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0a9d00",
        cancelButtonColor: "#8b8b8b",
        confirmButtonText: "Sí, dar acceso",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            updated_status(id);
        }
    });
}

function updated_status(id) {
    let usuario_id = id;
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/usuarios/control_acceso_usuario.php",
        data: { usuario_id },
        success: function (response) {
            if (!response.error) {
                let data = JSON.parse(response);
                Swal.fire({
                    title: data.titulo,
                    text: data.texto,
                    icon: data.icono
                });
                listar_usuarios();
            }
        }
    });
}