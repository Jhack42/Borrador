<?php

// Reemplaza 'tu-api-key' con tu propia clave API de SendGrid
$apiKey = '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';

$email = [
    'personalizations' => [
        [
            'to' => [
                [
                    'email' => 'cacereshilasacajhack@gmail.com' // Reemplaza con el correo del destinatario
                ]
            ],
            'subject' => '¡Hola desde SendGrid!'
        ]
    ],
    'from' => [
        'email' => '1364822@senati.pe' // Reemplaza con tu correo electrónico registrado en SendGrid
    ],
    'content' => [
        [
            'type' => 'text/html',
            'value' => '<html><p>Hola,<br>Este es un correo de prueba desde SendGrid.<br>¡Saludos!</p></html>'
        ]
    ]
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo 'HTTP Code: ' . $httpcode . '<br>';
echo 'Response: ' . $response;

?>
