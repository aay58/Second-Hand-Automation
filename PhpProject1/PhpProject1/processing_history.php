<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the processing history.";
    addProcessingHistory($action);

    $processing_history = getProcessingHistory();
    $keys = array ("PROCESSING_HISTORY_ID", "USER_ID", "ACTIVITY", "DATE");
    $keys_length = count($keys);

    $content = "";
    $content = "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width: 80%; margin-left: 10%; margin-top: 20px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th>  #  </th>";
    $content .= "<th>  USER NAME  </th>";

    for($i = 2; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "</tr>";

    $elements_length = count($processing_history[1]);

    if($elements_length > 10)
    {
        $elements_length = 10;
    }

    for($i = 0; $i < $elements_length; $i++) {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . ($i+1) . "</th>";

        $user_name = getUserName($processing_history[1][$i][1]);

        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . "<a href='user_details.php?user_id=" . $processing_history[1][$i][1] . "&page_name=history&previous_page=processing_history.php'>" . $user_name . "</a></th>";

        for($j = 2; $j< $keys_length; $j++)
        {
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $processing_history[1][$i][$j] . "</th>";
        }

        $processing_history_id = $processing_history[1][$i][0];

        $content .= "</tr>";
    }

    $content .= "</table>";

    appendContent($content);
?>