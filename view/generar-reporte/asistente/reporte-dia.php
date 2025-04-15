<?php
require __DIR__ . "../../../../config/config.php";
require __DIR__ . "/../../../vendor/autoload.php";

$asistencia_id = (!empty($_GET["asistencia"])) ? $_GET["asistencia"] : "";
if ($asistencia_id == "") {
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
        $this->Cell(177, 5, utf8_decode('FECHA: ' . strftime("%d de %B del %Y", strtotime(date("Y-m-d")))), 1, 0, '');
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
                            WHERE asis.id = ?");
$pr->bind_param("i", $asistencia_id);
$pr->execute();
$result = $pr->get_result();
if ($row = $result->fetch_object()) {

    $timestamp_inicio = strtotime($row->fecha_inicio);
    $mes_anio_inicio = ucfirst(strftime('%B %Y', $timestamp_inicio));

    $timestamp_fin = strtotime($row->fecha_fin);
    $mes_anio_fin = ucfirst(strftime('%B %Y', $timestamp_fin));

    $hora_12_horas = date('h:i A', strtotime($row->hora_asistencia));

    $fecha_asistencia = strftime("%d de %B del %Y", strtotime($row->fecha_asistencia));

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
$pdf->Cell(45, 10, utf8_decode('FECHA DE ASISTENCIA'), 0, 0, 'C');
$pdf->Cell(45, 10, utf8_decode('HORA DE ASISTENCIA'), 0, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('ALUMNOS'), 0, 0, 'C');

$pdf->Ln(7);

$pdf->SetFont('Arial', '', 8);

// Contenido Dinamico
$pdf->Cell(70, 5, utf8_decode($datos_asistencia["docente"]), 1, 0, 'C');
$pdf->Cell(45, 5, utf8_decode($datos_asistencia["fecha_asistencia"]), 1, 0, 'C');
$pdf->Cell(45, 5, utf8_decode($datos_asistencia["hora_asistencia"]), 1, 0, 'C');
$pdf->Cell(30, 5, utf8_decode($datos_asistencia["total_alumnos"]), 1, 0, 'C');

$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, utf8_decode('N°'), 0, 0, 'C');
$pdf->Cell(35, 5, utf8_decode('No. DE CONTROL'), 0, 0, 'C');
$pdf->Cell(80, 5, utf8_decode('NOMBRE DEL ALUMNO'), 0, 0, 'C');
$pdf->Cell(70, 5, utf8_decode('ASISTENCIA'), 0, 0, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 6);

// APARTIR DE AQUI EMPIEZA LA INFORMACIÓN DEL PASE DE LISTA DE LOS ESTUDIANTES
$contador = 1;
$pr = $conexion->prepare("SELECT e.matricula, e.nombre, e.apellido_pa, e.apellido_ma, da.presente FROM detalle_asistencia da
                            INNER JOIN estudiantes e ON da.estudiante_id = e.id
                            WHERE da.asistencia_id = ?
                            ORDER BY e.apellido_pa");
$pr->bind_param("i", $asistencia_id);
$pr->execute();
$result = $pr->get_result();
while ($dato = $result->fetch_object()) {
    $pdf->Cell(5, 5, utf8_decode($contador), 1, 0, 'C');
    $pdf->Cell(35, 5, utf8_decode($dato->matricula), 1, 0, 'C');
    $pdf->Cell(80, 5, utf8_decode($dato->nombre . " " . $dato->apellido_pa . " " . $dato->apellido_ma), 1, 0, 'C');
    $pdf->Cell(70, 5, utf8_decode(($dato->presente == 1) ? 'PRESENTE' : 'NO PRESENTE'), 1, 1, 'C');
    $contador++;
}

$result->free_result();
$pr->close();
$conexion->close();

$pdf->Output();
