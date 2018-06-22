<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    if(isset($_POST['page_name']))
    {
        $page_name = $_POST['page_name'];
        $table_name = $_POST['table_name'];
        $id_name = $_POST['id_name'];
        $id = $_POST['deleted_id'];
        $message = "Deletion is successful.";

        $deletedObject = strtolower($page_name);
        $action = $_SESSION["user_name"] . " deleted " . $deletedObject . ".";
        addProcessingHistory($action);

        delete($table_name, $id_name, $id);

        echo "<script type='text/javascript'>alert('$message');location.href='" . $page_name . "'; </script>";
    }
    else
    {
        $page_name = $_GET['page_name'];
        $table_name = $_GET['table_name'];
        $id_name = $_GET['id_name'];
        $id = $_GET['id'];
        $page = explode(".", $page_name)[0];

        $content = "";
        $content .= "<fieldset>";
        $content .= "<form action='delete.php' method='post' accept-charset='UTF-8'>";
        $content .= "<legend style='color:gray'><b>Delete</b></legend><br>";
        $content .= "<label style='color: red'><b>" . "Are you sure you want to delete?" . "</b></label><br><br>";
        $content .= "<br><input type='button' value='Back to " . $page . "' onclick=location.href='" . $page_name . "'>";
        $content .= "<input type='text' style='float:left; display:none' name='page_name' value='" . $page_name . "'>";
        $content .= "<input type='text' style='float:left; display:none' name='table_name' value='" . $table_name . "'>";
        $content .= "<input type='text' style='float:left; display:none' name='id_name' value='" . $id_name . "'>";
        $content .= "<input type='number' style='float:left; display:none' name='deleted_id' value='" . $id . "'>";
        $content .= "<input type='submit' value='Delete'>";
        $content .= "</form>";
        $content .= "</fieldset>";

        appendContent($content);
    }
?>