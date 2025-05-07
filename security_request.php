<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // form data
    $company = htmlspecialchars(trim($_POST['company']));
    $representative = htmlspecialchars(trim($_POST['representative']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $service = htmlspecialchars(trim($_POST['service']));
    $message = htmlspecialchars(trim($_POST['message']));
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // reCAPTCHA
    $secret_key = "6LdGyjErAAAAAFVpH5xDbUHNUhbJxfBgnkU9GDUx"; // Secret Key
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verify_url . "?secret=" . $secret_key . "&response=" . $recaptcha_response);
    $response_data = json_decode($response);

    if (!$response_data->success) {
        echo "<script>alert('reCAPTCHA verification failed. Please try again.'); window.location.href='Security.html';</script>";
        exit;
    }

    // Company email
    $company_email = "security@csiinternational.co.ke"; 

    // Email to the company
    $subject_to_company = "New Security Service Request: $service";
    $message_to_company = "
    <h2>New Security Service Request</h2>
    <p><strong>Company Name:</strong> {$company}</p>
    <p><strong>Representative's Name:</strong> {$representative}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Phone:</strong> {$phone}</p>
    <p><strong>Service Requested:</strong> {$service}</p>
    <p><strong>Message:</strong><br>{$message}</p>
    ";

    $headers_company = "MIME-Version: 1.0" . "\r\n";
    $headers_company .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers_company .= "From: Website Form <no-reply@yourdomain.com>" . "\r\n";

    mail($company_email, $subject_to_company, $message_to_company, $headers_company);

    // Email to the visitor
    $subject_to_visitor = "Thank you for your Security Service Inquiry";
    $message_to_visitor = "
    <h2>Thank you, {$representative}!</h2>
    <p>We have received your inquiry for the service: <strong>{$service}</strong>.</p>
    <p>Our team will contact you soon via email or phone to discuss your request further.</p>
    <br>
    <p>Best Regards,</p>
    <p><strong>CSI International Security Team</strong></p>
    ";

    $headers_visitor = "MIME-Version: 1.0" . "\r\n";
    $headers_visitor .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers_visitor .= "From: CSI International <no-reply@yourdomain.com>" . "\r\n";

    mail($email, $subject_to_visitor, $message_to_visitor, $headers_visitor);

    // Redirect to a Thank You page
    echo "<script>alert('Thank you for your inquiry! We will contact you soon.'); window.location.href='Thank-You.html';</script>";
    exit;
} else {
    // Redirect to home if accessed directly
    header("Location: index.html");
    exit;
}
?>

