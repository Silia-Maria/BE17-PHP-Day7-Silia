<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: home.php");
}
if (isset($_SESSION['adm']) != "") {
    header("location: dashboard.php");
}

require_once "components/db_connect.php";
require_once "components/file_upload.php";

$error = false;
$fname = $lname = $email = $pass = $date_of_birth = $picture = "";
$fnameError = $lnameError = $emailError = $passError = $dateError = $picError = "";

if (isset($_POST['btn-register'])) {
    $fname = trim($_POST['fname']);
    $fname = strip_tags($fname);
    $fname = htmlspecialchars($fname);

    $lname = trim($_POST['lname']);
    $lname = strip_tags($lname);
    $lname = htmlspecialchars($lname);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $date_of_birth = trim($_POST['date_of_birth']);
    $date_of_birth = strip_tags($date_of_birth);
    $date_of_birth = htmlspecialchars($date_of_birth);

    $uploadError = "";
    $picture = file_upload($_FILES['picture']);

    // name Validation 
    if (empty($fname) || empty($lname)) {
        $error = true;
        $fnameError = "Please enter your Name and Surname.";
    } else if (strlen($fname) < 3 || strlen($lname) < 3) {
        $error = true;
        $fnameError = "Name and Surname must contain at least 3 Characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
        $error = true;
        $fnameError = "Name and Surname can only contain letters and no space";
    }

    // email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address.";
    } else {
        // check if Email exists already 
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email already in use.";
        }
    }
    // date left empty?
    if (empty($date_of_birth)) {
        $error = true;
        $dateError = "Please enter your date of birth.";
    }
    //password Validation 
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter a password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must at least contain 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $pass);

    // if there is no error
    if (!$error) {
        $query = "INSERT INTO users (first_name, last_name, email, password, date_of_birth, picture) VALUES ('$fname', '$lname', '$email', '$password', '$date_of_birth', '$picture->fileName')";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now <br> <a href='index.php'>Click Here!</a>.";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, please try again.";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
        }
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
    <title>Registration - Atlantic Hotel Booking</title>
    <?php require_once "components/style.php" ?>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data" class="mx-auto w-75">
            <h2>Sign Up</h2>
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>

            <input type="text" class="w-100 mb-4" name="fname" placeholder="First Name" value="<?php echo $fname ?>">
            <span class="text-danger"><?php echo $fnameError ?></span>

            <input type="text" class="w-100 mb-4" name="lname" placeholder="Last Name" value="<?php echo $lname ?>">
            <span class="text-danger"><?php echo $fnameError ?></span>



            <input type="text" class="w-100 mb-4" name="email" placeholder="Email Address" value="<?php echo $email ?>">
            <span class="text-danger"><?php echo $emailError ?></span>

            <input type="date" class="w-100 mb-4" name="date_of_birth" value="<?php echo $date_of_birth ?>">
            <span class="text-danger"><?php echo $dateError ?></span>

            <input type="file" class="w-100 mb-4" name="picture">
            <span class="text-danger"><?php echo $picError ?></span>

            <input type="password" class="w-100 mb-5" name="password" placeholder="Password">
            <span class="text-danger"><?php echo $passError ?></span>



            <button class="btn btn-outline-dark w-100 mb-4" name="btn-register">Sign up</button>
            <p class="text-center">Already registered? <a href="index.php">Log in here!</a></p>

        </form>


    </div>

</body>

</html>