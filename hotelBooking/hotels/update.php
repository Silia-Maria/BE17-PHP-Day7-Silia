<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: ../home.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}

require_once "../components/db_connect.php";

if ($_GET['id']) {
    $hotel_id = $_GET['id'];
    $sql = "SELECT * FROM hotels WHERE hotel_id = {$hotel_id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['name'];
        $location = $data['location'];
        $price = $data['price'];
        $stars = $data['stars'];
        $picture = $data['picture'];
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
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

            <p> <a href="../logout.php?logout">Logout</a></p>
        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <h1>Updating Hotel: <br> <em><?php $name ?></em></h1>
        </div>
    </div>

    <!------------------
   Form 
-------------------->

    <div class="container my-5">
        <form action="actions/a_update.php" method="post" enctype="multipart/form-data" class="mx-auto w-75">
            <div class="d-flex mb-3">
                <input name='name' type="text" placeholder="Name" class="w-50 me-5" value='<?php echo $name ?>'>
                <input name='stars' type="number" placeholder="Stars (max 5)" class="w-50" value='<?php echo $stars ?>'>
            </div>
            <div class="d-flex mb-3">
                <input name='location' type="text" placeholder="location" class="w-50 me-5" value='<?php echo $location ?>'>

                <input name='price' type="text" placeholder="Price per night $" class="w-50" value='<?php echo $price ?>'>
            </div>
            <input name='picture' type="file" placeholder="picture" class="w-100 mb-5">


            <input type="hidden" name="hotel_id" value="<?php echo $data['hotel_id'] ?>">
            <input type="hidden" name="picture" value="<?php echo $data['picture'] ?>">

            <a href="../dashboard.php"><button class="btn btn-outline-dark w-100 me-5 mb-3" type='button'>Go Back</button></a>

            <button type='submit' class="btn btn-outline-dark w-100">Save Changes</button>
        </form>


    </div>


</body>

</html>