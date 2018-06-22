<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    $complaint_id = $_GET['complaint_id'];
    $elements =  getComplaintAndUser($complaint_id);
    $keys = array ("USER_NAME", "NAME","SURNAME","SUBJECT","TEXT");
    print_r($elements[1]);
    $count = count($keys);
    
    $action = $_SESSION["user_name"] . " viewed the compaint details of " . $elements[1][0][1] . ".";
    addProcessingHistory($action);

    $content = "";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Complaint Details</b></legend><br>";

    for($i = 0; $i < $count; $i++)
    {
        if($i==3)
             $element = $elements[1][0][5];

        else
           $element = $elements[1][0][$i+1];
        $content .= $keys[$i] . ": ";
        $content .= $element . "<br><br>";
    }

    $content .= "<input type='button' value='Back to complaints' onclick=location.href='complaints.php'>";
    $content .= "</fieldset>";

    appendContent($content);
?>