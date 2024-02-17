<?php
require_once 'vendor/autoload.php';

// Crear nueva instancia de TCPDF
$pdf = new TCPDF();

// Establecer el título del documento
$pdf->SetTitle('Mi presentación');

// Agregar una página
$pdf->AddPage();

// Escribir el contenido del PDF
$contenido = '
    <h1>Mi presentación</h1>
    <p>¡Hola! Soy [Tu nombre]. Vivo en [Tu ciudad/país] y me apasiona [tus intereses/hobbies]. 
    Estoy aprendiendo y mejorando mis habilidades en programación y otras áreas relacionadas. 
    Me encanta [algo que te guste hacer].</p>
';

$pdf->writeHTML($contenido, true, false, true, false, '');

// Nombre del archivo PDF que se generará
$nombre_archivo = 'mi_presentacion.pdf';

// Obtener la ruta absoluta del directorio actual
$ruta_absoluta = __DIR__ . '/';

// Generar la ruta completa del archivo PDF
$ruta_pdf = $ruta_absoluta . $nombre_archivo;

// Generar el PDF y guardarlo en el servidor
$pdf->Output($ruta_pdf, 'F');

// Mostrar un mensaje al usuario con el enlace para descargar el PDF
echo 'Se ha generado el PDF. <a href="' . $nombre_archivo . '">Descargar PDF</a>';
?>
