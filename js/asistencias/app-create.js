document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a los botones
    const btnMarcarPresentes = document.getElementById('marcarTodosPresente');
    const btnMarcarAusentes = document.getElementById('marcarTodosAusente');

    // Función para marcar todos los radio buttons
    function marcarTodos(valor) {
        const radioButtons = document.querySelectorAll(`input[type="radio"][value="${valor}"]`);
        radioButtons.forEach(radio => {
            radio.checked = true;
        });
    }

    // Event listeners para los botones
    btnMarcarPresentes.addEventListener('click', () => marcarTodos('1'));
    btnMarcarAusentes.addEventListener('click', () => marcarTodos('0'));

    // Código existente del formulario
    const formAsistencia = document.getElementById('form_asistencia');
    
    /*
    formAsistencia.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('../../php/asistencias/control_registrar_asistencia.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                window.location.href = '../../view/mis-clases/asistencias.php?id=' + document.getElementById('clase_id').value;
            } else {
                alert('Error al guardar la asistencia');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    });
    */

});

$("#form_asistencia").submit(function (e) { 
    e.preventDefault();
    console.log("Click");
    
    let formulario = new FormData(this);
    $.ajax({
        type: "POST",
        url: URL_RAIZ + "php/asistencias/control_registrar_asistencia.php",
        data: formulario,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            
            if (!response.error) {
                let data = JSON.parse(response);

                console.log(data);
                
                if (data.status) {
                    $('#form_asistencia')[0].reset();
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