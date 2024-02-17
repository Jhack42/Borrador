<?php

// **Cargar el PDF**
$pdf = file_get_contents("mi_presentacion.pdf");

// **Definir destinatario**
$destinatario = "correo@ejemplo.com";

// **Definir asunto**
$asunto = "Mi presentación";

// **Definir mensaje**
$mensaje = "Hola,

Te envío mi presentación en formato PDF.

Atentamente,

Tu nombre";

// **Definir cabeceras**
$cabeceras = array(
  "MIME-Version: 1.0",
  "Content-Type: application/pdf",
  "Content-Disposition: attachment; filename=\"mi_presentacion.pdf\"",
  "Content-Transfer-Encoding: base64"
);

// **Enviar correo electrónico**
mail($destinatario, $asunto, $mensaje, implode("\r\n", $cabeceras), $pdf);

echo "<p>Correo electrónico enviado correctamente.</p>";

?>