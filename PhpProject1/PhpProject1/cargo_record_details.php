<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    $cargo_record_id = $_GET['id'];

    $elements =  getCargoRecord($cargo_record_id);
     $keys = array ("NAME", "ADDRESS"," PHONE_NUMBER", "DATE");
    $count = count($keys);
   
   
    

    $content = "";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Cargo Record Details</b></legend><br>";
    for($i = 0; $i < $count; $i=$i+1)
    {
        $element = $elements[1][0][$i];
        $content .= "<b>" . $keys[$i] . ": </b>";
        $content .= $element . "<br><br>";
    }

    $content .= "<input type='button' value='Back to sale records' onclick=location.href='sale_records.php'>";
    $content .= "</fieldset>";

    appendContent($content);
?>