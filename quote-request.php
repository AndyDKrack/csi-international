<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
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
        echo "<script>alert('reCAPTCHA verification failed. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Email to CSI International
    $toCompany = "support@csiinternational.co.ke"; 
    $subjectCompany = "New Quote Request from CSI Website";
    $bodyCompany = "
        <h2>New Quote Request</h2>
        <p><strong>Company Name:</strong> $company</p>
        <p><strong>Representative's Name:</strong> $representative</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Requested Service:</strong> $service</p>
        <p><strong>Message:</strong><br>$message</p>
    ";
    $headersCompany = "MIME-Version: 1.0" . "\r\n";
    $headersCompany .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headersCompany .= "From: Website Form <support@csiinternational.co.ke>" . "\r\n";

    // Email to the user
    $subjectUser = "Quote Request Received – CSI International";
    $bodyUser = "
        <h2>Thank you, $representative!</h2>
        <p>We have received your quote request for the service: <strong>$service</strong>.</p>
        <p>Our team will contact you shortly via email or phone to discuss your request further.</p>
        <br>
        <p>Best regards,</p>
        <p><strong>CSI International Team</strong></p>
    ";
    $headersUser = "MIME-Version: 1.0" . "\r\n";
    $headersUser .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headersUser .= "From: CSI International <support@csiinternational.co.ke>" . "\r\n";

    // Send both emails
    $companyMailSent = mail($toCompany, $subjectCompany, $bodyCompany, $headersCompany);
    $userMailSent = mail($email, $subjectUser, $bodyUser, $headersUser);

    if ($companyMailSent && $userMailSent) {
        echo "<script>alert('Your quote request has been sent successfully.'); window.location.href='Thank-You.html';</script>";
    } else {
        echo "<script>alert('There was an error sending your request. Please try again.'); window.history.back();</script>";
    }
}
?>