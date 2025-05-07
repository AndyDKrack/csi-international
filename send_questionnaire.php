<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form fields and clean them
    $company_name = htmlspecialchars(trim($_POST['company_name']));
    $person_name = htmlspecialchars(trim($_POST['person_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $position = htmlspecialchars(trim($_POST['position']));
    $service_offered = htmlspecialchars(trim($_POST['service_offered']));
    $rating = htmlspecialchars(trim($_POST['rating']));
    $office_visit_experience = htmlspecialchars(trim($_POST['office_visit_experience']));
    $phone_call_care = htmlspecialchars(trim($_POST['phone_call_care']));
    $service_delivery = htmlspecialchars(trim($_POST['service_delivery']));
    $satisfaction = htmlspecialchars(trim($_POST['satisfaction']));
    $recommendation = htmlspecialchars(trim($_POST['recommendation']));
    $other_information = htmlspecialchars(trim($_POST['other_information']));
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // reCAPTCHA
    $secret_key = "6LdGyjErAAAAAFVpH5xDbUHNUhbJxfBgnkU9GDUx"; // Secret Key
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verify_url . "?secret=" . $secret_key . "&response=" . $recaptcha_response);
    $response_data = json_decode($response);

    if (!$response_data->success) {
        echo "<script>alert('reCAPTCHA verification failed. Please try again.'); window.location.href='questionnaire.html';</script>";
        exit;
    }

    // CSI Company Email
    $company_email = "support@csiinternational.co.ke"; 

    // Subject for CSI Team
    $subject_to_company = "New Questionnaire Submission from $person_name";

    // Email to CSI Team
    $message_to_company = "
    <h2>New Questionnaire Submission</h2>
    <p><strong>Company Name:</strong> {$company_name}</p>
    <p><strong>Person's Name:</strong> {$person_name}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Phone:</strong> {$phone}</p>
    <p><strong>Job Position:</strong> {$position}</p>
    <hr>
    <p><strong>Service Offered:</strong> {$service_offered}</p>
    <p><strong>Rating (1-5 Stars):</strong> {$rating}</p>
    <p><strong>Office Visit Experience:</strong> {$office_visit_experience}</p>
    <p><strong>Phone Call Customer Care:</strong> {$phone_call_care}</p>
    <p><strong>Service Delivery:</strong> {$service_delivery}</p>
    <p><strong>Satisfaction:</strong> {$satisfaction}</p>
    <p><strong>Recommendation:</strong> {$recommendation}</p>
    <p><strong>Other Information:</strong><br>{$other_information}</p>
    ";

    $headers_company = "MIME-Version: 1.0" . "\r\n";
    $headers_company .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers_company .= "From: Website Form <no-reply@yourdomain.com>" . "\r\n";

    mail($company_email, $subject_to_company, $message_to_company, $headers_company);

    // Send Thank You email to the person
    $subject_to_client = "Thank you for submitting the CSI Questionnaire.";

    $message_to_client = "
    <h2>Thank you, {$person_name}!</h2>
    <p>We have received your feedback. We truly appreciate you taking the time to help us improve our services.</p>
    <p>Our team will review your submission and get back to you if necessary.</p>
    <br>
    <p>Best Regards,</p>
    <p><strong>CSI International Team</strong></p>
    ";

    $headers_client = "MIME-Version: 1.0" . "\r\n";
    $headers_client .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers_client .= "From: CSI International <no-reply@yourdomain.com>" . "\r\n";

    mail($email, $subject_to_client, $message_to_client, $headers_client);

    // After sending, redirect to a Thank You page
    header("Location: Thank-You.html");
    exit;
} else {
    // Redirect to home if accessed directly
    header("Location: index.html");
    exit;
}
?>