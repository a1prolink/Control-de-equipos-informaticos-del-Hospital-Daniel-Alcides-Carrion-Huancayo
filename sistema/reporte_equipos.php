<?php
session_start();
require '../fpdf/fpdf.php';
include "../conexion.php";

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte de Equipos', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function EquipmentTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 10);
        foreach ($header as $col)
            $this->Cell(30, 7, $col, 1);
        $this->Ln();

        $this->SetFont('Arial', '', 9);
        foreach ($data as $row) {
            $this->Cell(10, 6, $row['codequipos'], 1);
            $this->Cell(30, 6, $row['descripcion'], 1);
            $this->Cell(30, 6, $row['marca'], 1);
            $this->Cell(30, 6, $row['modelo'], 1);
            $this->Cell(30, 6, $row['serie'], 1);
            $this->Cell(30, 6, $row['codpratimonial'], 1);
            $this->Cell(40, 6, $row['usuario'], 1);
            $this->Ln();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha_desde = $_POST['fecha_desde'];
    $fecha_hasta = $_POST['fecha_hasta'];
    $usuario = $_POST['usuario'];

    $query = mysqli_query($conection, "SELECT e.codequipos, e.descripcion, e.marca, e.modelo, e.serie, e.codpratimonial, u.nombre as usuario
                                        FROM equipo e
                                        INNER JOIN usuarios u ON e.usuario_id = u.idusuario
                                        WHERE e.date_add BETWEEN '$fecha_desde' AND '$fecha_hasta'
                                        AND e.usuario_id = $usuario AND e.estatus = 1");

    $result = mysqli_num_rows($query);
    if ($result > 0) {
        $header = array('ID', 'Descripcion', 'Marca', 'Modelo', 'Serie', 'CodPatrimonio', 'Usuario');
        $data = array();

        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->EquipmentTable($header, $data);
        $pdf->Output();
    } else {
        echo "No se encontraron resultados.";
    }
}
mysqli_close($conection);
?>
