<html>
    <head>
        <title>eLeave Management System</title>
    </head>
    <body>
        <?php

        // Include file to connect to the server eLeave
        include("header.php");

        // Check if admin ID is provided and is numeric
        if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
            $id = $_GET['id'];
        } 
        elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) 
        {
            $id = $_POST['id'];
        } 
        else 
        {
            echo '<p class="error">This page has been accessed in error.</p>';
            exit();
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = array(); // Initialize an error array
            // Validate adminName
            if (empty($_POST['adminName'])) {
                $error[] = 'You forgot to enter your name.';
            } 
            else
             {
                $adminName = mysqli_real_escape_string($connect,
                trim($_POST['adminName']));
            }
            
            // Validate adminPhoneNo
            if (empty($_POST['adminPhoneNo'])) {
                $error[] = 'You forgot to enter your phone number.';
            } 
            else 
            {
                $adminPhoneNo = mysqli_real_escape_string($connect,
                trim($_POST['adminPhoneNo']));
            }

            // Validate adminEmail
            if (empty($_POST['adminEmail'])) {
                $error[] = 'You forgot to enter your email.';
            } 
            else 
            {
                $adminEmail = mysqli_real_escape_string($connect,
                trim($_POST['adminEmail']));
                }
            
            // If no errors occurred
            if (empty($error)) 
            {
                $q = "SELECT adminID FROM admin WHERE adminName = '$adminName' AND
                adminID != $id";
                $result = mysqli_query($connect, $q);
                if (mysqli_num_rows($result) == 0) {
                    $q = "UPDATE admin SET adminName = '$adminName', adminPhoneNo =
                    '$adminPhoneNo', adminEmail = '$adminEmail' WHERE adminID = '$id' LIMIT 1";
                    $result = mysqli_query($connect, $q);
                    if (mysqli_affected_rows($connect) == 1) {
                        echo '<script>alert("The user has been edited");
                        window.location.href="adminList.php";</script>';
                        exit();
                    }
                     else
                      {
                        echo '<p class="error">The user has not been edited due to a
                        system error. We apologize for any inconvenience.</p>';
                        echo '<p>' . mysqli_error($connect) . '<br/> query:' . $q .
                        '</p>';
                    }
                }
                 else
                {
                    echo '<p class="error">The ID has already been registered.</p>';
                }
            } 
            else 
            {
                echo '<p class="error">The following error(s) occurred: <br/>';
                foreach ($error as $msg) {
                    echo "- $msg <br>\n";
                    echo '<p>Please try again.</p>';
                }
            }
        }
            // Fetch admin information
            $q = "SELECT adminName, adminPhoneNo, adminEmail FROM admin WHERE adminID =
            $id";
            $result = mysqli_query($connect, $q);
            if (mysqli_num_rows($result) == 1) 
            {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Generate the form
                echo '<form action="adminUpdate.php" method="post">
                <p><label class="label" for="adminName">Admin Name*:</label>
                <input type="text" id="adminName" name="adminName" size="30"
                maxlength="50" value="' . $row['adminName'] . '"></p>
                <p><br><label class="label" for="adminPhoneNo">Phone No.*:</label>
                <input type="tel" pattern="[0-9]{3}-[0-9]{7}" id="adminPhoneNo"
                name="adminPhoneNo" size="15" maxlength="20" value="' . $row['adminPhoneNo'] .
                '"></p>
                <p><br><label class="label" for="adminEmail">Admin
                Email.*:</label>
                <input type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[az]{2,}$" id="adminEmail" name="adminEmail" size="30" maxlength="50" required
                value="' . $row['adminEmail'] . '"></p>
                <br><p><input id="submit" type="submit" name="submit"
                value="Update"></p>
                <br><input type="hidden" name="id" value="' . $id . '"/>
                </form>';
            } 
            else 
            {
                echo '<p class="error">This page has been accessed in error.</p>';
            }
        
            // Close the database connection
            mysqli_close($connect);
            ?>
            </body>
            </html>



