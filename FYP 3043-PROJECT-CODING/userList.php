<html>
    <head>
        <title>eLeave Management System</title>
    </head>

    <body>
    <?php
    //call file to connect server eLeave
    include("header.php");
    ?>
    
    <h2>List of Mentor</h2>
    
    <?php
    //make the query
    $q = "SELECT MentorID,MentorPassword,MentorName,MentorPhoneNo,MentorEmail,MentorSpeciality
    FROM mentor
    ORDER BY MentorID";
    
    //run the query and assign it to the variable $result 
    $result= @mysqli_query ($connect, $q);
    
    
    if($result)
    {
        //table heading
        echo'<table border="2">
        <tr>
        <td align="centre"><strong>ID</strong</td>
        <td align="centre"><strong>NAME</strong</td>
        <td align="centre"><strong>PHONE</strong</td>
        <td align="centre"><strong>EMAIL</strong</td>
        <td align="centre"><strong>Speciality</strong</td>

        <td align="centre"><strong>UPDATE</strong</td>
        <td align="centre"><strong>DELETE</strong</td>
        </tr>';
        
        //fetch and print all the record 
        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
        
        {
            echo'<tr>
            <td>'.$row['MentorID'].'</td>
            <td>'.$row['MentorName'].'</td>
            <td>'.$row['MentorPhoneNo'].'</td>
            <td>'.$row['MentorEmail'].'</td>
            <td>'.$row['MentorSpeciality'].'</td>

            <td align="centre"><a href="MentorUpdate.php?id='.$row['MentorID'].'">Update</a></td>
            <td align="centre"><a href="MentorDelete.php?id='.$row['MentorID'].'">Delete</a></td>
            </tr>';
        }
        
        //close the table
        echo'</table>';
        
        //free up resources 
        mysqli_free_result($result);
        //if failed to run 
    }
    else 
    {
        //error message 
        echo'<p class = "error">The Current user Could not be retrived .
        We apologize for any inconveience.</p>';
        
        //debugging message 
        echo'<p>'.mysqli_error ($connect).'<br><br>/Query:'.$q.'</p>';
    }//end of if 
    //close the database connection
    mysqli_close($connect);
    
    ?>
    </div>
</div>
</body>
</html>


