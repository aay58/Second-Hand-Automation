<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the complaints.";
    addProcessingHistory($action);

    $complaints = getComplaints();
    $keys = array ("COMPLAINT_ID", "USER",  "SUBJECT", "DETAILS");
    $keys_length = count($keys);

    $content = "";
    $content = "<table id ='complaints_table' style='border-style: solid; border-width: 1px; background-color: lightgray; width: 80%; margin-left: 10%; margin-top: 20px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th>  #  </th>";

    for($i = 1; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th></th>";
    $content .= "</tr>";

    $elements_length = count($complaints[1]);

    for($i = 0; $i < $elements_length; $i++) {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . ($i+1) . "</th>";

        for($j = 1; $j< $keys_length; $j++)
        {
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $complaints[1][$i][$j] . "</th>";
        }

        $complaint_id = $complaints[1][$i][0];

        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>";
        $content .= "<input type='button' value='Details' onclick=location.href='complaint_details.php?complaint_id=" . $complaint_id . "'>";
        $content .= "<input type='button' value='Delete' onclick=location.href='delete.php?page_name=complaints.php&table_name=COMPLAINT&id_name=COMPLAINT_ID&id=" . $complaint_id . "'>";
        $content .= "</th>";
        $content .= "</tr>";
    }

    $content .= "</table>";

    appendContent($content);
?>