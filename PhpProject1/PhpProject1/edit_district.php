<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $city_id = $_GET['city_id'];
    $previous_city_id = $_GET['city_id'];
    $district_id = $_GET['district_id'];

    if(isset($_POST['city_id']) && isset($_POST['district_id']) && isset($_POST['previous_city_id']))
    {
        $city_id = $_POST['city_id'];
        $previous_city_id = $_POST['previous_city_id'];
        $district_id = $_POST['district_id'];
    }

    $district_name = getDistrictName($district_id);
    print_r($district_name);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!($district_name == $_POST['district_name'] || !checkDistrict($_POST['district_name'], $city_id)))
        {
            $message = "Error! This district has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='edit_district.php?previous_city_id=". $previous_city_id ."&city_id=" . $city_id . "&district_id=" . $district_id . "';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " edited district.";
            addProcessingHistory($action);

            updateDistrict($district_id, $city_id, $_POST['district_name']);
            $message = "The district has been successfully updated.";
            echo "<script type='text/javascript'>alert('$message');location.href='districts.php?city_id=" . $previous_city_id . "'; </script>";
        }
    }

    $content = "";
    $content .= "<form action='edit_district.php?previous_city_id=". $previous_city_id ."&city_id=" . $city_id . "&district_id=" . $district_id . "' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Edit District</b></legend><br>";
    
    $cities = getCities();
    
    $keys = array_keys($cities[1]);
    
    $keys_length = $cities[0];
    
    $selected_city_name = getCityName($city_id);

    if($cities[0] > 0)
    {
       
        
        $content .= "<label>Cities: </b></label>";
        $content .= "<select name='city_id'>";

        for($i = 0; $i < $keys_length; $i++)
        {
            $content .= "<option value='" . $cities[1][$keys[$i]][0] . "'";

            if($cities[1][$keys[1]][$i] == $selected_city_name) {
                $content .= "selected='selected'";
            }

            $content .= ">" . $cities[1][$keys[$i]][1];
            $content .= "</option>";
        }

        $content .= "</select><br><br>";
    }

    $content .= "<label>Name:</b></label><input type='text' name='district_name' value='" . $district_name . "' maxlength='20' title='Enter district name' required/><br><br>";
    $content .= "<input name='previous_city_id' value='" . $previous_city_id . "' style='display: none'>";
    $content .= "<input name='district_id' value='" . $district_id . "' style='display: none'>";
    $content .= "<input type='button' value='Back to Districts' onclick=location.href='districts.php?city_id=" . $city_id . "'>";
    $content .= "<input type='submit' value='Update'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>