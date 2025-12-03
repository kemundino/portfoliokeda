<?php
// Set the content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
    exit;
}

// Get form data and sanitize
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING) ?: 'Message from Portfolio Contact Form';
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

// Validate form data
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required.';
} elseif (strlen($name) > 100) {
    $errors[] = 'Name is too long. Maximum 100 characters allowed.';
}

if (empty($email)) {
    $errors[] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
} elseif (strlen($email) > 100) {
    $errors[] = 'Email is too long. Maximum 100 characters allowed.';
}

if (empty($message)) {
    $errors[] = 'Message is required.';
} elseif (strlen($message) > 2000) {
    $errors[] = 'Message is too long. Maximum 2000 characters allowed.';
}

if (strlen($subject) > 200) {
    $errors[] = 'Subject is too long. Maximum 200 characters allowed.';
}

// If there are validation errors, return them
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => implode(' ', $errors)
    ]);
    exit;
}

try {
    // Load Composer's autoloader
    require 'vendor/autoload.php';
    
    // Load email configuration
    $config = require 'config/mail_config.php';
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    // Server settings
    $mail->isSMTP();
    $mail->Host = $config['smtp']['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp']['username'];
    $mail->Password = $config['smtp']['password'];
    $mail->SMTPSecure = $config['smtp']['encryption'];
    $mail->Port = $config['smtp']['port'];
    
    // Recipients
    $mail->setFrom($config['from']['email'], $config['from']['name']);
    $mail->addAddress($config['to']['email'], $config['to']['name']);
    $mail->addReplyTo($email, $name);
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission: ' . $subject;
    
    // Email body with better formatting
    $email_body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #6c63ff; color: white; padding: 15px; text-align: center; }
            .content { padding: 20px; background-color: #f9f9f9; border-radius: 5px; }
            .footer { margin-top: 20px; font-size: 12px; color: #777; text-align: center; }
            .field { margin-bottom: 15px; }
            .field-label { font-weight: bold; display: block; margin-bottom: 5px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Message from Portfolio Contact Form</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <span class='field-label'>From:</span>
                    <div>{$name} &lt;{$email}&gt;</div>
                </div>
                <div class='field'>
                    <span class='field-label'>Subject:</span>
                    <div>{$subject}</div>
                </div>
                <div class='field'>
                    <span class='field-label'>Message:</span>
                    <div>" . nl2br(htmlspecialchars($message)) . "</div>
                </div>
            </div>
            <div class='footer'>
                <p>This email was sent from the contact form on your portfolio website.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $mail->Body = $email_body;
    
    // Plain text version for non-HTML email clients
    $mail->AltBody = "
    New Message from Portfolio Contact Form
    ------------------------------------
    
    From: {$name} <{$email}>
    Subject: {$subject}
    
    Message:
    {$message}
    
    This email was sent from the contact form on your portfolio website.
    ";
    
    // Send the email
    $mail->send();
    
    // Log the successful submission (optional)
    $log_message = date('[Y-m-d H:i:s]') . " - Message from: {$name} <{$email}>\n";
    file_put_contents('contact_log.txt', $log_message, FILE_APPEND);
    
    // Return success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Your message has been sent successfully! I\'ll get back to you soon.'
    ]);
    
} catch (Exception $e) {
    // Log the error
    error_log('Mailer Error: ' . $mail->ErrorInfo);
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Message could not be sent. Please try again later.',
        'debug' => (ENVIRONMENT === 'development') ? $e->getMessage() : null
    ]);
}

exit;
$email_body .= "Email: $email\n\n";
$email_body .= "Message:\n$message\n";

// Send email
$mail_sent = mail($to, $email_subject, $email_body, $headers);

// Return response
if ($mail_sent) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Thank you! Your message has been sent successfully.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Sorry, there was an error sending your message. Please try again later.'
    ]);
}
?>
