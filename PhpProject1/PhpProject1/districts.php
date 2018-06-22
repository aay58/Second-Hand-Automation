<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $city_id = $_GET['city_id'];
    $districts = getDistricts($city_id);

    $city_name = getCityName($city_id);
    $action = $_SESSION["user_name"] . " viewed the districts of " . $city_name . ".";
    addProcessingHistory($action);

    $keys = array ("DISTRICT_ID", "CITY", "DISTRICT");
    $keys_length = count($keys);
    $content = "";

    $content .= "<input type='button' value='Add District' style='width: 250px; height: 40px; margin-left: 30%; margin-top: 20px' onclick=location.href='add_district.php?city_id=" . $city_id . "'>";
    $content .= "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width: 40%; margin-left: 30%; margin-top: 2px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 1; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th>OPERATIONS</th>";
    $content .= "</tr>";

    $elements_length = count($districts[1]);

    for($i = 0; $i < $elements_length; $i++)
    {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . ($i+1) . "</th>";

        for($j = 1; $j< $keys_length; $j++)
        {
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $districts[1][$i][$j]. "</th>";
        }

        $district_id = $districts[1][$i][0];

        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px; width: 140px'>";
        $content .= "<input type='button' value='Edit' onclick=location.href='edit_district.php?city_id=" . $city_id . "&district_id=" . $district_id . "'>";
        $content .= "<input type='button' value='Delete' onclick=location.href='delete.php?page_name=districts.php?city_id=" . $city_id . "&table_name=DISTRICT&id_name=DISTRICT_ID&id=" . $district_id . "'>";
        $content .= "</th>";
        $content .= "</tr>";
    }

    $content .= "</table><br>";
    $content .= "<input type='button' value='Back to cities' style='margin-left: 30%' onclick=location.href='cities.php'>";

    appendContent($content);
?>