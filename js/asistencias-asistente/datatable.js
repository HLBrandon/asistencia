$(document).ready(function () {
    $('#tabla-clases').DataTable({
        order: [[0, "desc"]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-MX.json',
        },
        lengthMenu: [10, 20, 30, { label: 'All', value: -1 }],
    });
});