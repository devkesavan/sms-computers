<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $position = trim($_POST['position']);
    $message = trim($_POST['message']);

    $errors = [];

    // Validate required fields
    if (empty($name) || empty($email) || empty($mobile) || empty($position) || empty($message)) {
        $errors[] = "All fields are required.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate mobile number format
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $errors[] = "Invalid mobile number. Please enter a 10-digit number.";
    }

    // If no errors, send the email
    if (empty($errors)) {
        $to = "info@smscomputers.co.in";
        $subject = "New Contact Form Submission";
        $body = "Name: $name\nEmail: $email\nMobile: $mobile\nPosition Applied: $position\nMessage:\n$message";
        $headers = "From: $email\r\n";

        // Sending the email
        if (mail($to, $subject, $body, $headers)) {
            header("Location: carrer.html?success=1");
            exit();
        } else {
            $errors[] = "Failed to send email. Please try again later.";
        }
    }

    // Handle errors by displaying them (if any)
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>
