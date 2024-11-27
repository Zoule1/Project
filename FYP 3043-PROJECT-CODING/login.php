<?php
// Start the session
session_start();

// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "mentormentee");

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize error message
$error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Check form data
    $id = mysqli_real_escape_string($connect, $_POST["id"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);
    $role = mysqli_real_escape_string($connect, $_POST["role"]);

    // Debugging: Check form input values
    "User ID: " . $id . "<br>";
    "Password: " . $password . "<br>";
 "Role: " . $role . "<br>";

    // Query based on user role
    if ($role == 'admin') {
        $query = "SELECT * FROM admin WHERE adminID = '$id' AND adminPassword = '$password'";
        $redirect_page = 'admin_home.php';
    } elseif ($role == 'mentor') {
        $query = "SELECT * FROM mentor WHERE MentorID = '$id' AND MentorPassword = '$password'";
        $redirect_page = 'mentor_home.php';
    } elseif ($role == 'user') {
        $query = "SELECT * FROM user WHERE UserID = '$id' AND UserPassword = '$password'";
        $redirect_page = 'student_home.php';
    }

    // Debugging: Check the query
    "Executing query: " . $query . "<br>";

    // Execute the query
    $result = mysqli_query($connect, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($connect));  // Show MySQL error
    }

    // Check if a match is found
    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        
        // Start the session for logged-in user
        if ($role == 'admin') {
            $_SESSION['adminID'] = $user_data['id'];
        } elseif ($role == 'mentor') {
            $_SESSION['mentorID'] = $user_data['MentorID'];
        } elseif ($role == 'user') {
            $_SESSION['userID'] = $user_data['userID'];
        }

        // Debugging: Check session data
        echo "Session set for user: " . $_SESSION['userID'] . "<br>";

        // Redirect based on the role
        header("Location: $redirect_page");
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid ID, password, or role. Please try again.";
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background: linear-gradient(135deg, #6e7dff, #55c7ff);
            color: #fff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        h1 {
            text-align: center;
            color: #022F40;
            margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        p {
            text-align: center;
            color: #ccc;
            font-size: 1.2em;
            margin-bottom: 40px;
        }

        form {
            background-color: #263238;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ccc;
            font-size: 1.1em;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #000000;
            border-radius: 4px;
            font-size: 1em;
            color: #fff;
            background-color: #546e7a;
        }

        button {
            background-color: #15ff1d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #2276ad;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .col-md-4 {
            background-color: #274060  ;
            color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeInRight 1s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Logo styles */
        .logo-left {
            position: absolute;
            top: 10px;
            left: 10px;
            height: 100px;
        }

        .logo-right {
            position: absolute;
            top: 0px;
            right: 10px;
            height: 170px;
        }
    </style>
</head>
<body>
    <!-- Add logos -->
    <img src="Logo.png" alt="Logo Left" class="logo-left">
    <img src="Fcom.png" alt="Logo Right" class="logo-right">

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>WELCOME TO UPTM MENTORSHIP SYSTEM</h1>
                <p>Log in to your account and continue the journey of mentorship.</p>
            </div>
            <div class="col-md-4">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <input type="text" class="form-control" name="id" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" required>
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
                            <input type="radio" class="form-check-input" name="role" value="user" id="user" required>
                            <label class="form-check-label" for="user">Student</label>
                        </div>
                    </div>

                    <?php
                        if (!empty($error_message)) {
                            echo "<div class='alert alert-danger'>$error_message</div>";
                        }
                    ?>

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
