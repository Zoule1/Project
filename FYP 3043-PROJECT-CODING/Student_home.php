<?php
// Start session to access the logged-in user's ID
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // If no user is logged in, redirect to login page or handle the error
    header("Location: login.php");
    exit();
}

// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "mentormentee");

// Get the logged-in user's ID from the session
$userID = $_SESSION['userID'];

// Run query to fetch data for the logged-in user
$q_student = "SELECT userID, userPassword, userName, userIC, userCourse, userSem, userWeakness, userPhoneNo, userEmail, userAddress, userImage FROM user WHERE userID = '$userID'";
$result_student = @mysqli_query($connect, $q_student);

// Check if there is a result
if ($student = mysqli_fetch_assoc($result_student)) {
    // Student data fetched successfully
} else {
    // Handle case where no student is found (e.g., wrong userID or no data)
    echo "No student found.";
}

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "mentormentee");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the logged-in user's ID
$userID = $_SESSION['userID'];

// Fetch the user's weakness
$q_user_weakness = "SELECT userWeakness FROM user WHERE userID = '$userID'";
$result_user_weakness = mysqli_query($connect, $q_user_weakness);

if (!$result_user_weakness || mysqli_num_rows($result_user_weakness) == 0) {
    die("Could not fetch user weakness: " . mysqli_error($connect));
}

$user = mysqli_fetch_assoc($result_user_weakness);
$userWeakness = $user['userWeakness'];

// Query to get mentors who have a specialty matching the user's weakness
$q_mentors = "SELECT MentorID, MentorName, MentorSpeciality, MentorImage 
              FROM mentor 
              WHERE MentorSpeciality = '$userWeakness'";
$result_mentors = mysqli_query($connect, $q_mentors);

if (!$result_mentors) {
    die("Query failed: " . mysqli_error($connect));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>UPTM Mentorship</title>
    <link rel="stylesheet" href="admin.css">
    <script>
        // JavaScript for showing/hiding sections
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.info-field.form-field > div');
            sections.forEach(section => section.style.display = 'none');

            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) selectedSection.style.display = 'block';
        }

        // Display default section on page load
        window.onload = function() {
            showSection('Student_Profile');
        };
    </script>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
        }

        h1, h2 {
            color: #022F40;
            margin: 10px 0;
        }

        /* Navbar styling */
        nav {
            display: flex;
            align-items: center;
            background:  linear-gradient(135deg, #6e7dff, #55c7ff);
            padding: 15px;
            color: white;
            margin-left: 220px;
        }

        nav .logo img {
            height: 100px;
            margin-right: 150px;
            margin-left: 50px;
        }

        nav .dept h1 {
            font-size: 1.8em;
        }

        /* Sidebar styling */
        .sidebar {
            width: 220px;
            background:  linear-gradient(135deg, #6e7dff, #55c7ff);
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #022F40;
            text-decoration: none;
            font-weight: bold;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #B8B8F3;
            color: #2F284E;
        }

        /* Admin container styling */
        .admin-container {
            display: flex;
            margin-left: 240px;
            padding: 20px;
            background-color: #ecf0f1;
            min-height: 100vh;
        }

        .info-field {
            flex-grow: 1;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-field h2 {
            color: #2980b9;
            margin-bottom: 20px;
        }

        /* Resume Style */
        .resume {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 60%;
            margin: 0 auto;
            background-color: #f9f9f9;
        }

        .resume-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 20px;
        }

        .resume-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
        }

        .resume-header h2 {
            color: #2980b9;
            margin: 0;
        }

        .resume-header h3 {
            color: #34495e;
            margin: 5px 0;
        }

        .resume-section {
            width: 100%;
            margin-bottom: 20px;
        }

        .resume-section h3 {
            color: #00A36C;
        }

        .resume-section p {
            margin: 5px 0;
            font-size: 1.1em;
        }

        /* Chatroom Styling */
        #room__container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        #members__container, #stream__container, #messages__container {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        #members__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #messages {
            border: 1px solid #ddd;
            padding: 10px;
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 15px;
        }

        #message__form input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #message__form input:focus {
            outline: none;
            border-color: #00A36C;
        }

        .stream__actions button {
            background-color: #00A36C;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .stream__actions button:hover {
            background-color: #1abc9c;
        }

        /* Message Styling */
        .message {
            margin: 8px 0;
            padding: 10px;
            border-radius: 8px;
            background-color: #f1f1f1;
        }

        .message.user {
            background-color: #e0f7fa;
        }

        .message.participant {
            background-color: #f9fbe7;
        }
    </style>
</head>
<body>

    <?php include("header.php"); ?>

    <nav>
        <div class="logo">
            <img src="Logo.png" alt="logo">
        </div>
        <div class="dept">
            <h1>Mentor Mentee Management System</h1>
        </div>
    </nav>

    <div class="admin-container">
        <div class="sidebar">
            <ul>
                <li><a href="#" onclick="showSection('Student_Profile')">Student Profile</a></li>
                <li><a href="#" onclick="showSection('Mentorship_room')">Mentorship Room</a></li>
                <li><a href="lobby.html">Chatroom</a></li>
                <li><a href="UserManual.pdf">User Manual</a></li>
                <li><a href="login.php" onclick="showSection('Sign_out')">Sign Out</a></li>
            </ul>
        </div>

        <div class="info-field form-field">
            <div id="Student_Profile">
                <h2>Student Profile</h2>
                <?php if ($student): ?>
                    <div class="resume">
                        <div class="resume-header">
                            <?php
                                // Check if userImage exists and display it
                                if ($student['userImage']) {
                                    $img_data = base64_encode($student['userImage']);
                                    $image_path = 'data:image/jpeg;base64,' . $img_data;
                                } else {
                                    $image_path = 'uploads/default.jpg'; // Default image if no image is uploaded
                                }
                            ?>
                            <img src="<?php echo $image_path; ?>" alt="Student Photo">
                            <div>
                                <h2><?php echo $student['userName']; ?></h2>
                                <h3>User ID: <?php echo $student['userID']; ?></h3>
                            </div>
                        </div>
                        <div class="resume-section">
                            <h3>Student Information</h3>
                            <p><strong>IC:</strong> <?php echo $student['userIC']; ?></p>
                            <p><strong>Course:</strong> <?php echo $student['userCourse']; ?></p>
                            <p><strong>Semester:</strong> <?php echo $student['userSem']; ?></p>
                            <p><strong>Phone:</strong> <?php echo $student['userPhoneNo']; ?></p>
                            <p><strong>Email:</strong> <?php echo $student['userEmail']; ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No student profile found.</p>
                <?php endif; ?>
            </div>

      <div id="Mentorship_room">
    <h2>Mentorship Room</h2>

    <?php
    // Loop through each mentor who matches the user's weakness
    while ($mentor = mysqli_fetch_assoc($result_mentors)) {
        $mentorID = $mentor['MentorID'];
        $mentorName = $mentor['MentorName'];
        $mentorImage = $mentor['MentorImage'] ? base64_encode($mentor['MentorImage']) : 'uploads/default.jpg';

        // Display mentor's details
        echo "<div class='mentor'>";
        echo "<div class='resume-header'>";
        echo "<img src='data:image/jpeg;base64," . $mentorImage . "' alt='Mentor Photo'>";
        echo "<div><h2>$mentorName</h2><h3>Specialty: $userWeakness</h3></div>";
        echo "</div>";

        // Get mentees who have the same weakness and are limited to 20
        $q_mentees = "SELECT userID, userName, userCourse, userSem, userPhoneNo, userImage 
                      FROM user 
                      WHERE userWeakness = '$userWeakness' 
                      LIMIT 20";
        $result_mentees = mysqli_query($connect, $q_mentees);

        if (!$result_mentees) {
            die("Query failed: " . mysqli_error($connect));
        }

        // Check if there are any matching mentees
        if (mysqli_num_rows($result_mentees) > 0) {
            while ($mentee = mysqli_fetch_assoc($result_mentees)) {
                $menteeID = $mentee['userID'];
                $menteeName = $mentee['userName'];
                $menteeCourse = $mentee['userCourse'];
                $menteeSemester = $mentee['userSem'];
                $menteePhoneNo = $mentee['userPhoneNo'];
                $menteeImage = $mentee['userImage'] ? base64_encode($mentee['userImage']) : 'uploads/default.jpg';

                // Display each mentee's details
                echo "<div class='resume'>";
                echo "<div class='resume-header'>";
                echo "<img src='data:image/jpeg;base64," . $menteeImage . "' alt='Mentee Photo'>";
                echo "<div><h2>$menteeName</h2>";
                echo "<p><strong>User ID:</strong> $menteeID</p>";
                echo "<p><strong>Course:</strong> $menteeCourse</p>";
                echo "<p><strong>Semester:</strong> $menteeSemester</p>";
                echo "<p><strong>Phone:</strong> $menteePhoneNo</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No mentees matched.</p>";
        }

        echo "</div>";
    }
    ?>
</div>


        </div>
    </div>
</body>
</html>
