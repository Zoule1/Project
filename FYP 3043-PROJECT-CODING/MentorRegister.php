<html>
    <head>
        <title>eLeave Management System</title>
    </head>
    <body>
        <?php
        // Call file to connect to the database
        include("header.php");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = array(); // Initialize an error array

            // Check MentorPassword
            if (empty($_POST['MentorPassword'])) {
                $error[] = 'You forgot to enter the password.';
            } else {
                $p = mysqli_real_escape_string($connect, trim($_POST['MentorPassword']));
            }

            // Check MentorName
            if (empty($_POST['MentorName'])) {
                $error[] = 'You forgot to enter your name.';
            } else {
                $n = mysqli_real_escape_string($connect, trim($_POST['MentorName']));
            }

            if (empty($_POST['MentorID'])) {
                $error[] = 'You forgot to enter your phone IC.';
            } else {
                $id = mysqli_real_escape_string($connect, trim($_POST['MentorID']));
            }

            // Check MentorPhoneNo
            if (empty($_POST['MentorPhoneNo'])) {
                $error[] = 'You forgot to enter your phone number.';
            } else {
                $ph = mysqli_real_escape_string($connect, trim($_POST['MentorPhoneNo']));
            }

            // Check MentorEmail
            if (empty($_POST['MentorEmail'])) {
                $error[] = 'You forgot to enter your email.';
            } else {
                $e = mysqli_real_escape_string($connect, trim($_POST['MentorEmail']));
            }

              // Check MentorDepartment
              if (empty($_POST['MentorDepartment'])) {
                $error[] = 'You forgot to enter Mentor Speciality.';
            } else {
                $dep = mysqli_real_escape_string($connect, trim($_POST['MentorDepartment']));
            }

            // Check MentorSpeciality
            if (empty($_POST['MentorSpeciality'])) {
                $error[] = 'You forgot to enter Mentor Speciality.';
            } else {
                $spe = mysqli_real_escape_string($connect, trim($_POST['MentorSpeciality']));
            }

            if (isset($_FILES['MentorImage']) && $_FILES['MentorImage']['error'] == 0) {
                // Get image file content as binary data
                $img = file_get_contents($_FILES['MentorImage']['tmp_name']);
                $img = mysqli_real_escape_string($connect, $img);
            } else {
                $error[] = 'You forgot to upload an image.';
            }

            // If there are no errors, proceed with database entry
            if (empty($error)) {
                $q = "INSERT INTO Mentor (MentorID, MentorPassword, MentorName, MentorPhoneNo, MentorEmail, MentorDepartment, MentorSpeciality, MentorImage)
                      VALUES ('$id', '$p', '$n', '$ph', '$e', '$dep', '$spe', '$img')";
                $result = @mysqli_query($connect, $q); // Run the query

                if ($result) { // If it runs successfully
                    echo '<h1>Thank you for registering!</h1>';
                    exit();
                } else {
                    echo '<h1>System error</h1>';
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
        
        <h2>Register Mentor</h2>
        <h4>* Required field</h4>
        <form action="MentorRegister.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="MentorPassword">Password:</label>
                <input type="password" id="MentorPassword" name="MentorPassword" size="15" maxlength="60"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                       required value="<?php if (isset($_POST['MentorPassword'])) echo $_POST['MentorPassword']; ?>">
            </div>

            <div>
                <label for="MentorName">Mentor Name*:</label>
                <input type="text" id="MentorName" name="MentorName" size="30" maxlength="50" required 
                       value="<?php if (isset($_POST['MentorName'])) echo $_POST['MentorName']; ?>">
            </div>

            <div>
                <label for="MentorPhoneNo">Phone Number*:</label>
                <input type="tel" pattern="[0-9]{3}-[0-9]{7}" id="MentorPhoneNo" name="MentorPhoneNo" size="15" maxlength="20" required 
                       value="<?php if (isset($_POST['MentorPhoneNo'])) echo $_POST['MentorPhoneNo']; ?>">
            </div>

            <div>
                <label for="MentorEmail">Mentor Email*:</label>
                <input type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="MentorEmail" name="MentorEmail" size="30" maxlength="50" required 
                       value="<?php if (isset($_POST['MentorEmail'])) echo $_POST['MentorEmail']; ?>">
            </div>

            <div>
                <label for="MentorSpeciality">Mentor Speciality*:</label>
                <select name="MentorSpeciality" id="MentorSpeciality">
                    <option value="Networking">Networking</option>
                    <option value="Cyber Security">Cyber Security</option>
                    <option value="Mobile Application">Mobile Application</option>
                </select>
            </div>

            <div>
                <label for="MentorImage">Upload Image*:</label>
                <input type="file" id="MentorImage" name="MentorImage" accept="image/*" required>
            </div>

            <div>
                <button type="submit">Register</button>
                <button type="reset">Clear All</button>
            </div>
        </form>
    </body>
</html>
