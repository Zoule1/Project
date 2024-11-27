<?php
// Start session to access the logged-in mentor's ID
session_start();

// Check if the mentor is logged in
if (!isset($_SESSION['mentorID'])) {
    header("Location: login.php");
    exit();
}

// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "mentormentee");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the logged-in mentor's ID
$mentorID = $_SESSION['mentorID'];

// Fetch mentor data
$q_mentor = "SELECT MentorID, MentorPassword, MentorName, MentorPhoneNo, MentorEmail, MentorDepartment, MentorSpeciality, MentorImage 
             FROM mentor 
             WHERE MentorID = '$mentorID'";
$result_mentor = mysqli_query($connect, $q_mentor);

if ($mentor = mysqli_fetch_assoc($result_mentor)) {
    // Mentor data fetched successfully
} else {
    echo "No mentor found.";
    exit();
}

// Fetch the mentor's specialty
$mentorSpeciality = $mentor['MentorSpeciality'];

// Fetch mentees with matching weaknesses to mentor specialty
$q_mentees = "SELECT userID, userName, userWeakness, userCourse, userSem, userPhoneNo, userAddress, userImage FROM user 
              WHERE userWeakness = '$mentorSpeciality' 
              LIMIT 20";
$result_mentees = mysqli_query($connect, $q_mentees);

// Fetch mentee course data for pie chart
$q_courses = "SELECT userCourse, COUNT(*) as courseCount 
              FROM user 
              WHERE userWeakness = '$mentorSpeciality' 
              GROUP BY userCourse";
$result_courses = mysqli_query($connect, $q_courses);

$courses = [];
$courseCounts = [];
while ($row = mysqli_fetch_assoc($result_courses)) {
    $courses[] = $row['userCourse'];
    $courseCounts[] = $row['courseCount'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>UPTM Mentorship</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.info-field.form-field > div');
            sections.forEach(section => section.style.display = 'none');

            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) selectedSection.style.display = 'block';
        }

        window.onload = function() {
            showSection('Mentor_Profile');
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
                <li><a href="#" onclick="showSection('Mentor_Profile')">Mentor Profile</a></li>
                <li><a href="#" onclick="showSection('Participants')">Mentorship Room</a></li>
                <li><a href="lobby.html">Chatroom</a></li>
                <li><a href="UserManual.pdf">User Manual</a></li>
                <li><a href="login.php" onclick="showSection('Sign_out')">Sign Out</a></li>
            </ul>
        </div>

        <div class="info-field form-field">
            <div id="Mentor_Profile">
                <h2>Mentor Profile</h2>
                <div class="resume">
                    <div class="resume-header">
                        <?php if (!empty($mentor['MentorImage'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($mentor['MentorImage']); ?>" alt="Mentor Image">
                        <?php else: ?>
                            <img src="default-profile.png" alt="Default Mentor Image">
                        <?php endif; ?>
                        <div>
                            <h2><?php echo $mentor['MentorName']; ?></h2>
                            <h3>Department: <?php echo $mentor['MentorDepartment']; ?></h3>
                        </div>
                    </div>
                    <div class="resume-section">
                        <h3>Mentor Information</h3>
                        <p><strong>Email:</strong> <?php echo $mentor['MentorEmail']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $mentor['MentorPhoneNo']; ?></p>
                    </div>
                    <div class="resume-section">
                        <h3>Specialty</h3>
                        <p><?php echo $mentor['MentorSpeciality']; ?></p>
                    </div>
                    <div class="resume-section">
                        <h3>Course involved</h3>
                        <canvas id="courseChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div id="Participants" style="display: none;">
    <h2>Participants</h2>
    <?php while ($mentee = mysqli_fetch_assoc($result_mentees)): ?>
        <div class="resume">
            <div class="resume-header">
                <?php if (!empty($mentee['userImage'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($mentee['userImage']); ?>" alt="Mentee Image">
                <?php else: ?>
                    <img src="default-profile.png" alt="Default Mentee Image">
                <?php endif; ?>
                <div>
                    <h2><?php echo $mentee['userName']; ?></h2>
                    <h3>Debility: <?php echo $mentee['userWeakness']; ?></h3>
                    <p><strong>Course:</strong> <?php echo $mentee['userCourse']; ?></p>
                    <p><strong>Semester:</strong> <?php echo $mentee['userSem']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $mentee['userPhoneNo']; ?></p>
                    <p><strong>Address:</strong> <?php echo $mentee['userAddress']; ?></p>

                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('courseChart').getContext('2d');
            var courseChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($courses); ?>,
                    datasets: [{
                        data: <?php echo json_encode($courseCounts); ?>,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
