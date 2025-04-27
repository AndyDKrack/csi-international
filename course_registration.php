<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = htmlspecialchars($_POST['first_name']);
    $second_name = htmlspecialchars($_POST['second_name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);

    $full_name = $first_name . ' ' . $second_name;

    // Email details
    $company_email = "info@yourcompany.com"; // <-- Replace with your real email
    $subject_to_company = "New Course Registration: $course";
    $subject_to_user = "Thank you for registering";

    $message_to_company = "New registration details:\n\n" .
                           "Full Name: $full_name\n" .
                           "Phone Number: $phone\n" .
                           "Email: $email\n" .
                           "Course: $course\n";

    $message_to_user = "Dear $full_name,\n\n" .
                       "Thank you for registering for the course: $course.\n\n" .
                       "We will contact you soon regarding payment and the course start date.\n\n" .
                       "Best Regards,\n" .
                       "CSI International";

    $headers = "From: $company_email";

    // Send emails
    $company_mail_sent = mail($company_email, $subject_to_company, $message_to_company, $headers);
    $user_mail_sent = mail($email, $subject_to_user, $message_to_user, $headers);

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
