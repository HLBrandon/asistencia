<?php
require __DIR__ . '../../config/config.php';
require __DIR__ . '../../vendor/autoload.php';
require __DIR__ . '../../php/conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Crear nuevo documento
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Título
$sheet->setCellValue('A1', 'PLANTILLA PARA REGISTRO DE ESTUDIANTES');
$sheet->mergeCells('A1:G1');

// Encabezados de la tabla
$headers = [
    'MATRÍCULA',
    'NOMBRE',
    'APELLIDO PATERNO',
    'APELLIDO MATERNO',
    'CARRERA ID',
    'SEMESTRE (1-9)',
    'SISTEMA ID'
];

// Establecer encabezados
foreach ($headers as $index => $header) {
    $column = chr(65 + $index);
    $sheet->setCellValue($column . '3', $header);
}

// Estilos para encabezados
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '2C3E50'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];

// Aplicar estilos a los encabezados
$sheet->getStyle('A3:G3')->applyFromArray($headerStyle);

// Estilos para el título
$titleStyle = [
    'font' => [
        'bold' => true,
        'size' => 16,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
];
$sheet->getStyle('A1:G1')->applyFromArray($titleStyle);

// Ajustar ancho de columnas
$sheet->getColumnDimension('A')->setWidth(15); // Matrícula
$sheet->getColumnDimension('B')->setWidth(20); // Nombre
$sheet->getColumnDimension('C')->setWidth(20); // Apellido Paterno
$sheet->getColumnDimension('D')->setWidth(20); // Apellido Materno
$sheet->getColumnDimension('E')->setWidth(15); // Carrera ID
$sheet->getColumnDimension('F')->setWidth(15); // Semestre ID
$sheet->getColumnDimension('G')->setWidth(15); // Sistema ID

// Agregar 100 filas para datos
for ($i = 4; $i <= 104; $i++) {
    // Aplicar bordes a las celdas
    $sheet->getStyle('A' . $i . ':G' . $i)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ]);
}

// Consultar datos de carreras
$sql_carreras = "SELECT id, nombre_carrera FROM carreras";
$result_carreras = $conexion->query($sql_carreras);
$carreras = $result_carreras->fetch_all(MYSQLI_ASSOC);

// Consultar datos de sistemas
$sql_sistemas = "SELECT id, nombre_sistema FROM sistemas";
$result_sistemas = $conexion->query($sql_sistemas);
$sistemas = $result_sistemas->fetch_all(MYSQLI_ASSOC);

// Agregar tabla de referencia de Carreras
$sheet->setCellValue('I3', 'REFERENCIA DE CARRERAS');
$sheet->mergeCells('I3:J3');
$sheet->setCellValue('I4', 'ID');
$sheet->setCellValue('J4', 'NOMBRE DE CARRERA');

// Llenar datos de carreras
$row = 5;
foreach ($carreras as $carrera) {
    $sheet->setCellValue('I' . $row, $carrera['id']);
    $sheet->setCellValue('J' . $row, $carrera['nombre_carrera']);
    $row++;
}

// Agregar tabla de referencia de Sistemas
$sheet->setCellValue('L3', 'REFERENCIA DE SISTEMAS');
$sheet->mergeCells('L3:M3');
$sheet->setCellValue('L4', 'ID');
$sheet->setCellValue('M4', 'NOMBRE DE SISTEMA');

// Llenar datos de sistemas
$row = 5;
foreach ($sistemas as $sistema) {
    $sheet->setCellValue('L' . $row, $sistema['id']);
    $sheet->setCellValue('M' . $row, $sistema['nombre_sistema']);
    $row++;
}

// Aplicar estilos a las tablas de referencia
$sheet->getStyle('I3:J3')->applyFromArray($headerStyle);
$sheet->getStyle('I4:J4')->applyFromArray($headerStyle);
$sheet->getStyle('L3:M3')->applyFromArray($headerStyle);
$sheet->getStyle('L4:M4')->applyFromArray($headerStyle);

// Ajustar ancho de columnas para las tablas de referencia
$sheet->getColumnDimension('I')->setWidth(15);
$sheet->getColumnDimension('J')->setWidth(30);
$sheet->getColumnDimension('L')->setWidth(15);
$sheet->getColumnDimension('M')->setWidth(30);

// Aplicar bordes a las tablas de referencia
$lastCarreraRow = count($carreras);
$lastSistemaRow = count($sistemas);

$sheet->getStyle('I4:J' . $lastCarreraRow)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
]);

$sheet->getStyle('L4:M' . $lastSistemaRow)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
]);

// Configurar headers para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="registrar_estudiantes.xlsx"');
header('Cache-Control: max-age=0');

// Guardar archivo directamente al output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
