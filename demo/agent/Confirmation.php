<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<center>
    <h1>Your information has been recorded.</h1>

    <h2>Thank you!</h2>

    <form action="signIn.php">
        <input type="submit" value="Go back to form" name="BuyerForm"/>
    </form>
    <meta http-equiv="refresh" content="3;url=signIn.php"/>
</center>
</body>

</html>
