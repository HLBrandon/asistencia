<?php
require __DIR__ . "../../../../config/config.php";
require __DIR__ . "/../../../vendor/autoload.php";

$clase_id = (!empty($_GET["clase"])) ? $_GET["clase"] : "";
$mes_inicio = $_GET["mes-inicio"];

// Crear un objeto DateTime
$date = new DateTime($mes_inicio);
// Número de días a sumar
$diasASumar = 30;
// Sumar los días
$date->modify("+{$diasASumar} days");
// Formatear la fecha resultante
$mes_fin = $date->format('Y-m-d');

if ($clase_id == "") {
    echo "<h3>Oh no, parece que ha ocurrido un error</h3>";
    exit;
}
if (empty($_SESSION["usuario"])) {
    header("Location: " . URL_RAIZ);
}

require __DIR__ . "/../../../vendor/setasign/fpdf/fpdf.php";
include_once __DIR__ . "../../../../php/conexion.php";

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo de la SEP
        $this->Image('../../../img/logo_sep.png', 9, 6, 62, 23);
        //$this->Image(__DIR__ . "../../../../img/logo_sep.png", 9, 6, 62, 23);
        // Logo de la TecNM
        $this->Image('../../../img/logo_tecNM.png', 85, 6, 40, 23);
        // Logo del ITSMT
        $this->Image('../../../img/logo_itsmt.png', 170, 6, 25, 25);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 16);
        // Salto de línea
        $this->Ln(20);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, utf8_decode('INSTITUTO TECNOLÓGICO SUPERIOR DE MARTÍNEZ DE LA TORRE'), 0, 0, 'C');
        // Salto de línea
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-13);
        // Arial italic 8
        $this->SetFont('Arial', '', 8);
        // Número de página
        $this->Cell(127, 5, utf8_decode('FECHA: ' . strftime("%d de %B del %Y", strtotime(date("Y-m-d")))), 1, 0, '');
        $this->Cell(50, 5, utf8_decode('A: Asistencia    F: Falta'), 1, 0, '');
        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo(), 1, 0, 'R');
    }
}

// OPTENER LA INFORMACIÓN DE LA TABLA ASISTENCIAS
$datos_asistencia = array();
$pr = $conexion->prepare("SELECT p.fecha_inicio, p.fecha_fin, c.carrera_id, se.nombre_semestre, si.nombre_sistema, c.asignatura_id, a.nombre_asignatura, c.salon_id, u.nombre, u.apellido_paterno, u.apellido_materno, asis.fecha AS fecha_asistencia, asis.hora AS hora_asistencia, COUNT(i.estudiante_id) AS total_alumnos FROM asistencias asis
                            INNER JOIN clases c ON asis.clase_id = c.id
                            INNER JOIN periodos p ON c.periodo_id = p.id
                            INNER JOIN semestres se ON c.semestre_id = se.id
                            INNER JOIN sistemas si ON c.sistema_id = si.id
                            INNER JOIN asignaturas a ON c.asignatura_id = a.id
                            INNER JOIN usuarios u ON c.profesor_id = u.id
                            INNER JOIN inscripciones i ON i.clase_id = c.id
                            WHERE c.id = ? AND asis.fecha BETWEEN '$mes_inicio' AND '$mes_fin'");
$pr->bind_param("i", $clase_id);
$pr->execute();
$result = $pr->get_result();
if ($row = $result->fetch_object()) {

    $timestamp_inicio = strtotime($row->fecha_inicio);
    $mes_anio_inicio = ucfirst(strftime('%B %Y', $timestamp_inicio));

    $timestamp_fin = strtotime($row->fecha_fin);
    $mes_anio_fin = ucfirst(strftime('%B %Y', $timestamp_fin));

    $hora_12_horas = date('h:i A', strtotime($row->hora_asistencia));

    $fecha_asistencia = ucfirst(strftime("%B", strtotime($mes_inicio)));

    $datos_asistencia = [
        "periodo" => $mes_anio_inicio . " - " . $mes_anio_fin,
        "ingenieria" => $row->carrera_id,
        "semestre" => $row->nombre_semestre,
        "sistema" => $row->nombre_sistema,
        "clave_asignatura" => $row->asignatura_id,
        "nombre_asignatura" => $row->nombre_asignatura,
        "salon" => $row->salon_id,
        "docente" => $row->nombre . " " . $row->apellido_paterno . " " . $row->apellido_materno,
        "fecha_asistencia" => $fecha_asistencia,
        "hora_asistencia" => $hora_12_horas,
        "total_alumnos" => $row->total_alumnos
    ];
}
$result->free_result();
$pr->close();

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);

//190 px es el total de ancho de la tabla
$pdf->Cell(70, 10, utf8_decode('PERIODO ESCOLAR'), 0, 0, 'C');
$pdf->Cell(40, 10, utf8_decode('INGENIERÍA'), 0, 0, 'C');
// $pdf->Cell(5); // da un espacio de 5 px
$pdf->Cell(40, 10, utf8_decode('SEMESTRE'), 0, 0, 'C');
$pdf->Cell(40, 10, utf8_decode('SISTEMAS ESCOLAR'), 0, 0, 'C');

$pdf->Ln(7); // esto es un salto de linea de 7 px

$pdf->SetFont('Arial', '', 8);

// Contenido Dinamico
$pdf->Cell(70, 5, utf8_decode($datos_asistencia["periodo"]), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode($datos_asistencia["ingenieria"]), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode($datos_asistencia["semestre"]), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode($datos_asistencia["sistema"]), 1, 0, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(45, 10, utf8_decode('CLAVE ASIGNATURA'), 0, 0, 'C');
$pdf->Cell(105, 10, utf8_decode('NOMBRE ASIGNATURA'), 0, 0, 'C');
$pdf->Cell(40, 10, utf8_decode('SALON'), 0, 0, 'C');

$pdf->Ln(7);

$pdf->SetFont('Arial', '', 8);

// Contenido Dinamico
$pdf->Cell(45, 5, utf8_decode($datos_asistencia["clave_asignatura"]), 1, 0, 'C');
$pdf->Cell(105, 5, utf8_decode($datos_asistencia["nombre_asignatura"]), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode($datos_asistencia["salon"]), 1, 0, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(70, 10, utf8_decode('DOCENTE'), 0, 0, 'C');
$pdf->Cell(90, 10, utf8_decode('MES DE ASISTENCIA'), 0, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('ALUMNOS'), 0, 0, 'C');

$pdf->Ln(7);

$pdf->SetFont('Arial', '', 8);

// Contenido Dinamico
$pdf->Cell(70, 5, utf8_decode($datos_asistencia["docente"]), 1, 0, 'C');
$pdf->Cell(90, 5, utf8_decode($datos_asistencia["fecha_asistencia"]), 1, 0, 'C');

$mysqli = $conexion->query("SELECT COUNT(DISTINCT i.estudiante_id) AS total_alumnos FROM inscripciones i WHERE i.clase_id = $clase_id AND i.status = 1");
$total_alumnos = $mysqli->fetch_object()->total_alumnos;
$pdf->Cell(30, 5, utf8_decode($total_alumnos), 1, 0, 'C');

// PARTE DEL HORARIO
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(31.666, 5, utf8_decode('LUNES'), 0, 0, 'C');
$pdf->Cell(31.666, 5, utf8_decode('MARTES'), 0, 0, 'C');
$pdf->Cell(31.666, 5, utf8_decode('MIÉRCOLES'), 0, 0, 'C');
$pdf->Cell(31.666, 5, utf8_decode('JUEVES'), 0, 0, 'C');
$pdf->Cell(31.666, 5, utf8_decode('VIERNES'), 0, 0, 'C');
$pdf->Cell(31.666, 5, utf8_decode('SÁBADO'), 0, 0, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 6);




// Obtener los horarios de la clase
$horarios = array();
$pr = $conexion->prepare("SELECT h.dia_id, h.hora_inicio, h.hora_fin 
                         FROM horario h 
                         WHERE h.clase_id = ?
                         ORDER BY h.dia_id, h.hora_inicio");
$pr->bind_param("i", $clase_id);
$pr->execute();
$result = $pr->get_result();
while ($row = $result->fetch_object()) {
    // Almacenar múltiples horarios por día
    if (!isset($horarios[$row->dia_id])) {
        $horarios[$row->dia_id] = [];
    }
    $horarios[$row->dia_id][] = [
        "hora_inicio" => date('h:i A', strtotime($row->hora_inicio)),
        "hora_fin" => date('h:i A', strtotime($row->hora_fin))
    ];
}
$result->free_result();
$pr->close();

for ($dia = 1; $dia <= 6; $dia++) {
    if (isset($horarios[$dia])) {
        // Concatenar todos los horarios del día
        $horarios_dia = array_map(function ($h) {
            return $h["hora_inicio"] . " - " . $h["hora_fin"];
        }, $horarios[$dia]);
        $horario = implode("\n", $horarios_dia);
    } else {
        $horario = "";
    }
    // Usamos MultiCell en lugar de Cell para manejar saltos de línea
    if ($dia == 6) {
        $pdf->MultiCell(31.666, 5, utf8_decode($horario), 1, 'C');
    } else {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(31.666, 5, utf8_decode($horario), 1, 'C');
        $pdf->SetXY($x + 31.666, $y);
    }
}






// PARTE DEL DETALLE DE ASISTENCIA
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, utf8_decode('N°'), 0, 0, 'C');
$pdf->Cell(35, 5, utf8_decode('No. DE CONTROL'), 0, 0, 'C');
$pdf->Cell(88, 5, utf8_decode('NOMBRE DEL ALUMNO'), 0, 0, '');

$pdf->SetFont('Arial', 'B', 4);
for ($i = 1; $i <= 31; $i++) {
    $pdf->Cell(2, 5, utf8_decode($i), 0, 0, 'C');
}

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 6);




// APARTIR DE AQUI EMPIEZA LA INFORMACIÓN DEL PASE DE LISTA DE LOS ESTUDIANTES
$contador = 1;
$datos_estudiante = array();
$pr = $conexion->prepare("SELECT e.id, e.matricula, e.nombre, e.apellido_pa, e.apellido_ma 
                         FROM inscripciones i
                         INNER JOIN estudiantes e ON i.estudiante_id = e.id
                         WHERE i.clase_id = ? AND i.status = 1
                         ORDER BY e.apellido_pa, e.apellido_ma, e.nombre");
$pr->bind_param("i", $clase_id);
$pr->execute();
$result = $pr->get_result();
while ($dato = $result->fetch_object()) {
    $datos_estudiante[] = [
        "estudiante_id" => $dato->id,
        "matricula" => $dato->matricula,
        "nombre_estudiante" => $dato->apellido_pa . " " . $dato->apellido_ma . " " . $dato->nombre
    ];
}
$result->free_result();
$pr->close();



// Obtener las asistencias del mes
$datos_asistencia = array();
$pr = $conexion->prepare("SELECT da.estudiante_id, da.presente, a.fecha 
                         FROM asistencias a
                         INNER JOIN detalle_asistencia da ON a.id = da.asistencia_id
                         WHERE a.clase_id = ? AND a.fecha BETWEEN ? AND ?");
$pr->bind_param("iss", $clase_id, $mes_inicio, $mes_fin);
$pr->execute();
$result = $pr->get_result();
while ($row = $result->fetch_object()) {
    $datos_asistencia[] = [
        "estudiante_id" => $row->estudiante_id,
        "fecha" => $row->fecha,
        "presente" => $row->presente
    ];
}
$result->free_result();
$pr->close();

// Imprimir la lista de estudiantes con sus asistencias
$contador = 1;
foreach ($datos_estudiante as $estudiante) {
    $pdf->Cell(5, 5, utf8_decode($contador), 1, 0, 'C');
    $pdf->Cell(35, 5, utf8_decode($estudiante["matricula"]), 1, 0, 'C');
    $pdf->Cell(88, 5, utf8_decode($estudiante["nombre_estudiante"]), 1, 0, '');

    // Recorrer los días del mes
    $fecha_actual = new DateTime($mes_inicio);
    $fecha_fin = new DateTime($mes_fin);

    $dia = 1;
    while ($fecha_actual <= $fecha_fin && $dia <= 31) {
        $fecha = $fecha_actual->format('Y-m-d');
        $asistencia = '';

        // Buscar si existe registro de asistencia para este día
        foreach ($datos_asistencia as $asist) {
            if (
                $asist["estudiante_id"] == $estudiante["estudiante_id"] &&
                $asist["fecha"] == $fecha
            ) {
                $asistencia = $asist["presente"] ? 'A' : 'F';
                break;
            }
        }

        if ($dia == 31) {
            $pdf->Cell(2, 5, utf8_decode($asistencia), 1, 1, 'C');
        } else {
            $pdf->Cell(2, 5, utf8_decode($asistencia), 1, 0, 'C');
        }

        $fecha_actual->modify('+1 day');
        $dia++;
    }

    // Rellenar los días restantes si el mes tiene menos de 31 días
    while ($dia <= 31) {
        if ($dia == 31) {
            $pdf->Cell(2, 5, '', 1, 1, 'C');
        } else {
            $pdf->Cell(2, 5, '', 1, 0, 'C');
        }
        $dia++;
    }

    $contador++;
}

$pdf->Output();
