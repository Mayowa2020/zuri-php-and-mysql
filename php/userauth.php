<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country)
{
    //create a connection variable using the db function in config.php
    $conn = db();
    //check if user with this email already exist in the database

    $select = mysqli_query($conn, "SELECT * FROM students WHERE email = '" . $_POST['email'] . "'");
    if (mysqli_num_rows($select)) {
        exit('This email address is already used!');
    }
}

//login users
function loginUser($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();

    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard

    $sql = mysqli_query(
        $conn,
        "SELECT * FROM students WHERE email='"
        . $_POST["email"] . "' AND
    password='" . $_POST["password"] . "'    "
    );

    $num = mysqli_num_rows($sql);

    if ($num > 0) {
        $row = mysqli_fetch_array($sql);
        // Starting the session using session_start() function
        session_start();
        // Now Storing the session's data 
        $_SESSION['username'] = $email;
        header("location: ../dashboard ");
        exit();
    } else {
        header("location: ./../../forms/login.html");
        echo "
<hr> 
<font color='red'><b>
        <h3>Sorry Invalid Username and Password<br>
            Please Enter Correct Credentials</br></h3>
           
    </b>
</font>
<hr>";

    }
}
;


function resetPassword($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given

    $query = mysqli_query($conn,"SELECT *from student WHERE email='$email'");

    $num = mysqli_num_rows($query);

    if ($num > 0) {
        $row = mysqli_fetch_array($query);
    
     //update password in database
    $query = "UPDATE students SET password= '$password' WHERE email='$email' LIMIT 1";
    if($query)
        {
        echo "Congratulations You have successfully changed your password";
        }
       else
        {
       echo "User does not exist";
       }
}}

function getusers()
{
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo "<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            //show data
            echo "<tr style='height: 30px'>" .
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] .
                "</td> <td style='width: 150px'>" . $data['country'] .
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                "value=" . $data['id'] . ">" .
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>" .
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

function deleteaccount($id)
{
    $conn = db();
    //delete user with the given id from the database
    $sql = "Delete FROM students WHERE id=$id";
    if (!mysqli_query($conn,$sql))
    {
    die('Error: ' . mysqli_error($conn));
    }
    echo "Record Deleted";
    header("Refresh:3; url=admin.php");
    
   
}

mysqli_close($conn);
?>