<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the statistics.";
    addProcessingHistory($action);

    $content = "<br><br><fieldset style='background-color:lightgray'>";
    $content .= "<legend><b>The announcements which are given highest price</b></legend><br>";
    $records = getStatistic1();

    for ($i = 0; $i < $records[0]; $i++)
    {
        $content .= "Title:  <a href='announcement_details.php?id=" . $records[1][$i][0] . "&page_name=statistics&previous_page=statistics.php'>" . $records[1][$i][5] . "</a><br>";
        $content .= "Price:  $" . number_format($records[1][$i][6], 2, ',', '.');

        if ($i+1 != $records[0])
            $content .= "<br><br>";
    }

    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightblue'>";
    $content .= "<legend><b>Average posted announcement per primary member</b></legend><br>";
    $records = getStatistic2();
    $content .= number_format($records[1][0][0], 2, ',', '.');
    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightgray'>";
    $content .= "<legend><b>Average prices of announcements in Ankara</b></legend><br>";
    $records = getStatistic3();
    $content .= "$" . number_format($records[1][0][0], 2, ',', '.');
    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightblue'>";
    $content .= "<legend><b>Count of products are sold but not added in favourite by buyer</b></legend><br>";
    $records = getStatistic4();
    $content .= $records[1][0][0];
    $content .= "</fieldset><br><br>";

    $content .= "<fieldset  style='background-color:lightgray'>";
    $content .= "<legend><b>Count of products that buyer and seller were shopping by sending messages to each other</b></legend><br>";
    $records = getStatistic5();
    $content .= $records[1][0][0];
    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightblue'>";
    $content .= "<legend><b>Average of age of users who offer football and tennis products</b></legend><br>";
    //$records = getStatistic6();
    //$content .= number_format($records[1][0], 1, ',', '.')[0];
    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightgray'>";
    $content .= "<legend><b>The lowest priced announcement in Antalya in December.</b></legend><br>";
    $records = getStatistic7();

    for ($i = 0; $i < $records[0]; $i++)
    {
        $content .= "Title:  <a href='announcement_details.php?id=" . $records[1][$i][0] . "&page_name=statistics&previous_page=statistics.php'>" . $records[1][$i][5] . "</a><br>";
        $content .= "Post Date:  " . $records[1][$i][8] . "<br>";
        $content .= "Price: $" . $records[1][$i][6];

        if ($i+1 != $records[0])
            $content .= "<br><br>";
    }

    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightblue'>";
    $content .= "<legend><b>The average of offers of announcement that is given maximum offers and mark is Sony</b></legend><br>";
    //$records = getStatistic8();
    //$content .= "$" . number_format($records[1][0][0], 2, ',', '.');
    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightgray'>";
    $content .= "<legend><b>The youngest users who has posted more than one complaints</b></legend><br>";
    $records = getStatistic9();

    for ($i = 0; $i < $records[0]; $i++)
    {
        $content .= "User Name:  <a href='user_details.php?user_id=" . $records[1][$i][0] . "&page_name=statistics&previous_page=statistics.php'>" . $records[1][$i][1] . "</a><br>";
        $content .= "Age:  " . $records[1][$i][2];

        if ($i+1 != $records[0])
            $content .= "<br><br>";
    }

    $content .= "</fieldset><br><br>";

    $content .= "<fieldset style='background-color:lightblue'>";
    $content .= "<legend><b>The latest posted announcements which in smart phone category and in Izmir</b></legend><br>";
    $records = getStatistic10();

    for ($i = 0; $i < $records[0]; $i++)
    {
        $content .= "Title:  <a href='announcement_details.php?id=" . $records[1][$i][0] . "&page_name=statistics&previous_page=statistics.php'>" . $records[1][$i][5] . "</a><br>";
        $content .= "Post Date:  " . $records[1][$i][8];

        if ($i+1 != $records[0])
            $content .= "<br><br>";
    }

    $content .= "</fieldset><br><br>";

    appendContent($content);
?>