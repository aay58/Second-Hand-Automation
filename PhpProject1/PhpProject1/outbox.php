<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the message outbox.";
    addProcessingHistory($action);

    $messages = getOutboxMessages();  
    $keys = array ("USER_ID", "MESSAGE_ID"," USER_NAME", "SUBJECT", "TEXT");
    $keys_length = count($keys);

    $content = "";
    $content = "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width: 80%; margin-left: 10%; margin-top: 40px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th>  #  </th>";

    for($i = 2; $i < $keys_length; $i++)
    {
        if ($keys[$i] == "SUBJECT" || $keys[$i] == "USER_NAME")
            $content .= "<th width='20%'>$keys[$i]</th>";
        else
            $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th width='15%'></th>";
    $content .= "</tr>";

    $elements_length = count($messages[1]);

    for($i = 0; $i < $elements_length; $i++)
    {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . ($i+1) . "</th>";

        for($j = 2; $j< $keys_length; $j++)
        {
            if ($keys[$j] == "TEXT")
                $content .= "<th style='max-width: 40vw; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $messages[1][$i][$j] . "</th>";
            elseif ($keys[$j] == "USER_NAME")
                $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'><a href='user_details.php?user_id=" . $messages[1][$i][0] . "&page_name=outbox&previous_page=outbox.php'>" . $messages[1][$i][2] . "</a></th>";
            else
                $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $messages[1][$i][$j] . "</th>";
        }

        $to_user = $messages[1][$i][0];
        print_r($messages);
        $message_id = $messages[1][$i][1];

        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 220px'>";
        $content .= "<input type='button' value='Details' onclick=location.href='message_details.php?message_id=" . $message_id . "&previous_page=outbox.php'>";
        $content .= "<input type='button' value='Delete' onclick=location.href='delete.php?page_name=outbox.php&table_name=MESSAGE&id_name=MESSAGE_ID&id=" . $message_id . "'>";
        $content .= "</th>";
        $content .= "</tr>";
    }

    $content .= "</table>";

    appendContent($content);
?>