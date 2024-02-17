<?php

// **Definir destinatario**
$destinatario = "correo@ejemplo.com";

// **Definir asunto**
$asunto = "La solución está completa";

// **Definir mensaje**
$mensaje = "El desarrollo de las funcionalidades solicitadas ha finalizado satisfactoriamente.";

// **Enviar correo electrónico**
mail($destinatario, $asunto, $mensaje);

echo "<p>Correo electrónico enviado correctamente.</p>";

?>