<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    $message_id = $_GET['message_id'];
    $previous_page = $_GET['previous_page'];
    $elements =  getMessageAndUser($message_id);
    $keys = array ("TO_USER", "SUBJECT","TEXT");
    $to_user = $elements[1][0][0];
    
    $count = count($keys);

    $action = $_SESSION["user_name"] . " viewed the message details.";
    addProcessingHistory($action);

    $content = "";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Message Details</b></legend><br>";

    for($i = 1; $i < $count; $i++)
    {
        $element = $elements[1][0][$i];
        $content .= $keys[$i] . ": ";
        $content .= $element . "<br><br>";
    }
    
    $content .= "<input type='button' value='Back to messages' onclick=location.href='" . $previous_page . "'>";
    
    if ($previous_page == "inbox.php")
        $content .= "<input type='button' value='Reply' onclick=location.href='reply_message.php?id=" . $to_user . "&previous_page=message_details.php?message_id=". $message_id . "'>";
    $content .= "</fieldset>";

    appendContent($content);
?>