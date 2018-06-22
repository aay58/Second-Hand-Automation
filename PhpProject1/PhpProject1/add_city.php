<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(checkCity($_POST['city_name']))
        {
            $message = "Error! This city has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='add_city.php';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " added a city named " . $_POST["city_name"] . ".";
            addProcessingHistory($action);

            addCity($_POST["city_name"]);
            $message = "The city has been successfully added.";
            echo "<script type='text/javascript'>alert('$message');location.href='cities.php'; </script>";
        }
    }

    $content = "";
    $content .= "<form action='add_city.php' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Add City</b></legend><br>";
    $content .= "<label>Name:</b></label><input type='text' name='city_name' maxlength='20' title='Enter city name' required/><br><br>";
    $content .= "<br><input type='button' value='Back to Cities' onclick=location.href='cities.php'>";
    $content .= "<input type='submit' name='add' value='Add'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>