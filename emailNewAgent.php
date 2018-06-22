<?php 

	if(isset($_POST['username'])){
		$email = $_POST['email'];
	    // The message
	    $message = "\r\n 			Login URL: www.oversite.cc\r\n
	                Username: " . $_POST['username'] . "\r\n
	                Password: " . $_POST['password'];

	    // In case any of our lines are larger than 70 characters, we should use wordwrap()
	    $message = wordwrap($message, 70, "\r\n");

	    // Send
	    mail($email, 'Oversite Login Credentials', $message);
	}

	//echo "<a href='https://www.w3schools.com'>title</a>";

?>