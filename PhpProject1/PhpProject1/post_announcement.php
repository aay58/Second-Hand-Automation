<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(count($_FILES["image"]["name"]) > 5) {
            $error_message = "You can not upload more than 5 photos!";
            echo "<script type='text/javascript'>alert('$error_message')</script>";
        }
        else {
            $message = "The announcement has been successfully added. \\n";
            $error_message = addAnnouncement($_POST, $_FILES);

            if($error_message == '') {
                $action = $_SESSION["user_name"] . " posted announcement titled " . $_POST['title'] . ".";
                addProcessingHistory($action);

                echo "<script type='text/javascript'>alert('$message');location.href='index.php'; </script>";
            }
            else
                echo "<script type='text/javascript'>alert('" . $message . $error_message . "');location.href='index.php'; </script>";
        }
    }

    $content = "<form id='ann' action='post_announcement.php' method='post' accept-charset='UTF-8' enctype='multipart/form-data'>";
    $content .= "<fieldset><legend style='color:gray'><b>Post Announcement</b></legend>";
    $content .= "<fieldset><br>";
    $content .= "<label>Product Name: </label><input type='text' name='product_name' maxlength='50' required/><br><br>";
    $content .= "<label>Color: </label><input type='text' name='color' maxlength='20'/><br><br>";
    $content .= "<label>Mark: </label><input type='text' name='mark' maxlength='20'/><br><br>";
    $content .= "<label>Dimension: </label><input type='text' name='dimension' maxlength='20'/><br><br>";
    $content .= "<label>Image: </label><input type='file' name='image[]' id='image' accept='image/*' multiple ><br>";
    $content .= "</fieldset><br>";
    $content .= "<fieldset><br>";
    $content .= "<label>Announcement Title: </label><input type='text' name='title' maxlength='100' required/><br><br>";
    $content .= "<label>Announcement Text: </label><textarea rows='5' cols='100' maxlength='1000' title='Enter text' name='ann_text'></textarea><br><br>";
    $content .= "<label>Price: </label><input type='number' name='price' maxlength='20' required/><br><br>";
    $content .= "<label>Guarantee Start Date: </label><input type='date' name='g_start' maxlength='30'/><br><br>";
    $content .= "<label>Guarantee End Date: </label><input type='date' name='g_end' maxlength='30'/><br><br>";
    $content .= "<label>Category: </b></label>";

    announcementCategories($content);

    $cities = getCities();
    $keys = array_keys($cities[1]);

    if($cities[0] > 0)
    {
        $elements_length = count($cities[1][$keys[0]]);

        $content .= "<br><br><label>City: </b></label>";
        $content .= "<select required name='city_id' onChange='getDistrictContent(this.value);'>";
        $content .= "<option value='' selected='selected'></option>";

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<option value='" . $cities[1][$keys[0]][$i] . "'";
            $content .= ">" . $cities[1][$keys[1]][$i];
            $content .= "</option>";
        }

        $content .= "</select><br><br>";
    }

    $content .= "<div id='district_list'></div>";
    $content .= "<br><br><input type='button' value='Back to Home Page' onclick=location.href='index.php'>";
    $content .= "<input type='submit' name='Submit' value='Post Announcement'>";
    $content .= "</fieldset>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>