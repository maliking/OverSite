<?php
function getConnection()
{
    //database login credentials
    $host = "localhost";
    $dbname = "demo";
    $username = "root";
    $password = "root";

    try {
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Check for ERROR
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Return Connection
        //echo "Connected successfully";
        return $dbConn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    setlocale(LC_MONETARY, 'en_US.UTF-8');
}

//used to UPDATE, INSERT, and SELECT statements for database
function sendQuery($sql, $namedParameters)
{
    $dbConn = getConnection();
    $stmt = $dbConn->prepare($sql);
    if ($namedParameters != null) {
        $stmt->execute($namedParameters);
    } else {
        $stmt->execute();
    }
    if (strtoupper(strtok($sql, " ")) == "SELECT") {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
