<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    if(isset($_GET['id']) && isset($_GET['page_number']) && isset($_GET['page_name'])) {
        $announcement_id = $_GET['id'];
        $page_number = $_GET['page_number'];
        $page_name = $_GET['page_name'];
    }
    else
    {
        $announcement_id = $_POST['id'];
        $page_number = $_POST['page_number'];
        $page_name = $_POST['page_name'];
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!checkPrice($announcement_id, $_POST['price']))
        {
            $message = "Error! You have to exceed the highest offer!";
            echo "<script type='text/javascript'>alert('$message');location.href='offer.php?id=" . $announcement_id . "&page_name=". $page_name ."&page_number=" . $page_number . "'; </script>";
        }
        else
        {
            $announcement_title = getAnnouncementById($_POST["id"])[1]["TITLE"][0];
            $action = $_SESSION["user_name"] . " offered to the announcement titled " . $announcement_title . ".";
            addProcessingHistory($action);

            addOffer($_POST);
            $message = "Your offer has been successful.";
            echo "<script type='text/javascript'>alert('$message');location.href='index.php?page_number=" . $page_number . "'; </script>";
        }
    }

    $content = "";
    $content .= "<form action='offer.php' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Offer</b></legend><br>";
    $content .= "<label>Price: </label><input type='number' name='price' maxlength='20' required/><br><br>";
    $content .= "<input name='id' style='display:none' value=" . $announcement_id . ">";
    $content .= "<input name='page_name' style='display:none' value='" . $page_name . "'>";
    $content .= "<input name='page_number' style='display:none' value=" . $page_number . ">";

    if ($page_name == "index")
        $content .= "<br><input type='button' value='Back to index' onclick=location.href='page_number=" . $page_number . "'>";
    elseif ($page_name == "announcement_details")
        $content .= "<br><input type='button' value='Back to announcement details' onclick=location.href='announcement_details.php?id=" . $announcement_id . "&page_number=" . $page_number . "'>";

    $content .= "<input type='submit' value='Offer'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>