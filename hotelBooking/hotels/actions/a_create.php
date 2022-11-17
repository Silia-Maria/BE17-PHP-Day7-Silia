<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: ../../home.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../../index.php");
    exit;
}

require_once "../../components/db_connect.php";
require_once "../../components/file_upload.php";

if ($_POST) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $stars = $_POST['stars'];
    $uploadError = "";
    $picture = file_upload($_FILES['picture'], 'hotel');

    $sql = "INSERT INTO hotels (name, price, location, picture, stars) VALUES ('$name', $price, '$location', '$picture->fileName',$stars)";

    if (mysqli_query($connect, $sql) === TRUE) {
        $icon = "<i class='fa-regular fa-circle-check text-success'></i>";
        $message = "New Hotel $name was successfully uploaded!";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
    } else {
        $icon = "<i class='fa-regular fa-circle-xmark text-danger'></i>";
        $message = "Error while creating record. Please try again.. <br>" . $connect->error;
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
    }
    mysqli_close($connect);
} else {
    header("Location: ../error.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "../../components/style.php" ?>
    <link rel="stylesheet" href="../../style.css">
    <title>Upload - Atlantic Hotel Booking</title>
</head>

<body>

    <div class="container">
        <div class="w-50 mx-auto border border-rounded">
            <div><?php echo $icon ?></div>
            <h5><?php echo $message ?></h5>
            <a href="../../dashboard.php">Go Back</a>
        </div>

    </div>

</body>

</html>