<?php

require_once('fpdf/fpdf.php');

function generarContenido($pdf) {
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 10, 'Mi presentación', 0, 1, 'C');
  $pdf->Ln(10);
  $pdf->SetFont('Arial', '', 12);
  $pdf->Write(5, "Aquí puedes incluir una breve descripción de ti mismo, incluyendo tu experiencia, habilidades y logros.");
}

$pdf = new FPDF();
generarContenido($pdf);
$pdf->Output('mi_presentacion.pdf', 'D');

echo "<p>PDF generado y enviado correctamente.</p>";

?>