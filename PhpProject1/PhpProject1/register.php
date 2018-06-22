<?php  include "query.php";?>

<form id='register' action='register.php' method='post' accept-charset='UTF-8'>
    <fieldset>
        <legend style="color:gray"><b>Register</b></legend>

        <label>User Name:</label>
        <input type='text' name='user_name' maxlength="20" required/>
        <br>

        <label>Name:</label>
        <input type='text' name='name' maxlength="20" required/>
        <br>

        <label>Surname:</label>
        <input type='text' name='surname' maxlength="20" required/>
        <br>

        <label>Email Address:</label>
        <input type='email' name='email' maxlength="30" required/>
        <br>

        <label>Password:</label>
        <input type='password' name='password' maxlength="20" required/>
        <br>

        <label>Age:</label>
        <input type='number' name='age' maxlength="11" required/>
        <br>

        <label>Phone Number:</label>
        <input type='number' name='phone_number' maxlength="11" required/>
        <br>

        <label>Address:</label>
        <input type='text' name='address' maxlength="200" required/>
        <br>
        <br>

        <input type="button" name="Back to home page" value="Back to home page" onclick= "location.href='index.php'">
        <input type='submit' name='Submit' value='Sign up' />
    </fieldset>
</form>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $_POST['password'] = md5($_POST['password']);
        print_r($_POST['password']);

        $query=   "SELECT * FROM `USERS` WHERE `USER_NAME` LIKE '" .mysqli_real_escape_string($db,$_POST['user_name']). "';";
        
    $r = mysqli_query ($db, $query);

    if (mysqli_num_rows($r) == 0) { // No: of rows returned. 0 results, Hence the username is Available.
       $action = $_POST['user_name'] . " user registered.";
        addProcessingHistory($action);

       $query2="CALL insertMember('".mysqli_real_escape_string($db,$_POST['name'])."', '".mysqli_real_escape_string($_POST['surname'])."','".mysqli_real_escape_string($db,$_POST['email'])."','".mysqli_real_escape_string($db,$_POST['password'])."','".mysqli_real_escape_string($db,$_POST['phone_number'])."','".mysqli_real_escape_string($db,$_POST['address'])."','".mysqli_real_escape_string($db,$_POST['user_name'])."','".mysqli_real_escape_string($db,$_POST['age'])."')";                 
         
       mysqli_query($db,$query2);
       $message = "Your registration has been successful.";
        echo "<script type='text/javascript'>alert('$message'); location.href='login.php'; </script>";
            //code to INSERT into Database
    
}  else { // The username is not available, print error message.
            $message = "The username is being used by another user!";
                 
            echo "<script type='text/javascript'>alert('$message'); location.href='register.php' </script>";
    }
       // $sorgu = mysql_query( $query);
   
        
       
    }
?>