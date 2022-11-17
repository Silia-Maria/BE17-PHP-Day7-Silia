<?php
session_start();
require_once "../components/db_connect.php";

if (isset($_SESSION['user']) != "") {
    header("location: ../home.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hotel - Atlantic Hotel Booking</title>
    <?php require_once "../components/style.php"; ?>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <!------------------
    Nav Bar
-------------------->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Atlantic Hotel Booking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>

            <p> <a href="logout.php?logout">Logout</a></p>
        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <h1>New Hotels <br> coming to Atlantic Hotel Booking...</h1>
        </div>
    </div>

    <!------------------
   Form to create new Hotel
-------------------->

    <div class="container my-5">
        <form action="actions/a_create.php" method="post" enctype="multipart/form-data" class="mx-auto w-75">
            <div class="d-flex mb-3">
                <input name='name' type="text" placeholder="Name" class="w-50 me-5">
                <input name='stars' type="number" placeholder="Stars (max 5)" class="w-50">
            </div>
            <div class="d-flex mb-3">
                <input name='location' type="text" placeholder="location" class="w-50 me-5">

                <input name='price' type="text" placeholder="Price per night $" class="w-50">
            </div>
            <input name='picture' type="file" placeholder="picture" class="w-100 mb-5">


            <a href="../dashboard.php"><button class="btn btn-outline-dark w-100 me-5 mb-3">Go Back</button></a>

            <button type='submit' class="btn btn-outline-dark w-100">Upload Hotel</button>
        </form>


    </div>


</body>

</html>