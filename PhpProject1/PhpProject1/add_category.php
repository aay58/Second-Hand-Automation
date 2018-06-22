<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $parent_id = $_GET['parent_id'];

    if(isset($_POST["parent_id"])) $parent_id = $_POST['parent_id'];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(checkCategory($_POST['name'], $parent_id))
        {
            $message = "Error! This category has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='add_category.php?parent_id=" . $parent_id . "';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " added a category named " . $_POST['name'] . ".";
            addProcessingHistory($action);

            addCategory($parent_id, $_POST['name']);
            
        }
    }

    $content = "";
    $content .= "<form action='add_category.php?parent_id=" . $parent_id . "' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Add Category</b></legend><br>";
    $content .= "<label>Name:</b></label><input type='text' name='name' maxlength='30' title='Enter name' required/><br><br>";
    $content .= "<input name='parent_id' value='" . $parent_id . "' style='display: none'><br>";
    $content .= "<input type='button' value='Back to Categories' onclick=location.href='categories.php?parent_id=" . $parent_id . "'>";
    $content .= "<input type='submit' name='add' value='Add'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>