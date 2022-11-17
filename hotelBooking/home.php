<?php
session_start();
require_once "components/db_connect.php";

if (isset($_SESSION['adm'])) {
    header("location: dashboard.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: index.php");
    exit;
}

// select logged in user details
$result = mysqli_query($connect, "SELECT * FROM users WHERE user_id =" . $_SESSION['user']);
$row = mysqli_fetch_assoc($result);

$query_hotels = "SELECT * FROM hotels";
$resHotels = mysqli_query($connect, $query_hotels);
$hotelcard = "";

if (mysqli_num_rows($resHotels) > 0) {
    while ($rowHotels = mysqli_fetch_assoc($resHotels)) {
        $hotelcard .= " <div class='row my-5'>
        <img src='./pictures/$rowHotels[picture]' class='col-6' alt='...'>
        <div class='col-6 '>
            <div class='m-5'>
                <h3 class='mb-5'>$rowHotels[name] <span>stars</span></h3>
                <p>Luxury Hotel in:</p>
                <p>$rowHotels[location]</p>
                <p>$rowHotels[price]</p>

                <form method='post' action='hotels/booking.php'>
                <input type='hidden' name='hotel_id' value='" . $rowHotels['hotel_id'] . "'/>
                <button type='submit' name='submit' class='btn btn-outline-dark'>book</button>
                </form>
                
            </div>
        </div>
    </div>";
    }
}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Atlantic Hotel Booking</title>
    <?php require_once "components/style.php"; ?>
    <link rel="stylesheet" href="style.css">
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

            <p class="nav-link">Welcome <?php echo $row['first_name'] . " " . $row['last_name'] ?></p>
            <p> <a href="logout.php?logout">Logout</a></p>
            <p> <a href="update.php?id=<?php echo $_SESSION['user'] ?>">Update Profile</a></p>
        </div>
    </nav>

    <!------------------
    Hero
-------------------->

    <div class="hero">
        <div class="hero-text text-center">
            <h2>Experience the best Hotels around the World!</h2>
            <a href="">have a look at our best offers!</a>
        </div>

    </div>

    <!------------------
   Hotels
-------------------->
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2>Welcome to Atlantic Hotel Booking</h2>
            <div class="mb-3">____</div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis expedita deserunt modi blanditiis quia eius architecto exercitationem obcaecati recusandae reiciendis. Modi id similique earum velit accusantium culpa, ipsa et praesentium?</p>
        </div>

        <?php echo $hotelcard ?>
        <!-- <div class="row my-3">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" class="col-6" alt="...">
            <div class="col-6 ">
                <div class="m-5">
                    <h3 class="mb-5">hotelname <span>stars</span></h3>
                    <p>Luxury Hotel in:</p>
                    <p>location</p>
                    <p>price</p>
                    <button type="button" class="btn btn-outline-dark">book</button>
                </div>
            </div>
        </div> -->
    </div>
</body>

</html>