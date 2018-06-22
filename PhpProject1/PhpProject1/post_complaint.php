<?php include "base.php"; include "query.php"?>

<?php
    appendMenuBar(false);

    $form = "<form id='complaint' action='post_complaint.php' method='post' accept-charset='UTF-8'>";
    $form .=  "<fieldset>";
    $form .=  "<legend style='color:gray'><b>Complaint</b></legend>";
    $form .=  "<label>Subject:</label>";
    $form .=  "<input type='text' name='subject' maxlength='50' title='Enter subject' required/><br>";
    $form .=  "<label>Text:</label>";
    $form .=  "<textarea rows='5' cols='100' maxlength='500' title='Enter text' name='text'></textarea><br><br>";
    $form .=  "<input type='button' name='Cancel' value='Back to Home Page' onclick=location.href='index.php'>";
    $form .=  "<input type='submit' name='Submit' value='Post'/>";
    $form .=  "</fieldset>";
    $form .= "</form>";

    appendContent($form);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $action = $_SESSION["user_name"] . " posted complaint.";
        addProcessingHistory($action);

        addComplaint($_POST);
        $message = "Your complaint has been successfully posted.";
        echo "<script type='text/javascript' >alert('$message');location.href='index.php'; </script>";
    }
?>
