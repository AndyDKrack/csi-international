<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // reCAPTCHA
    $secret_key = "6LdGyjErAAAAAFVpH5xDbUHNUhbJxfBgnkU9GDUx"; // Secret Key
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verify_url . "?secret=" . $secret_key . "&response=" . $recaptcha_response);
    $response_data = json_decode($response);

    if (!$response_data->success) {
        echo "<script>alert('reCAPTCHA verification failed. Please try again.'); window.location.href='contact.html';</script>";
        exit;
    }

    // Email to the company
    $to_company = "support@csiinternational.co.ke"; 
    $headers_company = "From: $email";
    $message_body_company = "You have received a new message from $name.\n\n".
                            "Subject: $subject\n\n".
                            "Message: \n$message";

    // Email to the visitor
    $to_visitor = $email;
    $subject_visitor = "Thank you for contacting CSI International";
    $message_body_visitor = "Dear $name,\n\n".
                            "Thank you for reaching out to CSI International. We have received your message and will get back to you shortly.\n\n".
                            "Have a great day!\n\n".
                            "Best regards,\n".
                            "CSI International Team";
    $headers_visitor = "From: support@csiinternational.co.ke";

    // Send emails
    $company_email_sent = mail($to_company, $subject, $message_body_company, $headers_company);
    $visitor_email_sent = mail($to_visitor, $subject_visitor, $message_body_visitor, $headers_visitor);

    if ($company_email_sent && $visitor_email_sent) {
        // Notify the client
        echo "<script>alert('Thank you for CSI International Ltd.!'); window.location.href='Thank-You.html';</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong. Please try again.'); window.location.href='contact.html';</script>";
    }
}
?>