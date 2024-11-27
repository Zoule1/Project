<?php
// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "mentormentee");

// Run queries to fetch student and mentor data
$q_student = "SELECT userID, userName, userPhoneNo, userEmail, userAddress, userImage FROM user ORDER BY userID";
$result_student = @mysqli_query($connect, $q_student);

$q_mentor = "SELECT MentorID, MentorName, MentorPhoneNo, MentorEmail, MentorSpeciality, MentorImage FROM mentor ORDER BY MentorID";
$result_mentor = @mysqli_query($connect, $q_mentor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPTM Mentorship</title>
    <link rel="stylesheet" href="admin.css">
    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.info-field.form-field > div');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
        }

        window.onload = function() {
            showSection('admin_students');
        };
    </script>
     <style>/* General page styling */
/* General page styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7f9;
    color: #333;
}

h1, h2 {
    color: 	#2b2b2b	;
    margin: 10px 0;
}

/* Navbar styling */
nav {
    display: flex;
    align-items: center;
    background-color:#d4d4d4;
    padding: 15px;
    color: white;
    margin-left: 220px; /* Matches sidebar width */
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
    background-color: #b3b3b3;
    color: white;
    padding: 20px;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow */
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
    margin-left: 240px; /* Matches sidebar width */
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

/* Form Styling */
form label {
    display: block;
    margin-top: 10px;
    color: #333;
    font-weight: bold;
}

form input, form select, form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 1em;
}

form button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background 0.3s;
}

form button:hover {
    background-color: #1a6a93;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #34495e;
    color: white;
}

td {
    background-color: #f9f9f9;
}

tr:nth-child(even) td {
    background-color: #f2f2f2;
}

/* Error message styling */
.error {
    color: #e74c3c;
    font-weight: bold;
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
                <li><a href="#" onclick="showSection('admin_students')">Add Mentees</a></li>
                <li><a href="#" onclick="showSection('admin_teachers')">Add Mentors</a></li>
                <li><a href="#" onclick="showSection('admin_marks')">List Mentees</a></li>
                <li><a href="#" onclick="showSection('admin_mentors')">List Mentors</a></li>
                <li><a href="UserManual.pdf">User Manual</a></li>
                <li><a href="login.php" onclick="showSection('admin_sign_out')">Sign Out</a></li>
            </ul>
        </div>

        <div class="info-field form-field">
            <!-- Add Students Section -->
            <div id="admin_students" style="display: none;">
                <h2>Add Student Information</h2>
                <form action="userRegister.php" method="post" enctype="multipart/form-data">
                    <label for="userPassword">Password:</label>
                    <input type="password" id="userPassword" name="userPassword" required>
                    
                    <label for="userName">Full Name:</label>
                    <input type="text" id="userName" name="userName" required>

                    <label for="userID">ID:</label>
                    <input type="text" id="userID" name="userID" required>

                    <label for="userIC">IC:</label>
                    <input type="text" id="userIC" name="userIC" required>

                    <label for="userCourse">Course :</label>
                    <select name="userCourse" id="userCourse">
                        <option value="Diploma in Computer Science (CC101)">Diploma in Computer Science (CC101)</option>
                        <option value="Bachelor of Arts in 3D Animation and Digital Media (Honours) (CM201)">Bachelor of Arts in 3D Animation and Digital Media (Honours) (CM201)</option>
                        <option value="Bachelor of Information Technology (Honours) in Business Computing (CT203)">Bachelor of Information Technology (Honours) in Business Computing (CT203)</option>
                        <option value="Bachelor of Information Technology (Honours) in Computer Application Development (CT204)">Bachelor of Information Technology (Honours) in Computer Application Development (CT204)</option>
                        <option value="Bachelor of Information Technology (Honours) in Cyber Security (CT206)">Bachelor of Information Technology (Honours) in Cyber Security (CT206)</option>
                        
                        </select>

                        <label for="userSem">Semester :</label>
                    <select name="userSem" id="userSem">
                        <option value="Semester 1">1</option>
                        <option value="Semester 2">2</option>
                        <option value="Semester 3">3</option>
                        <option value="Semester 4">4</option>
                        <option value="Semester 5">5</option>
                        <option value="Semester 6">6</option>
                        <option value="Semester 7">7</option>
                        <option value="Semester 8">8</option>
                        <option value="Semester 9">9</option>

                        </select>

                        <label for="userWeakness">Debility:</label>
                    <select name="userWeakness" id="userWeakness">
                        <option value="Networking">Networking</option>
                        <option value="Cyber Security">Cyber Security</option>
                        <option value="Mobile Application">Mobile Application</option>
                        <option value="Multimedia">Multimedia</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>

                    </select>
                    
                    <label for="userPhoneNo">Phone No:</label>
                    <input type="tel" pattern="[0-9]{3}-[0-9]{7}" id="userPhoneNo" name="userPhoneNo" required>
                    
                    <label for="userEmail">User Email:</label>
                    <input type="email" id="userEmail" name="userEmail" required>
                    
                    <label for="userAddress">User Address:</label>
                    <textarea id="userAddress" name="userAddress" required></textarea>
                    
                    <label for="userImage">Upload Image:</label>
                    <input type="file" id="userImage" name="userImage" accept="image/*" required>
                    
                    <button type="submit">Register</button>
                    <button type="reset">Clear All</button>
                </form>
            </div>

            <!-- Add Teachers Section -->
            <div id="admin_teachers" style="display: none;">
                <h2>Add Mentor Information</h2>
                <form action="MentorRegister.php" method="post" enctype="multipart/form-data">
                    <label for="MentorPassword">Password:</label>
                    <input type="password" id="MentorPassword" name="MentorPassword" required>
                    
                    <label for="MentorName">Mentor Name:</label>
                    <input type="text" id="MentorName" name="MentorName" required>

                    <label for="MentorID">ID:</label>
                    <input type="text" id="MentorID" name="MentorID" required>

                    
                    <label for="MentorPhoneNo">Phone Number:</label>
                    <input type="tel" pattern="[0-9]{3}-[0-9]{7}" id="MentorPhoneNo" name="MentorPhoneNo" required>
                    
                    <label for="MentorEmail">Mentor Email:</label>
                    <input type="email" id="MentorEmail" name="MentorEmail" required>

                    <label for="MentorDepartment">Mentor Department :</label>
                    <select name="MentorDepartment" id="MentorDepartment">
                        <option value="Faculty of Computing & Multimedia (FCOM)">Faculty of Computing & Multimedia (FCOM)</option>
                        <option value="Faculty of Education, Humanities and Arts (FEHA)">Faculty of Education, Humanities and Arts (FEHA)</option>
                        <option value="Faculty of Business, Accountancy and Social Sciences (FBASS)">Faculty of Business, Accountancy and Social Sciences (FBASS)</option>
                        <option value="Institute of Professional Studies (IPS)">Institute of Professional Studies (IPS)</option>
                        <option value="Institute of Graduate Studies (IGS)">Institute of Graduate Studies (IGS)</option>
                        
                        </select>
                    
                    <label for="MentorSpeciality">Mentor Speciality:</label>
                    <select name="MentorSpeciality" id="MentorSpeciality">
                        <option value="Networking">Networking</option>
                        <option value="Cyber Security">Cyber Security</option>
                        <option value="Mobile Application">Mobile Application</option>
                        <option value="Multimedia">Multimedia</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>

                    </select>
                    
                    <label for="MentorImage">Upload Image:</label>
                    <input type="file" id="MentorImage" name="MentorImage" accept="image/*" required>
                    
                    <button type="submit">Register</button>
                    <button type="reset">Clear All</button>
                </form>
            </div>

            <!-- List Students Section -->
            <div id="admin_marks" style="display: none;">
                <h2>List of Students</h2>
                <?php
                if ($result_student) {
                    echo '<table border="2">
                        <tr>
                            <td><strong>ID</strong></td>
                            <td><strong>NAME</strong></td>
                            <td><strong>PHONE</strong></td>
                            <td><strong>EMAIL</strong></td>
                            <td><strong>ADDRESS</strong></td>
                            <td><strong>IMAGE</strong></td>
                            <td><strong>UPDATE</strong></td>
                            <td><strong>DELETE</strong></td>
                        </tr>';

                    while ($row = mysqli_fetch_array($result_student, MYSQLI_ASSOC)) {
                        echo '<tr>
                            <td>' . $row['userID'] . '</td>
                            <td>' . $row['userName'] . '</td>
                            <td>' . $row['userPhoneNo'] . '</td>
                            <td>' . $row['userEmail'] . '</td>
                            <td>' . $row['userAddress'] . '</td>
                            <td><img src="data:image/jpeg;base64,' . base64_encode($row['userImage']) . '" width="50" height="50"></td>
                            <td><a href="userUpdate.php?id=' . $row['userID'] . '">Update</a></td>
                            <td><a href="userDelete.php?id=' . $row['userID'] . '">Delete</a></td>
                        </tr>';
                    }
                    echo '</table>';
                    mysqli_free_result($result_student);
                } else {
                    echo '<p class="error">Could not retrieve the data.</p>';
                    echo '<p>' . mysqli_error($connect) . '</p>';
                }
                ?>
            </div>

            <!-- List Mentors Section -->
            <div id="admin_mentors" style="display: none;">
                <h2>List of Mentors</h2>
                <?php
                if ($result_mentor) {
                    echo '<table border="2">
                        <tr>
                            <td><strong>ID</strong></td>
                            <td><strong>NAME</strong></td>
                            <td><strong>PHONE</strong></td>
                            <td><strong>EMAIL</strong></td>
                            <td><strong>SPECIALITY</strong></td>
                            <td><strong>IMAGE</strong></td>
                            <td><strong>UPDATE</strong></td>
                            <td><strong>DELETE</strong></td>
                        </tr>';

                    while ($row = mysqli_fetch_array($result_mentor, MYSQLI_ASSOC)) {
                        echo '<tr>
                            <td>' . $row['MentorID'] . '</td>
                            <td>' . $row['MentorName'] . '</td>
                            <td>' . $row['MentorPhoneNo'] . '</td>
                            <td>' . $row['MentorEmail'] . '</td>
                            <td>' . $row['MentorSpeciality'] . '</td>
                            <td><img src="data:image/jpeg;base64,' . base64_encode($row['MentorImage']) . '" width="50" height="50"></td>
                            <td><a href="MentorUpdate.php?id=' . $row['MentorID'] . '">Update</a></td>
                            <td><a href="MentorDelete.php?id=' . $row['MentorID'] . '">Delete</a></td>
                        </tr>';
                    }
                    echo '</table>';
                    mysqli_free_result($result_mentor);
                } else {
                    echo '<p class="error">Could not retrieve the data.</p>';
                    echo '<p>' . mysqli_error($connect) . '</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
