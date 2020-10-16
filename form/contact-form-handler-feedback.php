<?php
	$name = $_POST['name'];
	$visitor_email = $_POST['email'];
	$message = $_POST['message'];
	
	$email_from = 'stanleyowen.atwebpages.com';
	$email_subject = "Feedback Form Submission: $name";
	$email_body = "You have received a new message. ".
	"Here are the details :\nName: $name.\n".
	"Email: $visitor_email\nMessage/Feedback :\n $message\n";
	
	$to = "stanleyowennn@gmail.com";
	$headers = "From: $email_from \r\n";
	$headers .= "Reply-To: $visitor_email \r\n";
	mail($to,$email_subject,$email_body,$headers);

	header("Location: Thankyoufeedback.html");
?>