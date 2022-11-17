<?php
// only available for admin!!
session_start();
require_once "components/db_connect.php";

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION['user'])) {
    header("location: home.php");
    exit;
}

$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE status != '$status'";
$result = mysqli_query($connect, $sql);

// Body for displaying the users
$tbody = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
        <td class='d-flex justify-content-between'>
            <img src='pictures/" . $row['picture'] . "' alt='' class='user-pic'>
            <p>" . $row['first_name'] . " " . $row['last_name'] . "</p>
        </td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['date_of_birth'] . "</td>
        <td>" . $row['fk_booking_id'] . "</td>
        <td>
        <a>Edit</a>
        <a>Delete</a>
        </td>
    </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

// adm details
$query = "SELECT * FROM users WHERE status = '$status'";
$result_adm = mysqli_query($connect, $query);
if ($result_adm->num_rows > 0) {
    $row_adm = mysqli_fetch_assoc($result_adm);
    $adm_name = $row_adm['first_name'] . " " . $row_adm['last_name'];
}

// Hotels 
$sql_hotels = "SELECT * FROM hotels";
$result_hotels = mysqli_query($connect, $sql_hotels);
$hotel_body = "";

if ($result_hotels->num_rows > 0) {
    while ($row_hotels = $result_hotels->fetch_array(MYSQLI_ASSOC)) {
        $hotel_body .= "<tr>
        <td class='d-flex justify-content-between'>
            <img src='pictures/" . $row_hotels['picture'] . "' alt='' class='user-pic'>
            <p>" . $row_hotels['name'] . "</p>
        </td>
        <td>" . $row_hotels['stars'] . "</td>
        <td>" . $row_hotels['location'] . "</td>
        <td>" . $row_hotels['price'] . "</td>
        <td>
        <a>Edit</a>
        <a>Delete</a>
        </td>
    </tr>";
    }
} else {
    $hotel_body = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Atlantic Hotel Booking</title>
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

            <p> <a href="logout.php?logout">Logout</a></p>
        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <img src="pictures/<?php echo $row_adm['picture'] ?>" alt="" width='150' height='150' class="dashboard-pic">
            <h3 class="mt-3"><?php echo $adm_name ?></h3>
        </div>
    </div>

    <!------------------
 User Table
-------------------->
    <div class="container mt-5">
        <!--User Table-->
        <h2>Users</h2>
        <hr>
        <table class="table mb-5">
            <thead class="text-uppercase">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Booking</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tbody ?>
            </tbody>
        </table>

        <!--Hotels table-->
        <div class="d-flex justify-content-between">
            <h2>Hotels</h2>
            <a href="hotels/create.php"> <button class="btn btn-sm btn-outline-dark"> add new hotel</button></a>
        </div>
        <hr>
        <table class="table">
            <thead class="text-uppercase">
                <tr>
                    <th>Name</th>
                    <th>Stars</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $hotel_body ?>
            </tbody>

        </table>


    </div>

</body>

</html>