<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    $user_name = getUserName($_GET['user_id']);
    $action = $_SESSION["user_name"] . " viewed details of " . $user_name . ".";
    addProcessingHistory($action);

    $user_id = $_GET['user_id'];
    $page_name = $_GET['page_name'];
    $previous_page = $_GET['previous_page'];

    if(isset($_GET['page_number']))
    {
        $previous_page .= "&page_number=" . $_GET['page_number'];
    }

    $elements =  getUserById($user_id)[0];
    $keys = array_keys($elements);
    $count = count($keys) - 1;

    $content = "";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>User Details</b></legend><br>";

    for($i = 1; $i < $count; $i=$i+2)
    {
        
         $element = $elements[$keys[$i]];
        $content .= $keys[$i] . ": ";
        $content .= $element . "<br><br>";
    }

    $content .= "<input type='button' value='Back to " . $page_name . "' onclick=location.href='" . $previous_page . "'>";

    if(isset($_SESSION["user_id"]))
        $content .= "<input type='button' value='Send Message' onclick=location.href='send_message.php?id=" . $user_id . "&previous_page=" . $previous_page . "'>";

    $content .= "</fieldset>";

    appendContent($content);
?>