<!DOCTYPE html>
<html>
<head>
    <title>eLeave Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php
    include("header.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $role = $_POST['role'];
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "mentormentee";

        // Connect to the single database
        $connect = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if (!$connect) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        if (!empty($_POST['userID'])) {
            $id = mysqli_real_escape_string($connect, $_POST['userID']);
        } else {
            $id = FALSE;
            echo '<p class="error">You forgot to enter your ID.</p>';
        }

        if (!empty($_POST['userPassword'])) {
            $p = mysqli_real_escape_string($connect, $_POST['userPassword']);
        } else {
            $p = FALSE;
            echo '<p class="error">You forgot to enter your password.</p>';
        }

        if ($id && $p) {
            // Determine the table based on the role
            $table = "";
            switch ($role) {
                case 'admin':
                    $table = "admin";
                    break;
                case 'mentor':
                    $table = "mentor";
                    break;
                case 'mentee':
                    $table = "mentee";
                    break;
            }

            // Query the appropriate table
            $q = "SELECT userID, userPassword, userName, userPhoneNo, userEmail, userAddress, userPosition, userTotalLeave
                  FROM $table WHERE (userID='$id' AND userPassword='$p')";
            $result = mysqli_query($connect, $q);

            if (@mysqli_num_rows($result) == 1) {
                session_start();
                $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);

                echo '<p>Welcome to eLeave System</p>';
                exit();

                mysqli_free_result($result);
                mysqli_close($connect);
            } else {
                echo '<p class="error">The userID and userPassword entered do not match our records.</p>';
            }
        } else {
            echo '<p class="error">Please try again.</p>';
        }
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Making Mentorship Meaningful</h1>
                <p>Welcome back! Log in to your account and continue the journey of mentorship.</p>
            </div>
            <div class="col-md-4">
                <form action="userLogin.php" method="POST">
                    <div class="form-group">
                        <label for="userID">User ID:</label>
                        <input type="text" id="userID" name="userID" size="4" maxlength="6" required
                               value="<?php if (isset($_POST['userID'])) echo $_POST['userID']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="userPassword">Password:</label>
                        <input type="password" id="userPassword" name="userPassword" size="15" maxlength="60"
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter and at least 8 or more characters"
                               required value="<?php if (isset($_POST['userPassword'])) echo $_POST['userPassword']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Role:</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="role" value="admin" id="admin" required>
                            <label class="form-check-label" for="admin">Admin</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="role" value="mentor" id="mentor" required>
                            <label class="form-check-label" for="mentor">Mentor</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="role" value="mentee" id="mentee" required>
                            <label class="form-check-label" for="mentee">Mentee</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
