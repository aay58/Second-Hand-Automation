<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the own profile.";
    addProcessingHistory($action);

    $user_id = $_SESSION['user_id'];
    $elements =  getUserById($user_id);
     $keys = array ("USER_NAME", "NAME"," SURNAME", "EMAIL","PHONE_NUMBER","ADDRESS","AGE");
  
    
    
 
    $count = count($keys);
   
    $content = "";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Profile</b></legend><br>";

    for($i = 0; $i < $count; $i=$i+1)
    {
        
         $element = $elements[0][$i];
        $content .= $keys[$i] . ": ";
        $content .= $element . "<br><br>";
    }

    $content .= "<input type='button' value='Back to Home Page' onclick=location.href='index.php'>";
    $content .= "<input type='button' value='Edit' onclick=location.href='edit_profile.php'>";
    $content .= "</fieldset>";

    appendContent($content);
?>