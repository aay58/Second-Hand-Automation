<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the sale records.";
    addProcessingHistory($action);

    $sale_records = getSaleRecords();
    $keys = array("RECORD_ID","ANNOUNCEMENT_ID","PRICE","SELLER_ID","BUYER_ID", "TITLE", "SELLER", "BUYER");
    $keys_length = count($keys);

    $content = "";
    $content .= "<div style='width: 300px; float: left; padding-left: 15px;'>";
    $content .= "<form action='sale_records.php' method='post' accept-charset='UTF-8'>";

    appendSellerFilter($content);
    appendBuyerFilter($content);
    appendPriceFilter($content);

    $content .= "<br><input type='submit' style='width: 100%; height: 40px; background-color:darkslategray; color: white;' value='Apply Filter'>";
    $content .= "</form>";

    $content .= "</div>";
    $content .= "<div style='padding-top: 15px; '>";
    $content .= "<table style='float: right; margin-right: 30px; border-style: solid; border-width: 1px; background-color: lightgray; width:calc(100% - 370px); margin-top: 2px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 5; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th></th>";
    $content .= "</tr>";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $seller_name = $_POST['seller_name'];
        $buyer_name = $_POST['buyer_name'];
        $lower_age = $_POST['lower_price'];
        $upper_age = $_POST['upper_price'];

        $sale_records = getSaleRecordsByFilter($seller_name, $buyer_name, $lower_age, $upper_age);
        getSaleRecordTable($content, $sale_records);
    }
    else
    {
        getSaleRecordTable($content, $sale_records);
    }

    $content .= "</table>";
    $content .= "</div>";
    $content .= "<div style='float: inherit; width: calc(100% - 800px); margin-top: 40px; margin-left: calc(50% - 200px)'>";
    $content .= "<form action='download_file.php?type=sale_records' method='post' accept-charset='UTF-8'>";

    if(isset($_POST['seller_name']))
    {
        $content .= "<input type='text' style='float:left; display:none' name='seller_name' value='" . $_POST['seller_name'] . "'>";
        $content .= "<input type='text' style='float:left; display:none' name='buyer_name' value='" . $_POST['buyer_name'] . "'>";
        $content .= "<input type='number' style='float:left; display:none' name='lower_price' value='" . $_POST['lower_price'] . "'>";
        $content .= "<input type='number' style='float:left; display:none' name='upper_price' value='" . $_POST['upper_price'] . "'>";
    }

    $content .= "<label style='float: left'><b> Report Format: </b></label>";
    $content .= "<input type='radio' style='float:left' name='report_format' value='html' required>";
    $content .= "<img src='images/icon_html.png' style='float:left' alt='Image not found'>";
    $content .= "<input type='radio' style='float:left' name='report_format' value='txt' required>";
    $content .= "<img src='images/icon_txt.png' style='float:left' alt='Image not found'>";
    $content .= "<input type='radio' style='float:left'  name='report_format' value='pdf' required>";
    $content .= "<img src='images/icon_pdf.png' style='float:left' alt='Image not found'>";
    $content .= "<br><br><br><br><input type='submit' value='Create Report' style='float:inherit; width: 400px; height: 40px;'>";
    $content .= "</form>";
    $content .= "</div>";

    appendContent($content);

    function getSaleRecordTable(&$content, $sale_records)
    {      
        $keys = array("RECORD_ID","ANNOUNCEMENT_ID","PRICE","SELLER_ID","BUYER_ID", "TITLE", "SELLER", "BUYER");
        $keys_length = count($keys);
        $elements_length = count($sale_records[1]);

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<tr>";
            $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . ($i+1) . "</th>";

            for($j = 5; $j< $keys_length; $j++)
            {
                $record_str = str_replace('"', '\"', $sale_records[1][$i][$j]);

                if($keys[$j] == 'SELLER')
                    $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'><a href='user_details.php?user_id=" . $sale_records[1][$i][3] . "&page_name=records&previous_page=sale_records.php'>" . $record_str . "</a></th>";
                elseif ($keys[$j] == 'BUYER')
                    $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'><a href='user_details.php?user_id=" . $sale_records[1][$i][4] . "&page_name=records&previous_page=sale_records.php'>" . $record_str . "</a></th>";
                elseif ($keys[$j] == 'TITLE')
                    $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'><a href='announcement_details.php?id=" . $sale_records[1][$i][1] . "&page_name=records&previous_page=sale_records.php'>" . $record_str . "</a></th>";
                else
                    $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $record_str . "</th>";
            }

            $record_id = $sale_records[1][$i][0];
            $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 200px'>";
            $content .= "<input type='button' value='Cargo Details' onclick=location.href='cargo_record_details.php?id=" . $record_id . "'>";
            $content .= "</th>";
            $content .= "</tr>";
        }
    }
?>

