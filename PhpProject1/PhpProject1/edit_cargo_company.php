<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $cargo_company_id = $_GET['cargo_company_id'];

    if(isset($_POST["cargo_company_id"])) $cargo_company_id = $_POST["cargo_company_id"];

    $name = getCargoCompanyName($cargo_company_id);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if($name != $_POST['name'] && checkCargoCompany($_POST['name']))
        {
            $message = "Error! This cargo company has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='edit_cargo_company.php?cargo_company_id=" . $cargo_company_id . "';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " edited cargo company.";
            addProcessingHistory($action);

            updateCargoCompany($_POST);
            $message = "The cargo company has been successfully updated.";
            echo "<script type='text/javascript'>alert('$message');location.href='cargo_companies.php'; </script>";
        }
    }

    $cargo_company = getCargoCompany($cargo_company_id)[1];

    $content = "";
    $content .= "<form action='edit_cargo_company.php?cargo_company_id=" . $cargo_company_id . "' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Edit Cargo Company</b></legend><br>";
    $content .= "<label>Name:</b></label><input type='text' name='name' value='" . $cargo_company[1][0] . "' maxlength='20' title='Enter name' required/><br><br>";
    $content .= "<label>Address:</b></label><input type='text' name='address' value='" . $cargo_company[2][0] . "' maxlength='100' title='Enter address' required/><br><br>";
    $content .= "<label>Phone Number:</b></label><input type='text' name='phone_number' value='" . $cargo_company[3][0] . "' maxlength='10' title='Enter phone number' required/><br><br>";
    $content .= "<input name='cargo_company_id' value='" . $cargo_company_id . "' style='display: none'><br>";
    $content .= "<input type='button' value='Back to Cargo Companies' onclick=location.href='cargo_companies.php'>";
    $content .= "<input type='submit' name='update' value='Update'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>