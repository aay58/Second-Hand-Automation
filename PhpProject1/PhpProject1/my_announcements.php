<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $announcements = getAnnouncementsOfUser($_SESSION["user_id"]);
    
    $action = $_SESSION["user_name"] . " viewed the own announcements.";
    
    addProcessingHistory($action);

    $keys = array ("TITLE", "PRICE");
    $keys_length = count($keys);
    $content = "";

    $content .= "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width: 80%; margin-left: 10%; margin-top: 20px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 0; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th> City </th>";
    $content .= "<th> District </th>";

    $content .= "<th></th>";
    $content .= "</tr>";
   
    
    $elements_length = $announcements[0];
 
    for($i = 0; $i < $elements_length; $i++)
    {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . ($i+1) . "</th>";

       
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $announcements[1][$i][3] . "</th>";
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $announcements[1][$i][4] . "</th>";
        

        $city_name = getCityName($announcements[1][$i][1]);
        $district_name = getDistrictName($announcements[1][$i][2]);
        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $city_name . "</th>";
        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $district_name . "</th>";

        $announcement_id = $announcements[1][$i][0];

        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px; width: 160px'>";
        $content .= "<input type='button' value='Details' onclick=location.href='announcement_details.php?id=" . $announcement_id . "&page_name=announcements&previous_page=my_announcements.php'>";
        $content .= "<input type='button' value='Delete' onclick=location.href='delete.php?page_name=my_announcements.php&table_name=ANNOUNCEMENT&id_name=ANNOUNCEMENT_ID&id=" . $announcement_id . "'>";
        $content .= "</th>";
        $content .= "</tr>";
    }

    $content .= "</table><br>";

    appendContent($content);
?>