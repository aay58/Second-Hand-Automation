<?php include "query.php" ?>

<?php
    $type = $_GET["type"];

    if($type == "getDistrictContent")
        getDistrictContent();
    elseif($type == "getDistrictFilter")
        getDistrictFilterContent();
    elseif($type == "getAddFavoriteContent")
        getAddFavoriteContent();
    elseif($type == "getDropFavoriteContent")
        getDropFavoriteContent();
    elseif($type == "getBlockContent")
        getBlockContent();
    elseif($type == "getUnblockContent")
        getUnblockContent();

    function getBlockContent()
    {
        $action = $_SESSION["user_name"] . " unblock user named " . getUserName($_POST["user_id"]);
        addProcessingHistory($action);

        $user_id = $_POST["user_id"];
        blockUser($user_id);

        echo "Unblock";
    }

    function getUnblockContent()
    {
        $action = $_SESSION["user_name"] . " unblock user named " . getUserName($_POST["user_id"]);
        addProcessingHistory($action);

        $user_id = $_POST["user_id"];
        unblockUser($user_id);

        echo "Block";
    }

    function getDistrictContent()
    {
        $content = "";

        if($_POST['city_id'] == "#")
            echo $content;
        else
        {
            $content .= "<label>District: </b></label>";
            $districts = getDistricts($_POST['city_id']);
            $keys = array_keys($districts[1]);

            if($districts[0] > 0)
            {
                $elements_length = count($districts[1][$keys[0]]);
                $content .= "<select name='district_id'> ";
                $content .= "<option value='' selected='selected'></option>";

                for($i = 0; $i < $elements_length; $i++)
                {
                    $content .= "<option value='" . $districts[1][$keys[0]][$i] . "'";
                    $content .= ">" . $districts[1][$keys[1]][$i];
                    $content .= "</option>";
                }

                $content .= "</select><br><br>";
            }

            echo $content;
        }
    }

    function getDistrictFilterContent()
    {
        $content = "";

        if($_POST['city_id'] == "#")
            echo $content;
        else
        {
            $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>DISTRICTS</div>";
            $districts = getDistricts($_POST['city_id']);
            //$keys = array_keys($districts[1]);

            if($districts[0] > 0)
            {
                $elements_length = count($districts[1]);
                $content .= "<select style='width: 100%' name='district_id'> ";
                $content .= "<option value='' selected='selected'></option>";

                for($i = 0; $i < $elements_length; $i++)
                {
                    $content .= "<option value='" . $districts[1][$i][0] . "'";
                    $content .= ">" . $districts[1][$i][2];
                    $content .= "</option>";
                }

                $content .= "</select><br><br>";
            }

            echo $content;
        }
    }

    function getAddFavoriteContent()
    {
        session_start();
        $announcement_id = $_POST["id"];
        addFavouriteProduct($announcement_id, $_SESSION["user_id"]);
        
        $action = $_SESSION["user_name"] . " add favorite announcement titled " . getAnnouncementById($announcement_id)[1][0][5];
        addProcessingHistory($action);

        echo "<i class='fa fa-heart'></i>";
    }

    function getDropFavoriteContent()
    {
        session_start();
        $announcement_id = $_POST["id"];
         print_r($announcement_id);
          print_r("asdas");
        dropFavouriteProduct($announcement_id, $_SESSION["user_id"]);
       
        $action = $_SESSION["user_name"] . " drop favorite announcement titled " . getAnnouncementById($announcement_id)[1][0][5];
        addProcessingHistory($action);

        echo "<i class='fa fa-heart-o'></i>";
    }
?>