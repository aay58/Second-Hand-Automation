<?php include "base.php"; include "query.php" ?>

<?php
    appendMenuBar(false);

    $action = $_SESSION["user_name"] . " viewed the users.";
    addProcessingHistory($action);

    $users =  getLeadAdmins(); 
    $keys = getLeadAdmins()[0];
    $keys_length = count($keys);

    $content = "";
    $content .= "<div style='width: 300px; float: left; padding-left: 15px;'>";
    $content .= "<form action='users.php' method='post' accept-charset='UTF-8'>";

    appendUserTypeFilter($content);
    appendUserStatusFilter($content);
    appendAgeFilter($content);

    $content .= "<br><input type='submit' style='width: 100%; height: 40px; background-color:darkslategray; color: white;' value='Apply Filter'>";
    $content .= "</form>";

    $content .= "</div>";
    $content .= "<div style='padding-top: 15px; '>";
    $content .= "<table style='float: right; margin-right: 30px; border-style: solid; border-width: 1px; background-color: lightgray; width:calc(100% - 370px); margin-top: 2px'>";
    $content .= "<tr style='border-style: solid; border-width: 1px text-align: left; padding: 5px; background-color: gray'>";
    $content .= "<th> # </th>";

    for($i = 1; $i < $keys_length; $i++)
    {
        $content .= "<th>$keys[$i]</th>";
    }

    $content .= "<th></th>";
    $content .= "</tr>";
    $start_index = 0;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $start_index = 0;
        $user_type = $_POST['user_type'];
        $user_status = $_POST['user_status'];
        $lower_age = $_POST['lower_age'];
        $upper_age = $_POST['upper_age'];

        $users = getUsersByFilter($user_type, $user_status, $lower_age, $upper_age);
        
        getUsers($content, $users, $start_index);
    }
    else
    {
        $start_index = 0;
        getUsers($content, $users, $start_index);
        getUsers($content, getSubAdmins(), $start_index);
    //    getUsers($content, getPrimaryMembers(), $start_index);
        //getUsers($content, getSecondaryMembers(), $start_index);
    }

    $content .= "</table>";
    $content .= "</div>";
    $content .= "<div style='float: inherit; width: calc(100% - 800px); margin-top: 40px; margin-left: calc(50% - 200px)'>";
    $content .= "<form action='download_file.php?type=users' method='post' accept-charset='UTF-8'>";

    if(isset($_POST['user_type']))
    {
        $content .= "<input type='text' style='float:left; display:none' name='user_type' value='" . $_POST['user_type'] . "'>";
        $content .= "<input type='text' style='float:left; display:none' name='user_status' value='" . $_POST['user_status'] . "'>";
        $content .= "<input type='number' style='float:left; display:none' name='lower_age' value='" . $_POST['lower_age'] . "'>";
        $content .= "<input type='number' style='float:left; display:none' name='upper_age' value='" . $_POST['upper_age'] . "'>";
    }

    $content .= "<label style='float: left'><b> Report Format: </b></label>";
    $content .= "<input type='radio' style='float:left' name='report_format' value='html' required>";
    $content .= "<img src='images/icon_html.png' style='float:left' alt='Image not found'>";
    $content .= "<input type='radio' style='float:left' name='report_format' value='txt' required>";
    $content .= "<img src='images/icon_txt.png' style='float:left' alt='Image not found'>";
    $content .= "<input type='radio' style='float:left'  name='report_format' value='pdf' required>";
    $content .= "<img src='images/icon_pdf.png' style='float:left' alt='Image not found'>";
    $content .= "<br><br><br><br><input type='submit' value='Create Report' style='float:inherit; width: 400px; height: 40px;'>";
    $content .= "</form>";
    $content .= "</div>";

    appendContent($content);

    function getUsers(&$content, $users, &$index)
    {
        $keys = $users[0];
     
        $keys_length = count($keys);
        $elements_length = count($users[1]);
        
        for($i = 0; $i < $elements_length; $i++)
        {
            $index += 1;
            $content .= "<tr>";
            $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px'>" . $index . "</th>";
          
            for($j = 1; $j< $keys_length; $j++)
            {
                if($j==1)
                   
            
                if(array_key_exists($j, $users[1][$i]))              
                    $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'>" . $users[1][$i][$j] . "</th>";
                else
                     $content .= "<th style='border-style: solid; border-width: 1px; text-align: left; padding: 5px'></th>";
            }

            $user_id = $users[1][$i][0];

            $content .= "<th style='border-style: solid; border-width: 1px; padding: 5px; width: 200px'>";
            $content .= "<input type='button' value='Details' onclick=location.href='user_details.php?user_id=" . $user_id . "&page_name=users&previous_page=users.php'>";
               
                   
            $user_type = getUserType($user_id);

            
            if($user_type == "member") {
                if(checkUserBLock($user_id))
                {
                    $value = 1;
                    $content .= "<button id='block_" . $user_id . "' value='" . $value . "' onclick='getBlockContent(" . $user_id . ");'>Unblock</button>";
                }
                else
                {
                    $value = 0;
                    $content .= "<button id='block_" . $user_id . "' value='" . $value . "' onclick='getBlockContent(" . $user_id . ");'>Block</button>";
                }
            }

            $content .= "</th>";
            $content .= "</tr>";
        }
    }

   // function getKeyContent()
   // {
   //     $content = "#\t";
  //      $content .= str_pad("USER NAME", 30);
  //      $content .= str_pad("NAME", 30);
  //      $content .= str_pad("SURNAME", 30);
 //       $content .= str_pad("STATUS", 30);
  //      $content .= str_pad("USER TYPE", 30);
  //      $content .= "\n";
//
  //      return $content;
   // }

    function getContent($users, &$index)
    {
        $content = "";
        $keys = $users[0];
        $keys_length = count($keys);
        $elements_length = count($users[1]);

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= ($index + 1) . "\t";
            $index++;

            for($j = 1; $j< $keys_length; $j++)
            {
                $record_str = $users[1][$i][$j];
                $content .= str_pad($record_str, 30);
            }

            $content .= "\n";
        }

        return $content;
    }
?>