<?php include "base.php"; include "query.php"?>

<?php
    appendMenuBar(false);

    if(isset($_GET["id"]))
        $to_user = $_GET["id"];
    else
        $to_user = $_POST["to_user"];

    if(isset($_GET["previous_page"]))
    {
        $previous_page = $_GET["previous_page"];
    }
    else
    {
        $previous_page = $_POST["previous_page"];
    }

    $form = "<form action='send_message.php' method='post' accept-charset='UTF-8'>";
    $form .=  "<fieldset>";
    $form .=  "<legend style='color:gray'><b>Send Message</b></legend>";
    $form .=  "<label>Subject:</label>";
    $form .=  "<input type='text' name='subject' maxlength='50' title='Enter subject' required/><br>";
    $form .=  "<label>Text:</label>";
    $form .=  "<textarea rows='5' cols='100' maxlength='500' title='Enter text' name='text'></textarea><br><br>";
    $form .=  "<input name='to_user' value='" . $to_user . "' style='display: none'>";
    $form .=  "<input name='from_user' value='" . $_SESSION['user_id'] . "' style='display: none'>";
    $form .=  "<input name='previous_page' value='" . $previous_page . "' style='display: none'>";
    $form .=  "<input type='button' value='Cancel' onclick=location.href='user_details.php?user_id=" . $to_user . "&page_name=announcement&previous_page=" . $previous_page . "'>";
    $form .=  "<input type='submit' value='Send'/>";
    $form .=  "</fieldset>";
    $form .= "</form>";

    appendContent($form);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        print_r($_POST);
        $action = $_POST['from_user'] . " sent message to " . $_POST['to_user'] . ".";
        addProcessingHistory($action);

        addMessage($_POST);
        $message = "Your message has been successfully sent.";
        echo "<script type='text/javascript' >alert('$message');location.href='user_details.php?user_id=" . $to_user . "&page_name=announcement&previous_page=" . $previous_page . "'; </script>";
    }
?>
