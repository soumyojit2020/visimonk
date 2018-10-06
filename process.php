<?php
if(isset($_POST) && !empty($_POST)){
  $contact_name = $_POST['name'];
  $contact_email = $_POST['email'];
  $contact_message = $_POST['message'];
  $to = 'blinkingcursors@gmail.com';
  $subject = 'New Query'.$contact_email;
  $message = 'You got new query'.$contact_name. "\r\n".
        $contact_email. "\r\n".
        $contact_message. "\r\n";
  $headers = 'From: blinkingcursors@gmail.com' . "\r\n" .
             'Reply-To: blinkingcursors@gmail.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);
  header ('Location:vms/register_view.php');
} else {
  echo 'Oops we screwed up. Please resubmit the form or call us.';
}
?>
