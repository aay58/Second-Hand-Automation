<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the favourite products.";
    addProcessingHistory($action);

    $products = getFavouriteProductsById($_SESSION["user_id"]);
    $keys = array ("TITLE","PRICE");
    
    print_r($keys);
    $keys_length = count($keys);
    $content = "";

    $content .= "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width:90%; margin-left:5%; margin-top: 40px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 0; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "</tr>";

    $elements_length = count($products[1]);

    for($i = 0; $i < $elements_length; $i++)
    {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . ($i+1) . "</th>";
        $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'><a href='announcement_details.php?id=" . $products[1][$i][0] . "&page_name=Favourites&previous_page=favourite_products.php'>" . $products[1][$i][1] . "</a></th>";

        for($j = 2; $j <= $keys_length; $j++)
        {
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $products[1][$i][$j] . "</th>";
        }

        $content .= "</tr>";
    }

    $content .= "</table>";

    appendContent($content);
?>