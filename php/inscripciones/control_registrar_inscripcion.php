<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["clase_id"]) and
        !empty($_POST["estudiantes"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $clase_id = $_POST["clase_id"];
        $estudiantes = $_POST["estudiantes"]; // esto en el html es name="estudiantes[]"


        foreach ($estudiantes as $estudiante_id) {
            // Verificar si la inscripción ya existe
            $stmt = $conexion->prepare("SELECT id FROM inscripciones WHERE clase_id = ? AND estudiante_id = ?");
            $stmt->bind_param("ii", $clase_id, $estudiante_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {

                $stmt = $conexion->prepare("INSERT INTO inscripciones (clase_id, estudiante_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $clase_id, $estudiante_id);
                $stmt->execute();

                $response = [
                    "status" => true,
                    "titulo" => "Registro exitoso",
                    "texto" => "La inscripción fue creada con éxito",
                    "icono" => "success"
                ];

            } else {
                $response = [
                    "status" => false,
                    "titulo" => "Inscripción duplicada",
                    "texto" => "Existen estudiante que ya toman esta clase",
                    "icono" => "error"
                ];
            }
        }

        $stmt->close();
        $conexion->close();
    } else {
        $response = [
            "status" => false,
            "titulo" => "Campos vacíos",
            "texto" => "Debes completar todo el formulario",
            "icono" => "error"
        ];
    }

    print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
}
