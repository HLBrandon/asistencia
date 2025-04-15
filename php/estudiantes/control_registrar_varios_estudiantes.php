<?php

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

if (isset($_POST)) {

    if (!empty($_FILES["archivo"]["tmp_name"])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        // Cargar el archivo Excel
        $documento = IOFactory::load($_FILES["archivo"]["tmp_name"]);
        $hojaActual = $documento->getActiveSheet();

        // Obtener el número de filas con datos
        $numeroMayorDeFila = $hojaActual->getHighestDataRow();

        // Preparar las consultas SQL
        $sqlVerificar = "SELECT COUNT(*) FROM estudiantes WHERE matricula = ?";
        $stmtVerificar = $conexion->prepare($sqlVerificar);

        $sqlInsertar = "INSERT INTO estudiantes (matricula, nombre, apellido_pa, apellido_ma, carrera_id, semestre_id, sistema_id, activo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
        $stmtInsertar = $conexion->prepare($sqlInsertar);

        // Iniciar desde la fila 4 (después de los encabezados)
        for ($fila = 4; $fila <= $numeroMayorDeFila; $fila++) {
            $matricula = $hojaActual->getCell('A' . $fila)->getValue();

            // Si no hay matrícula, saltamos esta fila
            if (empty($matricula)) {
                continue;
            }

            // Verificar si la matrícula ya existe
            $stmtVerificar->bind_param("s", $matricula);
            $stmtVerificar->execute();
            $stmtVerificar->bind_result($count);
            $stmtVerificar->fetch();
            $stmtVerificar->free_result();

            if ($count > 0) {
                $respuesta = [
                    "titulo" => "Error",
                    "texto" => "La matrícula " . $matricula . " ya existe en la base de datos",
                    "icono" => "error"
                ];
                print_r(json_encode($respuesta, JSON_UNESCAPED_UNICODE));
                exit;
            }

            $nombre = $hojaActual->getCell('B' . $fila)->getValue();
            $apellidoPa = $hojaActual->getCell('C' . $fila)->getValue();
            $apellidoMa = $hojaActual->getCell('D' . $fila)->getValue();
            $carreraId = $hojaActual->getCell('E' . $fila)->getValue();
            $semestreId = $hojaActual->getCell('F' . $fila)->getValue();
            $sistemaId = $hojaActual->getCell('G' . $fila)->getValue();

            $stmtInsertar->bind_param(
                "sssssii",
                $matricula,
                $nombre,
                $apellidoPa,
                $apellidoMa,
                $carreraId,
                $semestreId,
                $sistemaId
            );

            if (!$stmtInsertar->execute()) {
                $respuesta = [
                    "titulo" => "Error",
                    "texto" => "Error al insertar el estudiante con matrícula: " . $matricula,
                    "icono" => "error"
                ];
                print_r(json_encode($respuesta, JSON_UNESCAPED_UNICODE));
                exit;
            }
        }

        $stmtVerificar->close();
        $stmtInsertar->close();

        $respuesta = [
            "titulo" => "Exitoso",
            "texto" => "Registro de estudiantes completado",
            "icono" => "success"
        ];
    } else {
        $respuesta = [
            "titulo" => "No hay archivo",
            "texto" => "Debe subir el archivo excel. Descarguelo en el punto 1",
            "icono" => "error"
        ];
    }

    print_r(json_encode($respuesta, JSON_UNESCAPED_UNICODE));
}
