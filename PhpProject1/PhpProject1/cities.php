<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $cities = getCities();
    $keys = array ("CITY_ID", "NAME");
    $keys_length = count($keys);
    $content = "";

    $action = $_SESSION["user_name"] . " viewed the cities.";
    addProcessingHistory($action);

    $content .= "<input type='button' value='Add City' style='width: 250px; height: 40px; margin-left: 25%; margin-top: 20px' onclick=location.href='add_city.php'>";
    $content .= "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width: 50%; margin-left: 25%; margin-top: 2px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 1; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th>DISTRICTS</th>";
    $content .= "<th>OPERATIONS</th>";
    $content .= "</tr>";

    $elements_length = count($cities[1]);

    for($i = 0; $i < $elements_length; $i++) {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . ($i+1) . "</th>";

        for($j = 1; $j< $keys_length; $j++)
        {
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $cities[1][$i][$j] . "</th>";
        }

        $city_id = $cities[1][$i][0];

        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 150px'>";
        $content .= "<input type='button' value='Districts' onclick=location.href='districts.php?city_id=" . $city_id . "'>";
        $content .= "</th>";

        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 140px'>";
        $content .= "<input type='button' value='Edit' onclick=location.href='edit_city.php?city_id=" . $city_id . "'>";
        $content .= "<input type='button' value='Delete' onclick=location.href='delete.php?page_name=cities.php&table_name=CITY&id_name=CITY_ID&id=" . $city_id . "'>";
        $content .= "</th>";
        $content .= "</tr>";
    }

    $content .= "</table>";

    appendContent($content);
?>