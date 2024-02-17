<?php
require_once 'vendor/autoload.php';



// Inicializar TCPDF
$pdf = new TCPDF();

// Establecer el título del documento
$pdf->SetTitle('Mi presentación');

$pdf->AddPage();

// Contenido HTML para el PDF
$html_content = '
    <h1>Mi presentación</h1>
    <p>¡Hola! Soy [Tu nombre]. Vivo en [Tu ciudad/país] y me apasiona [tus intereses/hobbies]. 
    Estoy aprendiendo y mejorando mis habilidades en programación y otras áreas relacionadas. 
    Me encanta [algo que te guste hacer].</p>
';
// Mostrar el contenido HTML en el navegador
echo $html_content;

// Escribir contenido HTML en el PDF
$pdf->writeHTML($html_content);

// Nombre del archivo PDF que se generará
$nombre_archivo = 'mi_presentacion.pdf';

// Generar el PDF y guardarlo en el servidor
$ruta_archivo_pdf = __DIR__ . '/' . $nombre_archivo;
$pdf->Output($ruta_archivo_pdf, 'F');

// Mostrar el enlace para descargar el PDF y un formulario para enviar por correo electrónico
echo '<h2>Descargar PDF:</h2>';
echo '<a href="' . $nombre_archivo . '">Descargar PDF</a><br><br>';

// Formulario para enviar por correo electrónico
echo '<h2>Enviar por correo electrónico:</h2>';
echo '<form action="enviar_pdf.php" method="post">';
echo 'Remitente: <input type="email" name="remitente"><br>';
echo 'Destinatario: <input type="email" name="destinatario"><br>';
echo '<input type="hidden" name="archivo_pdf" value="' . $nombre_archivo . '">';
echo '<input type="submit" name="enviar" value="Enviar">';
echo '</form>';
?>
