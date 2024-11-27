<html>
<head>
    <title>eLeave Management System</title>
    <h2>Edit Mentor Record</h2>

</head>
<body>
    <?php
    // Include header file
    include("header.php");


    

    // Look for a valid user id, either through GET or POST
    if ((isset($_GET['id']) && !empty($_GET['id']))) {
        $id = mysqli_real_escape_string($connect, $_GET['id']);
    } elseif ((isset($_POST['id']) && !empty($_POST['id']))) {
        $id = mysqli_real_escape_string($connect, $_POST['id']);
    } else {
        echo '<p class="error">This page has been accessed in error. ID is missing or invalid.</p>';
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = []; // Initialize an error array

        // Validate inputs
        $fields = ['MentorName', 'MentorPhoneNo', 'MentorEmail', 'MentorDepartment', 'MentorSpeciality'];
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                $error[] = "You forgot to enter $field.";
            } else {
                $$field = mysqli_real_escape_string($connect, trim($_POST[$field]));
            }
        }

        // If no error occurred, proceed to update
        if (empty($error)) {
            $q = "UPDATE mentor 
                  SET MentorName = '$MentorName', MentorPhoneNo = '$MentorPhoneNo', 
                      MentorEmail = '$MentorEmail', MentorDepartment = '$MentorDepartment', 
                      MentorSpeciality = '$MentorSpeciality'
                  WHERE MentorID = '$id' 
                  LIMIT 1";

            $result = mysqli_query($connect, $q);

            if (mysqli_affected_rows($connect) == 1) {
                echo '<script>alert("The mentor record has been updated successfully."); 
                      window.location.href = "admin_home.php";</script>';
            } else {
                echo '<p class="error">The record could not be updated due to a system error.</p>';
                echo '<p>' . mysqli_error($connect) . '<br>Query: ' . $q . '</p>';
            }
        } else {
            // Display errors
            echo '<p class="error">The following errors occurred:<br>';
            foreach ($error as $msg) {
                echo "- $msg<br>\n";
            }
            echo '</p><p>Please try again.</p>';
        }
    }

    // Retrieve mentor data
    $q = "SELECT MentorName, MentorPhoneNo, MentorEmail, MentorDepartment, MentorSpeciality 
          FROM mentor 
          WHERE MentorID = '$id'";
    $result = mysqli_query($connect, $q);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Display form
        echo '<form action="MentorUpdate.php" method="post">
            <p><label class="label" for="MentorName">Mentor Name*:</label>
            <input type="text" id="MentorName" name="MentorName" size="30" maxlength="50" value="' . htmlspecialchars($row['MentorName']) . '"></p>

            <p><label class="label" for="MentorPhoneNo">Phone No.*:</label>
            <input type="tel" pattern="[0-9]{3}-[0-9]{7}" id="MentorPhoneNo" name="MentorPhoneNo" size="15" maxlength="20" value="' . htmlspecialchars($row['MentorPhoneNo']) . '"></p>

            <p><label class="label" for="MentorEmail">Mentor Email*:</label>
            <input type="email" id="MentorEmail" name="MentorEmail" size="30" maxlength="50" required value="' . htmlspecialchars($row['MentorEmail']) . '"></p>

            <p><label for="MentorDepartment">Mentor Department*:</label>
            <select name="MentorDepartment" id="MentorDepartment">
                <option value="Faculty of Computing & Multimedia (FCOM)"' . ($row['MentorDepartment'] == 'Faculty of Computing & Multimedia (FCOM)' ? ' selected' : '') . '>Faculty of Computing & Multimedia (FCOM)</option>
                <option value="Faculty of Education, Humanities and Arts (FEHA)"' . ($row['MentorDepartment'] == 'Faculty of Education, Humanities and Arts (FEHA)' ? ' selected' : '') . '>Faculty of Education, Humanities and Arts (FEHA)</option>
                <option value="Faculty of Business, Accountancy and Social Sciences (FBASS)"' . ($row['MentorDepartment'] == 'Faculty of Business, Accountancy and Social Sciences (FBASS)' ? ' selected' : '') . '>Faculty of Business, Accountancy and Social Sciences (FBASS)</option>
                <option value="Institute of Professional Studies (IPS)"' . ($row['MentorDepartment'] == 'Institute of Professional Studies (IPS)' ? ' selected' : '') . '>Institute of Professional Studies (IPS)</option>
                <option value="Institute of Graduate Studies (IGS)"' . ($row['MentorDepartment'] == 'Institute of Graduate Studies (IGS)' ? ' selected' : '') . '>Institute of Graduate Studies (IGS)</option>
            </select></p>

            <p><label for="MentorSpeciality">Mentor Speciality*:</label>
            <select name="MentorSpeciality" id="MentorSpeciality">
                <option value="Networking"' . ($row['MentorSpeciality'] == 'Networking' ? ' selected' : '') . '>Networking</option>
                <option value="Cyber Security"' . ($row['MentorSpeciality'] == 'Cyber Security' ? ' selected' : '') . '>Cyber Security</option>
                <option value="Mobile Application"' . ($row['MentorSpeciality'] == 'Mobile Application' ? ' selected' : '') . '>Mobile Application</option>
                <option value="Multimedia"' . ($row['MentorSpeciality'] == 'Multimedia' ? ' selected' : '') . '>Multimedia</option>
                <option value="Information Technology"' . ($row['MentorSpeciality'] == 'Information Technology' ? ' selected' : '') . '>Information Technology</option>
                <option value="Artificial Intelligence"' . ($row['MentorSpeciality'] == 'Artificial Intelligence' ? ' selected' : '') . '>Artificial Intelligence</option>
            </select></p>

            <p><input id="submit" type="submit" name="submit" value="Update"></p>
            <input type="hidden" name="id" value="' . htmlspecialchars($id) . '"/>
        </form>';
    } else {
        echo '<p class="error">This page has been accessed in error. Mentor record not found.</p>';
    }

    mysqli_close($connect); // Close the database connection
    ?>
</body>
</html>
