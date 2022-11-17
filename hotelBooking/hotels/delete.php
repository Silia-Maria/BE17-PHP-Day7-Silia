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
    $data = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
        $name = $data['name'];
        $price = $data['price'];
        $location = $data['location'];
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
    <title>Delete - Atlantic Hotel Booking</title>
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
            <h1>Delete request for: <br> <?php echo $name ?></h1>
        </div>
    </div>
    <!------------------
 Content
-------------------->
    <div class="container">

        <div class="d-flex">
            <img src="pictures/<?php echo $picture ?>" class="user-pic">
            <h5><?php echo $name ?> Stars: <?php echo $stars ?></h5>
        </div>
        <div class="d-flex">
            <p>Location: <?php echo $location ?></p>
            <p>Price Per Night: $ <?php echo $price ?></p>
        </div>

        <h3>Do you really want to delelte this hotel?</h3>
        <form action="actions/a_delete.php" method="post">
            <input type="hidden" name="hotel_id" value="<?php echo $data['hotel_id'] ?>">
            <input type="hidden" name="picture" value="<?php echo $data['picture'] ?>">
            <button class="btn btn-outline-black" type="submit">Yes, delete it!</button>
            <a href="../dashboard.php"><button class="btn btn-outline-black" type="button">No, go back!</button></a>
        </form>

    </div>


</body>

</html>