<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // form data
    $first_name = htmlspecialchars($_POST['first_name']);
    $second_name = htmlspecialchars($_POST['second_name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $full_name = $first_name . ' ' . $second_name;

    // Email to the company
    $company_email = "support@csiinternational.co.ke"; 
    $subject_to_company = "New Course Registration: $course";
    $message_to_company = "New registration details:\n\n" .
                          "Full Name: $full_name\n" .
                          "Phone Number: $phone\n" .
                          "Email: $email\n" .
                          "Course: $course\n";

    // Email to the student
    $subject_to_user = "Thank you for registering for the course";
    $message_to_user = "Dear $full_name,\n\n" .
                       "Thank you for registering for the course: $course.\n\n" .
                       "Our team will contact you soon via email or phone regarding payment and the course start date.\n\n" .
                       "Best Regards,\n" .
                       "CSI International Team";

    $headers_company = "From: $company_email";
    $headers_user = "From: $company_email";

    // Send emails
    $company_mail_sent = mail($company_email, $subject_to_company, $message_to_company, $headers_company);
    $user_mail_sent = mail($email, $subject_to_user, $message_to_user, $headers_user);

    // Feedback
    if ($company_mail_sent && $user_mail_sent) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var formMessage = document.getElementById('formMessage');
                    formMessage.style.display = 'block';
                    formMessage.style.color = 'green';
                    formMessage.innerText = 'Your registration was successful! Please check your email.';
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var formMessage = document.getElementById('formMessage');
                    formMessage.style.display = 'block';
                    formMessage.style.color = 'red';
                    formMessage.innerText = 'There was an error sending your registration. Please try again later.';
                });
              </script>";
    }
}
?>