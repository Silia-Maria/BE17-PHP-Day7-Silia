<?php
session_start();
require_once "components/db_connect.php";
require_once "components/file_upload.php";

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: index.php");
    exit;
}

$backBtn = "";
//user
if (isset($_SESSION['user'])) {
    $backBtn = "home.php";
}

//adm
if (isset($_SESSION['adm'])) {
    $backBtn = "dashboard.php";
}

//fetch and populate form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id={$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $fname = $data['first_name'];
        $lname = $data['last_name'];
        $email = $data['email'];
        $picture = $data['picture'];
        $date_of_birth = $data['date_of_birth'];
    }
}

//update
$class = 'd-none';
if (isset($_POST['submit'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $id = $_POST['id'];
    $uplpoadError = "";
    $pictureArray = file_upload($_FILES['picture']);
    $picture = $pictureArray->fileName;
    if ($pictureArray->error === 0) {
        ($_POST['picture'] == "user.jpg") ?: unlink("pictures/{$_POST['picture']}");
        $sql = "UPDATE users SET first_name='$fname', last_name='$lname', email='$email', date_of_birth='$date_of_birth', picture='$pictureArray->fileName' WHERE user_id = {$id}";
    } else {
        $sql = "UPDATE users SET first_name='$fname', last_name='$lname', email='$email', date_of_birth='$date_of_birth' WHERE user_id = {$id}";
    }

    if (mysqli_query($connect, $sql) === TRUE) {
        $icon = "<i class='fa-regular fa-circle-check text-success icon-alert'></i>";
        $message = "<div> Your Profile was successfully updated!</div>";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : "";
        header("refresh:3;url=update.php?id={$id}");
    } else {
        $icon = "<i class='fa-regular fa-circle-xmark text-danger'></i>";
        $message = "Error while updating your Profile. Please try again.. <br>" . mysqli_connect_error();
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : "";
        header("refresh:3;url=update.php?id={$id}");
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
    <?php require_once "components/style.php" ?>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
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
            <img src="pictures/<?php echo $data['picture'] ?>" alt="" width='150' height='150' class="dashboard-pic">
            <h1><?php $data['first_name'] . " " . $data['last_name'] ?></h1>
        </div>
    </div>

    <!------------------
 Alert
-------------------->

    <div class="container mt-5">
        <div class="w-50 mx-auto border rounded text-center p-5">
            <div class="mb-4"><?php echo ($icon) ?? ""; ?></div>
            <h5><?php echo ($message) ?? ""; ?></h5>

        </div>

    </div>
    <!------------------
Form
-------------------->
    <div class="container my-5">
        <form method="post" enctype="multipart/form-data" class="mx-auto w-75">

            <input name='first_name' type="text" placeholder="First Name" class="w-100 mb-3" value='<?php echo $fname ?>'>

            <input name='last_name' type="text" placeholder="Last Name" class="w-100 mb-3" value='<?php echo $lname ?>'>


            <input name='email' type="text" placeholder="Email" class="w-100 mb-3" value='<?php echo $email ?>'>

            <input name='date_of_birth' type="date" placeholder="Date of Birth" value='<?php echo $date_of_birth ?>' class="w-100 mb-3">

            <input name='picture' type="file" class="w-100 mb-5" <?php echo $picture ?>'>




            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="picture" value="<?php echo $picture ?>">

            <a href="<?php echo $backBtn ?>"><button class="btn btn-outline-dark w-100 me-5 mb-3" type='button'>Go Back</button></a>

            <button type='submit' name="submit" class="btn btn-outline-dark w-100">Save Changes</button>
        </form>


    </div>

</body>

</html>