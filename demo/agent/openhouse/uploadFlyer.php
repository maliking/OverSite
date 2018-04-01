<?php
clearstatcache();
require("../../databaseConnection.php");
$dbConn = getConnection();
if (isset($_FILES)) {
    // print_r($_FILES);
    // $targetfolder = "../../../test/";  //local
    $targetfolder = "../../uploadFlyers/";  //server

    $targetfolder = $targetfolder . basename($_FILES['file']['name']);

    $ok = 1;

    $file_type = $_FILES['file']['type'];

    if ($file_type == "application/pdf") {

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder)) {
            // echo "The file ". basename( $_FILES['file']['name']). " is uploaded";
            echo basename($_FILES['file']['name']);
            if($_POST['mlsId'][0] == 'M')
                $sql = "UPDATE HouseInfo SET flyer = :flyer WHERE listingId = :listingId";
            else
                $sql = "UPDATE HouseInfo SET flyer = :flyer WHERE houseId = :listingId";

            $namedParameters = array();
            $namedParameters[":flyer"] = substr(basename($_FILES['file']['name']), 0, -3) . 'jpg';
            $namedParameters[':listingId'] = substr($_POST['listingId'], 0, -1);


            $stmt = $dbConn->prepare($sql);
            $stmt->execute($namedParameters);

            $im = new Imagick();

            $im->setResolution(300, 300);
            $im->readimage("../../uploadFlyers/" . $_FILES['file']['name'] . '[0]');
            $im->setImageFormat('jpeg');
            $im->writeImage("../../uploadFlyers/" . substr(basename($_FILES['file']['name']), 0, -3) . 'jpg');

            $im->clear();
            $im->destroy();


        } else {
            echo "Problem uploading file";
        }

    } else {
        echo "You may only upload PDF files.";
    }

    // echo $_FILES['file'];
    // echo $_POST[0];
} else {
    echo "not set";
}

?>