<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $cargo_companies = getCargoCompanies();
    $keys = array ("COMPANY_ID", "NAME", "ADDRESS", "PHONE_NUMBER");
    $keys_length = count($keys);

    $action = $_SESSION["user_name"] . " viewed the cargo companies.";
    addProcessingHistory($action);

    $content = "";
    $content .= "<input type='button' value='Add Cargo Company' style='width: 250px; height: 40px; margin-left: 25%; margin-top: 20px' onclick=location.href='add_cargo_company.php'>";
    $content .= "<table style='border-style: solid; border-width: 1px; background-color: lightgray; width: 50%; margin-left: 25%; margin-top: 2px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 1; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th>OPERATIONS</th>";
    $content .= "</tr>";

    $elements_length = count($cargo_companies[1]);

    for($i = 0; $i < $elements_length; $i++) {
        $content .= "<tr>";
        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . ($i+1) . "</th>";

        for($j = 1; $j< $keys_length; $j++)
        {
            $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $cargo_companies[1][$i][$j] . "</th>";
        }

        $cargo_company_id = $cargo_companies[1][$i][0];

        $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 140px'>";
        $content .= "<input type='button' value='Edit' onclick=location.href='edit_cargo_company.php?cargo_company_id=" . $cargo_company_id . "'>";
        $content .= "<input type='button' value='Delete' onclick=location.href='delete.php?page_name=cargo_companies.php&table_name=CARGOCOMPANY&id_name=CARGO_COMPANY_ID&id=" . $cargo_company_id . "'>";
        $content .= "</th>";
        $content .= "</tr>";
    }

    $content .= "</table>";

    appendContent($content);
?>