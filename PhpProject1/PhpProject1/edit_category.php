<?php include "query.php"; include "base.php"; ?>

<?php
    appendMenuBar(false);

    $parent_id = $_GET['parent_id'];
    $previous_category_id = $_GET['parent_id'];
    $category_id = $_GET['category_id'];

    if(isset($_POST['parent_id']) && isset($_POST['category_id']) && isset($_POST['previous_category_id']))
    {
        $parent_id = $_POST['parent_id'];
        $previous_category_id = $_POST['previous_category_id'];
        $category_id = $_POST['category_id'];
    }

    $category_name = getCategoryName($category_id);
    $parent_name = getCategoryName($parent_id);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!($category_name == $_POST['category_name'] || !checkCategory($_POST['category_name'], $parent_id)))
        {
            $message = "Error! This category has already been added!";
            echo "<script type='text/javascript'>alert('$message');location.href='edit_category.php?previous_category_id=". $previous_category_id . "&parent_id=" . $parent_id . "&category_id=" . $category_id . "';</script>";
        }
        else
        {
            $action = $_SESSION["user_name"] . " edited category.";
            addProcessingHistory($action);

            updateCategory($category_id, $parent_id, $_POST['category_name']);
            $message = "The category has been successfully updated.";
            echo "<script type='text/javascript'>alert('$message');location.href='categories.php?parent_id=" . $previous_category_id . "'; </script>";
        }
    }

    $content = "";
    $content .= "<form action='edit_category.php?previous_category_id=". $previous_category_id . "&parent_id=" . $parent_id . "&category_id=" . $category_id . "' method='post' accept-charset='UTF-8'>";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Edit Category</b></legend><br>";

    $categories = getCategories();;
    $keys_length = count($categories);


    if($categories[0] > 0)
    {
        $elements_length = count($categories[1][2]);

        $content .= "<label>Categories: </b></label>";
        $content .= "<select name='parent_id'>";

        $content .= "<option value='NULL'>#</option>";
        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<option value='" . $categories[1][$i][0] . "'";

            if($categories[1][$i][2] == $parent_name) {
                $content .= "selected='selected'";
            }

            $content .= ">" . $categories[1][$i][2];
            $content .= "</option>";
        }

        $content .= "</select><br><br>";
    }

    $content .= "<label>Name:</b></label><input type='text' name='category_name' value='" . $category_name . "' maxlength='30' title='Enter name' required/><br><br>";
    $content .= "<input name='category_id' value='" . $category_id . "' style='display: none'>";
    $content .= "<input name='previous_category_id' value='" . $previous_category_id . "' style='display: none'>";
    $content .= "<input type='button' value='Back to Categories' onclick=location.href='categories.php?parent_id=" . $parent_id . "'>";
    $content .= "<input type='submit' value='Update'>";
    $content .= "</fieldset>";
    $content .= "</form>";

    appendContent($content);
?>