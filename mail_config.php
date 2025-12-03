<?php
// Email Configuration
return [
    'smtp' => [
        'host' => 'smtp.example.com',  // Replace with your SMTP host
        'username' => 'your-email@example.com',  // Replace with your SMTP username
        'password' => 'your-email-password',  // Replace with your SMTP password
        'port' => 587,  // Common ports: 587 (TLS), 465 (SSL), 25 (not recommended)
        'encryption' => 'tls',  // tls or ssl
    ],
    'from' => [
        'email' => 'your-email@example.com',  // Sender email
        'name' => 'Kedir Mundino Portfolio'  // Sender name
    ],
    'to' => [
        'email' => 'your-personal-email@example.com',  // Your personal email to receive messages
        'name' => 'Kedir Mundino'  // Your name
    ]
];
?>
