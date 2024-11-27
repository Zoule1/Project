<!DOCTYPE html>
<html>
<head>
    <title>eLeave Management System</title>
</head>
<body>
<?php
// Include the header file
include("header.php");

// Check if the ID is provided via GET or POST
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
} elseif (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = mysqli_real_escape_string($connect, $_POST['id']);
} else {
    // Display an error if ID is missing or invalid
    echo '<p class="error">This page has been accessed in error. ID is missing or invalid.</p>';
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = []; // Initialize an error array

    // Validate userName
    if (empty($_POST['userName'])) {
        $errors[] = 'You forgot to enter the employee name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['userName']));
    }

    // Validate userPhoneNo
    if (empty($_POST['userPhoneNo'])) {
        $errors[] = 'You forgot to enter the phone number.';
    } else {
        $ph = mysqli_real_escape_string($connect, trim($_POST['userPhoneNo']));
    }

    // Validate userEmail
    if (empty($_POST['userEmail'])) {
        $errors[] = 'You forgot to enter the email.';
    } else {
        $e = mysqli_real_escape_string($connect, trim($_POST['userEmail']));
    }

    // Validate userAddress
    if (empty($_POST['userAddress'])) {
        $errors[] = 'You forgot to enter the address.';
    } else {
        $ad = mysqli_real_escape_string($connect, trim($_POST['userAddress']));
    }

    // Validate userIC
    if (empty($_POST['userIC'])) {
        $errors[] = 'You forgot to enter the IC.';
    } else {
        $ic = mysqli_real_escape_string($connect, trim($_POST['userIC']));
    }

    // Validate userCourse
    if (empty($_POST['userCourse'])) {
        $errors[] = 'You forgot to enter the course.';
    } else {
        $course = mysqli_real_escape_string($connect, trim($_POST['userCourse']));
    }

    // Validate userSem
    if (empty($_POST['userSem'])) {
        $errors[] = 'You forgot to enter the semester.';
    } else {
        $sem = mysqli_real_escape_string($connect, trim($_POST['userSem']));
    }

    // Validate userWeakness
    if (empty($_POST['userWeakness'])) {
        $errors[] = 'You forgot to enter the weakness.';
    } else {
        $weakness = mysqli_real_escape_string($connect, trim($_POST['userWeakness']));
    }

    // If no errors, proceed to update the record
    if (empty($errors)) {
        $q = "UPDATE user SET 
                userName = '$n', 
                userPhoneNo = '$ph',
                userEmail = '$e', 
                userAddress = '$ad',
                userIC = '$ic', 
                userCourse = '$course', 
                userSem = '$sem', 
                userWeakness = '$weakness' 
              WHERE userID = '$id' LIMIT 1";
        $result = mysqli_query($connect, $q);

        if (mysqli_affected_rows($connect) == 1) {
            echo '<script>alert("The user has been updated successfully.");
            window.location.href = "admin_home.php";</script>';
        } else {
            echo '<p class="error">The user could not be updated due to a system error.</p>';
            echo '<p>' . mysqli_error($connect) . '<br>Query: ' . $q . '</p>';
        }
    } else {
        // Display the errors
        echo '<p class="error">The following errors occurred:<br>';
        foreach ($errors as $msg) {
            echo "- $msg<br>";
        }
        echo '</p><p>Please try again.</p>';
    }
}

// Fetch the existing user data
$q = "SELECT userName, userPhoneNo, userEmail, userAddress, userIC, userCourse, userSem, userWeakness 
      FROM user WHERE userID = '$id'";
$result = mysqli_query($connect, $q);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Display the form with pre-filled data
    echo '<form action="userUpdate.php" method="post">
    <p><label for="userName">Employee Name*:</label>
    <input type="text" id="userName" name="userName" size="30" maxlength="50" value="' . $row['userName'] . '"></p>

    <p><label for="userPhoneNo">Phone No*:</label>
    <input type="tel" pattern="[0-9]{3}-[0-9]{7}" id="userPhoneNo" name="userPhoneNo" size="15" maxlength="20" value="' . $row['userPhoneNo'] . '"></p>

    <p><label for="userEmail">Email*:</label>
    <input type="email" id="userEmail" name="userEmail" size="30" maxlength="50" value="' . $row['userEmail'] . '"></p>

    <p><label for="userAddress">Address:</label>
    <input type="text" id="userAddress" name="userAddress" size="30" maxlength="50" value="' . $row['userAddress'] . '"></p>

    <p><label for="userIC">IC*:</label>
    <input type="text" id="userIC" name="userIC" size="20" maxlength="20" value="' . $row['userIC'] . '"></p>

    <p><label for="userCourse">Course*:</label>
    <input type="text" id="userCourse" name="userCourse" size="30" maxlength="50" value="' . $row['userCourse'] . '"></p>

    <p><label for="userSem">Semester*:</label>
    <input type="text" id="userSem" name="userSem" size="5" maxlength="5" value="' . $row['userSem'] . '"></p>

    <p><label for="userWeakness">Weakness:</label>
    <input type="text" id="userWeakness" name="userWeakness" size="30" maxlength="50" value="' . $row['userWeakness'] . '"></p>

    <p><input type="submit" name="submit" value="Update"></p>
    <input type="hidden" name="id" value="' . $id . '">
    </form>';
} else {
    echo '<p class="error">This page has been accessed in error. User not found.</p>';
}

mysqli_close($connect); // Close the database connection
?>
</body>
</html>
