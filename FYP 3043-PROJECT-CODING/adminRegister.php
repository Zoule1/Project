<html>
    <head>
        <title>eLeave Management System </title>
</head>
<body>
    <?php
    //call file to connect server eLeave
    include ("header.php");
    ?>

    <?php
    //this query insert a record in the eLeave table 
    //has form been submited?
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        $error = array ();//initialize an error array

        //check a adminPassword 
        if (empty($_POST['adminPassword']))
        {
            $error [] = 'you forgot to the password';


        }
        else 
        {
            $p = mysqli_real_escape_string ($connect,trim($_POST['adminPassword']));

        }
        //check for a adminName 
        if (empty($_POST['adminName']))
        {
            $error [] = 'you forgot to enter your name ';

        }
        else 
        {
            $n = mysqli_real_escape_string($connect, trim($_POST['adminName']));

        }
        //check for adminPhoneNo
        if (empty($_POST['adminPhoneNum']))
        {
            $error [] = 'you forgot to enter your phone number ';

        }
        else 
        {
            $ph = mysqli_real_escape_string($connect , trim($_POST['adminPhoneNum']));

        }
    
        $q = "INSERT INTO admin(adminID,adminPassword,adminName,adminPhoneNum)
        VALUES('','$p', '$n', '$ph')";
        $result = @mysqli_query($connect,$q);//run the query 
        if ($result)//if it runs
        {
            echo'<h1>thank you</h1>';
            exit();
        }
        else 
        {
            //if it didnt run
            //message 
            echo'<h1>System error<h1>';

            //debugging message 
            echo '<p>'.mysqli_errror($connect). '<br><br>Query: '.$q.'</p>';
            mysqli_close($connect);
            exit();

        }//end of the main submit conditional 
    }



        ?>
        <h2> Register Admin </h2>
        <h4> *required field </h4>
        <form action = "adminRegister.php" method = "post">
            <div>
                <label for ="adminPassword">Password:</label>
                <input type = "password" id="adminPassword" name= "adminPassword"size="15" maxlenght="60"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title = "Must contain at least one number and one uppercase and lowercase letter , and at least 8 or more chareacters" required 
                value = "<?php if (isset($_POST['adminPassword'])) echo $_POST ['adminPassword'];?>">
    </div>

    <div>
        <label for = "adminName">Admin Name*:</label>
        <input type = "text" id="adminName" name="adminName" size= "30" maxleght="50"required 
        value = "<?php if (isset($_POST['adminName'])) echo $_POST ['adminName'];?>">
    </div>
    
    <div>
        <label for = "adminPhoneNum">Phone number*:</label>
        <input type = "tel"pattern ="[0-9]{3}-[0-9]{7}" id="adminPhoneNum" name="adminPhoneNum" size= "15" maxleght="20"required 
        value = "<?php if (isset($_POST['adminPhoneNum'])) echo $_POST ['adminPhoneNum'];?>">
    </div>

    
   

    <div>
        <button type ="submit">Register</button>
        <button type = "reset">Clear all</button>
    </div>
    </form>
    </body>
    </html>
    


    
        
        
    