<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company = $_POST['company'];
    $representative = $_POST['representative'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $message = $_POST['message'];

    // Email to CSI International
    $toCompany = "info@csiinternationalke.co.ke";
    $subjectCompany = "New Quote Request from CSI Website";
    $bodyCompany = "
        You have received a new quote request:\n\n
        Company Name: $company\n
        Representative: $representative\n
        Email: $email\n
        Phone: $phone\n
        Requested Service: $service\n
        Message:\n$message
    ";
    $headersCompany = "From: $email";

    // Email to the user
    $subjectUser = "Quote Request Received – CSI International";
    $bodyUser = "Dear $representative,\n\nThank you for requesting a quote from CSI International. We have received your details and our team will get back to you shortly regarding the \"$service\" service.\n\nBest regards,\nCSI International Team";
    $headersUser = "From: info@csiinternationalke.co.ke";

    // Send both emails
    if (mail($toCompany, $subjectCompany, $bodyCompany, $headersCompany) && mail($email, $subjectUser, $bodyUser, $headersUser)) {
        echo "<script>alert('Your quote request has been sent successfully.'); window.location.href='thank-you.html';</script>";
    } else {
        echo "<script>alert('There was an error sending your request. Please try again.'); window.history.back();</script>";
    }
}
?>
