<!DOCTYPE html>
<html>
<head>
    <title>eLeave Management System</title>
</head>
<body>

<?php
// Include the database connection file
include("header.php");
?>

<h2>Delete Employee Record</h2>

<?php
// Validate the userID passed via GET or POST
if ((isset($_GET['id']) && !empty($_GET['id']))) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
} elseif ((isset($_POST['id']) && !empty($_POST['id']))) {
    $id = mysqli_real_escape_string($connect, $_POST['id']);
} else {
    echo '<p class="error">This page has been accessed in error. Invalid or missing user ID.</p>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If the form is submitted
    if ($_POST['sure'] == 'Yes') {
        // Prepare and execute the DELETE query
        $q = "DELETE FROM user WHERE userID = '$id' LIMIT 1";
        $result = mysqli_query($connect, $q);

        if (mysqli_affected_rows($connect) == 1) {
            // Successfully deleted
            echo '<script>alert("The user has been deleted.");
            window.location.href = "admin_home.php";</script>';
        } else {
            // Deletion failed
            echo '<p class="error">The record could not be deleted.<br>
            It may not exist, or there was a system error.</p>';
            echo '<p>' . mysqli_error($connect) . '<br>Query: ' . $q . '</p>';
        }
    } else {
        // User chose not to delete
        echo '<script>alert("The employee has NOT been deleted.");
        window.location.href = "admin_home.php";</script>';
    }
} else {
    // Display the confirmation form
    $q = "SELECT userName FROM user WHERE userID = '$id'";
    $result = mysqli_query($connect, $q);

    if (mysqli_num_rows($result) == 1) {
        // User found
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        echo "<h3>Are you sure you want to permanently delete $row[0]?</h3>";
        echo '<form action="userDelete.php" method="post">
                <input type="submit" name="sure" value="Yes">
                <input type="submit" name="sure" value="No">
                <input type="hidden" name="id" value="' . $id . '">
              </form>';
    } else {
        // User not found
        echo '<p class="error">This page has been accessed in error. The user does not exist.</p>';
    }
}

// Close the database connection
mysqli_close($connect);
?>

</body>
</html>