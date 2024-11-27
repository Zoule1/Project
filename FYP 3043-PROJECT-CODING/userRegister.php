<?php
// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "mentormentee");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array(); // Initialize an error array

    // Check for userPassword
    if (empty($_POST['userPassword'])) {
        $error[] = 'You forgot to enter the password.';
    } else {
        $p = mysqli_real_escape_string($connect, trim($_POST['userPassword']));
    }

    // Check for userName
    if (empty($_POST['userName'])) {
        $error[] = 'You forgot to enter your name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['userName']));
    }

    if (empty($_POST['userID'])) {
        $error[] = 'You forgot to enter your phone IC.';
    } else {
        $id = mysqli_real_escape_string($connect, trim($_POST['userID']));
    }

    // Check for userIC
    if (empty($_POST['userIC'])) {
        $error[] = 'You forgot to enter your phone IC.';
    } else {
        $ic = mysqli_real_escape_string($connect, trim($_POST['userIC']));
    }

     // Check userCourse
     if (empty($_POST['userCourse'])) {
        $error[] = 'You forgot to enter your course.';
    } else {
        $cou = mysqli_real_escape_string($connect, trim($_POST['userCourse']));
    }

    // Check for userSem
    if (empty($_POST['userSem'])) {
        $error[] = 'You forgot to enter your semester.';
    } else {
        $sem = mysqli_real_escape_string($connect, trim($_POST['userSem']));
    }

     // Check userWeakness
     if (empty($_POST['userWeakness'])) {
        $error[] = 'You forgot to enter your course.';
    } else {
        $wea = mysqli_real_escape_string($connect, trim($_POST['userWeakness']));
    }

    // Check for userPhoneNo
    if (empty($_POST['userPhoneNo'])) {
        $error[] = 'You forgot to enter your phone number.';
    } else {
        $ph = mysqli_real_escape_string($connect, trim($_POST['userPhoneNo']));
    }

    // Check for userEmail
    if (empty($_POST['userEmail'])) {
        $error[] = 'You forgot to enter your email.';
    } else {
        $e = mysqli_real_escape_string($connect, trim($_POST['userEmail']));
    }

    // Check for userAddress
    if (empty($_POST['userAddress'])) {
        $error[] = 'You forgot to enter your address.';
    } else {
        $ad = mysqli_real_escape_string($connect, trim($_POST['userAddress']));
    }

    // Check for userImage and read binary data
    if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] == 0) {
        // Get image file content as binary data
        $img = file_get_contents($_FILES['userImage']['tmp_name']);
        $img = mysqli_real_escape_string($connect, $img);
    } else {
        $error[] = 'You forgot to upload an image.';
    }

    // If there are no errors, proceed with database entry
    if (empty($error)) {
        $q = "INSERT INTO user (userID, userPassword, userName, userIC, userCourse, userSem, userWeakness, userPhoneNo, userEmail, userAddress, userImage) 
              VALUES ('$id', '$p', '$n', '$ic', '$cou', '$sem', '$wea', '$ph', '$e', '$ad', '$img')";
        $result = @mysqli_query($connect, $q);

        if ($result) { // If it runs successfully
             echo '<script>alert("Registration successful");
                    window.location.href = "admin_home.php";</script>';
        } else { // If it didn't run
            echo '<h1>System Error</h1>';
            echo '<p>' . mysqli_error($connect) . '<br><br>Query: ' . $q . '</p>';
        }
    } else { // Report the errors
        echo '<h1>Error!</h1><p>The following error(s) occurred:<br>';
        foreach ($error as $msg) {
            echo " - $msg<br>";
        }
        echo '</p><p>Please try again.</p>';
    }

    mysqli_close($connect); // Close the database connection
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>Register User</h2>
    <form action="userRegister.php" method="post" enctype="multipart/form-data">
        <!-- Form fields for user details -->
        <div>
            <label for="userPassword">Password:</label>
            <input type="password" id="userPassword" name="userPassword" required>
        </div>
        <div>
            <label for="userName">Full Name:</label>
            <input type="text" id="userName" name="userName" required>
        </div>
        <div>
            <label for="userPhoneNo">Phone No.:</label>
            <input type="tel" id="userPhoneNo" name="userPhoneNo" required>
        </div>
        <div>
            <label for="userEmail">Email:</label>
            <input type="email" id="userEmail" name="userEmail" required>
        </div>
        <div>
            <label for="userAddress">Address:</label>
            <textarea id="userAddress" name="userAddress" required></textarea>
        </div>
        <div>
            <label for="userImage">Upload Image:</label>
            <input type="file" id="userImage" name="userImage" accept="image/*" required>
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</body>
</html>
