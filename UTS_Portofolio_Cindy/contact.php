<?php
header('Content-Type: application/json');

// Validate input
$errors = [];
$data = [];

if (empty($_POST['name'])) {
    $errors['name'] = 'Name is required.';
}

if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required.';
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is invalid.';
}

if (empty($_POST['message'])) {
    $errors['message'] = 'Message is required.';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    // Process the form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : 'New Contact Form Submission';
    $message = htmlspecialchars($_POST['message']);
    
    // Email details
    $to = '2310631170129@student.unsika.ac.id'; // Replace with actual email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";
    
    // Send email (in production, uncomment this)
    // $success = mail($to, $subject, $email_body, $headers);
    $success = true; // For demo purposes
    
    if ($success) {
        $data['success'] = true;
        $data['message'] = 'Thank you! Your message has been sent successfully.';
    } else {
        $data['success'] = false;
        $data['message'] = 'Oops! Something went wrong. Please try again later.';
    }
}

echo json_encode($data);
?>