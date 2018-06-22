<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $parent_id = $_GET['parent_id'];
    $previous_parent_id = "NULL";

    $action = $_SESSION["user_name"] . " viewed the categories.";
    addProcessingHistory($action);

    if($parent_id != "NULL")
    {
        $previous_parent_id = getPreviousParentCategoryId($parent_id);

        if(!isset($previous_parent_id)) $previous_parent_id = "NULL";
    }

    $categories = getSubCategories($parent_id);
    $keys = array("CATEGORY_ID", "NAME", "PARENT CATEGORY");
    $keys_length = count($keys);

    $content = "";
    $content .= "<input type='button' value='Add Category' style='width: 250px; height: 40px; margin-left: 25%; margin-top: 20px' onclick=location.href='add_category.php?parent_id=" . $parent_id . "'>";
    $content .= "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width: 50%; margin-left: 25%; margin-top: 2px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 1; $i < $keys_length-1; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th>SUB CATEGORIES</th>";
    $content .= "<th>OPERATIONS</th>";
    $content .= "</tr>";

    $elements_length = count($categories[1]);

    for($i = 0; $i < $elements_length; $i++)
    {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . ($i+1) . "</th>";

        for($j = 1; $j< $keys_length-1; $j++) //panret_categoryi koymadım
        {
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $categories[1][$i][$j] . "</th>";
        }

        $category_id = $categories[1][$i][0];

        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 150px'>";
        $content .= "<input type='button' value='Sub Categories' onclick=location.href='categories.php?parent_id=" . $category_id . "'>";
        $content .= "</th>";

        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 140px'>";
        $content .= "<input type='button' value='Edit' onclick=location.href='edit_category.php?parent_id=" . $parent_id . "&category_id=" . $category_id . "'>";
        $content .= "<input type='button' value='Delete' onclick=location.href='delete.php?page_name=categories.php?parent_id=" . $parent_id . "&table_name=CATEGORY&id_name=CATEGORY_ID&id=" . $category_id . "'>";
        $content .= "</th>";
        $content .= "</tr>";
    }

    $content .= "</table>";

    if($parent_id != "NULL")
    {
        $content .= "<br><input type='button' value='Back to Categories' style='margin-left: 25%;' onclick=location.href='categories.php?parent_id=" . $previous_parent_id . "'>";
    }

    appendContent($content);
?>