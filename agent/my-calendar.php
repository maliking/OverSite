<?php
//session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp17.org/login.php");
//}
?>


    <!DOCTYPE html>
    <html>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | My Calendar</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
        <script src='fullcalendar/lib/jquery.min.js'></script>
        <script src='fullcalendar/lib/moment.min.js'></script>
        <script src='fullcalendar/fullcalendar.js'></script>
 
    </head>

    <body>
       
       <div id='calendar'></div>

    <script>
       $(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        })

    });
       </script>
    </body>
    </html>
