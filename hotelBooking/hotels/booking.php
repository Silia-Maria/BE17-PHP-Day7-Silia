<?php
session_start();
if (isset($_SESSION['adm']) != "") {
    header("location: ../dashboard.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}
require_once "../components/db_connect.php";

// Select all from hotels and make booking body
if ($_POST) {
    $hotel_id = ($_POST['hotel_id']);
    $query = "SELECT * FROM hotels WHERE hotel_id = {$hotel_id}";
    $hotel_res = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($hotel_res);
    $name = $data['name'];
    $price = $data['price'];
    $location = $data['location'];
    $picture = $data['picture'];
    $stars = $data['stars'];
}

$query_user = "SELECT * FROM users WHERE user_id = {$_SESSION['user']}";
$user_res = mysqli_query($connect, $query_user);
$data_user = mysqli_fetch_assoc($user_res);
$fname = $data_user['first_name'];
$lname = $data_user['last_name'];
$date_of_birth = $data_user['date_of_birth'];
$picture_user = $data_user['picture'];
$email = $data_user['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Atlantic Hotel Booking</title>
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
            <h1>New Hotels <br> coming to Atlantic Hotel Booking...</h1>
        </div>
    </div>

    <!------------------
 Form
-------------------->
    <div class="container">
        <div class="text-center mb-5">
            <h2>Let's get started with your booking!</h2>
            <div class='row my-5'>
                <img src='../pictures/<?php echo $picture; ?>' class='col-6' alt='...'>
                <div class='col-6 '>
                    <div class='m-5'>
                        <h3 class='mb-5'><?php echo $name; ?><span>stars</span></h3>
                        <p>Luxury Hotel in:</p>
                        <p><?php echo $location ?></p>
                        <p>$<?php echo $price ?></p>

                        <form method='post' action='booking.php'>
                            <input type='hidden' name='hotel_id' value='" . $rowHotels[' hotel_id'] . "'/>
                <button type='submit' name='submit' class='btn btn-outline-dark'>book</button>
                </form>
                
            </div>
        </div>
    </div>

            <form action=" actions/a_booking.php" method="post">
                            <input type="hidden" name='hotel_id' value='<?php echo $hotel_id ?>'>
                            <a href="../home.php" class="btn btn-outline-dark">Go Back</a>
                            <button type="submit" name='submit'>Yes, Book!</button>
                        </form>

                    </div>
</body>

</html>