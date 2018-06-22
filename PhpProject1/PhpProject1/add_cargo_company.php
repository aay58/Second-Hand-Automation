<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(checkCargoCompany($_POST['name']))
        {
            $message = "Error! This cargo company has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='add_cargo_company.php';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " added a cargo company named " . $_POST['name'] . ".";
            addProcessingHistory($action);

            addCargoCompany($_POST);
            $message = "The cargo company has been successfully added.";
            echo "<script type='text/javascript'>alert('$message');location.href='cargo_companies.php'; </script>";
        }
    }

    $content = "";
    $content .= "<form action='add_cargo_company.php' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Add Cargo Company</b></legend><br>";
    $content .= "<label>Name:</b></label><input type='text' name='name' maxlength='20' title='Enter name' required/><br><br>";
    $content .= "<label>Address:</b></label><input type='text' name='address' maxlength='100' title='Enter address' required/><br><br>";
    $content .= "<label>Phone Number:</b></label><input type='text' name='phone_number' maxlength='10' title='Enter phone number' required/><br><br>";
    $content .= "<br><input type='button' value='Back to Cargo Companies' onclick=location.href='cargo_companies.php'>";
    $content .= "<input type='submit' name='add' value='Add'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>