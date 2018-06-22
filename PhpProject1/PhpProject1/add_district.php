<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $city_id = $_GET['city_id'];

    if(isset($_POST["city_id"])) $city_id = $_POST['city_id'];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(checkDistrict($_POST['district_name'], $city_id))
        {
            $message = "Error! This district has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='add_district.php?city_id=" . $city_id . "';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " added a district named " . $_POST["district_name"] . " to " . getCityName($city_id) . ".";
            addProcessingHistory($action);

            addDistrict($_POST["district_name"], $city_id);
            $message = "The district has been successfully added.";
            echo "<script type='text/javascript'>alert('$message');location.href='districts.php?city_id=" . $city_id . "'; </script>";
        }
    }

    $content = "";
    $content .= "<form action='add_district.php?city_id='" . $city_id . "' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Add District</b></legend><br>";
    $content .= "<label>Name:</b></label><input type='text' name='district_name' maxlength='20' title='Enter district name' required/><br><br>";
    $content .= "<input name='city_id' value='" . $city_id . "' style='display: none'><br>";
    $content .= "<input type='button' value='Back to Districts' onclick=location.href='districts.php?city_id=" . $city_id . "'>";
    $content .= "<input type='submit' name='add' value='Add'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>