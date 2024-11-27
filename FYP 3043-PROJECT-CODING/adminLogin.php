<html>
    <head>
        <title> eleave management system</title>
    </head>
    <body>
        <?php
        //call file to connect server eleave 
        include("header.php");
        ?>
        
        <?php
        //this section processes submission from the login page 
        //check if the form has been submitted 
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            //VALIDATE THE ADMINID
            if (!empty($_POST['adminID']))
            {
                $id=mysqli_real_escape_string($connect, $_POST['adminID']);
            }
            else 
            {
                $id= FALSE;
                echo '<p class="error> you forgot to enter your id .</p>';
            }
            
            //validate the adminPassword
            if (!empty($_POST['adminPassword']))
            {
                $p= mysqli_real_escape_string($connect, $_POST['adminPassword']);
            }
            else 
            {
                $p= FALSE;
                echo '<p class = "error"> you forgot to enter your password.</p>';
            }
            
            //if no problem
            if($id && $p)
            {
                //retrieve the adminID , adminPassword , adminName , adminPhoneNum , adminEmail
                $q="SELECT adminID, adminPassword ,adminName ,adminPhoneNo, adminEmail 
                FROM admin WHERE (adminID='$id'AND adminPassword='$p')";
                
                //run the query and assign it to variable $result 
                $result = mysqli_query($connect, $q);
                
                //count the number of row that match the adminID/adminPassword combination
                //if one database row (record)matches input:
                    if (@mysqli_num_rows($result)==1)
                    {
                        //start the session , fetch the record ad insert the three values in a array 
                        session_start();
                        $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo '<p> welcome to eleave System<p>';
                        
                        //cancel the rest script 
                        exit();
                        
                        mysqli_free_result ($result);
                        mysqli_close ($connect);
                        //no match was made 
                    
                    }
                    else 
                    {
                        echo'<p class = "error"> the adminID and adminPassword entered do not match our records <br> perhaps you need to register , just click the register button</p>';
                    }
                    //if there was a problem 
                }
                else 
                {
                    echo'<p class="error">please try again.</p>';
                
                }
                mysqli_close($connect);
            
            }//end of submit conditional
            ?> 
            
            <h2 allign = "centre"> ADMIN LOGIN</h2>
            
            <form action="adminLogin.php" method="post">
                <div>
                    <label for ="adminID">Admin ID : </label>
                    <input type ="text" id = "adminId" name="adminID" size ="4" maxleght="6"
                    value ="<?php if (isset($_POST['adminID'])) echo $_POST['adminID'];?>">
                </div>
                
                <div>
                    <label for = "adminPassword">password:</label>
                    <input type ="password" id = "adminPassword" name="adminPassword" size="15" maxlenght="60"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title = "must contain atleast one number and 
                    one uppercase and lowercase letter and atleast 8 or more character"required 
                    value ="<?php if (isset($_POST['adminPassword']))echo $_POST['adminPassword'];?>">
                </div>
                
                <div>
                    <button type="submit">Login</button>
                    <button type="reset">reset</button>
                </div>
                
                <div>
                    <label>Dont have an account?
                        <a href = "adminRegister.php">Sign Up</a>
                    </label>
                    <form>

                    </body>
                    </html>

