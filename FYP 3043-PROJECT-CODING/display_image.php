<?php
$connect = mysqli_connect("localhost", "root", "", "mentormentee");

if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);

    // Fetch the image data
    $query = "SELECT userImage FROM user WHERE userID = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $userImage);
    mysqli_stmt_fetch($stmt);

    if ($userImage) {
        // Set the content type header to display the image
        header("Content-Type: image/jpeg");
        echo $userImage;
    } else {
        echo "Image not found.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>
