<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Send email to company
    $to = "info@yourcompany.com"; // Change this to your email address
    $headers = "From: $email";
    $message_body = "You have received a new message from $name.\n\n".
                    "Subject: $subject\n\n".
                    "Message: \n$message";

    if (mail($to, $subject, $message_body, $headers)) {
        // Notify the client
        echo "<script>alert('Thank you for contacting us! We will get back to you shortly.'); window.location.href='thank-you.html';</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.'); window.location.href='contact.html';</script>";
    }
}
?>
