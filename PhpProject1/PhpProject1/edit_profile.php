<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
  
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
       
            $action = $_SESSION["user_name"] . " edited profile.";
            addProcessingHistory($action);

            updateProfile($_POST,$user_name);
            $message = "Your profile has been successfully updated.";
            echo "<script type='text/javascript'>alert('$message');location.href='profile.php'; </script>";
        
    }

    $user = getUserById($user_id);
    
    

    $content = "";
    $content .= "<form action='edit_profile.php' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Edit Profile</b></legend><br>";
    $content .= "<label>User Name:</b></label><label>" . $user[0][0] . "</b></label><br><br>";
    $content .= "<label>Name:</b></label><input type='text' name='name' value='" .  $user[0][1] . "' maxlength='20' title='Enter name' required/><br><br>";
    $content .= "<label>Surname:</b></label><input type='text' name='surname' value='" .  $user[0][2] . "' maxlength='20' title='Enter surname' required/><br><br>";
    $content .= "<label>Email Address:</b></label><input type='text' name='email' value='" .  $user[0][3] . "' maxlength='30' title='Enter email address' required/><br><br>";
    $content .= "<label>Password:</b></label><input type='password' name='password' value='" .  $user[0][6] . "' maxlength='20' title='Enter password' required/><br><br>";
    $content .= "<label>Phone Number:</b></label><input type='tel' name='phone_number' value='" .  $user[0][4] . "' maxlength='11' title='Enter phone number' required/><br><br>";
    $content .= "<label>Address:</b></label><input type='text' name='address' value='" .  $user[0][5] . "' maxlength='200' title='Enter address' required/><br><br>";
    $content .= "<input type='button' value='Back to profile' onclick=location.href='profile.php'>";
    $content .= "<input type='submit' value='Update'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>