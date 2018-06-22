<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $city_id = $_GET['city_id'];

    if(isset($_POST["city_id"])) $city_id = $_POST["city_id"];

    $city_name = getCityName($city_id);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if($city_name != $_POST['city_name'] && checkCity($_POST['city_name']))
        {
            $message = "Error! This city has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='edit_city.php?city_id=" . $city_id . "';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " edited city.";
            addProcessingHistory($action);

            updateCity($city_id, $_POST['city_name']);
            $message = "The city has been successfully updated.";
            echo "<script type='text/javascript'>alert('$message');location.href='cities.php'; </script>";
        }
    }


    $content = "";
    $content .= "<form id='edit_city' action='edit_city.php?city_id=" . $city_id . "' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Edit City</b></legend><br>";
    $content .= "<label>Name:</b></label><input type='text' name='city_name' value='" . $city_name . "' maxlength='20' title='Enter city name' required/><br><br>";
    $content .= "<input name='city_id' value='" . $city_id . "' style='display: none'><br>";
    $content .= "<input type='button' value='Back to Cities' onclick=location.href='cities.php'>";
    $content .= "<input type='submit' name='update' value='Update'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>