<?php include "connection.php"; ?>

<?php
    // check functions --------------------------------------------------------------------

   function checkUsername($user_name) {
     
            $query=   "SELECT * FROM `USERS` WHERE `USER_NAME` LIKE '" .$user_name. "';";
        
    $r = mysqli_query ($db, $query);

    if (mysqli_num_rows($r) == 0) { // No: of rows returned. 0 results, Hence the username is Available.
      
    return true;
} else {
  
    return false;
}

     
       

       
}
  function addProcessingHistory($text)
    {
         global  $db;
        if(!isset($_SESSION["user_type"]))
            return;

        if($_SESSION["user_type"] == "lead_admin" || $_SESSION["user_type"] == "sub_admin")
            return;
            
        $currentTime = date('d/m/Y H:i:s', time());
        
             $query="CALL INSERTPROCESSINGHISTORY('".$_SESSION["user_id"]."', '".$text."','".$currentTime.")";                 
               mysqli_query($db,$query);

    }

// get functions --------------------------------------------------------------------
    function getUser($user_name) {
        global $db;
        $query=   "SELECT * FROM `USERS` WHERE `USER_NAME` LIKE'" .$user_name. "';";
      
        $result= mysqli_query($db,$query);
        $row = mysqli_fetch_array($result);
       
        return  ($row);
    }
    function getMemberStatus($user_id)
    {
        global $db;
        $query=   "SELECT `STATUS` FROM `MEMBERS` WHERE `USER_ID`'" .$user_id. "';";
      
        $result= mysqli_query($db,$query);
        $row = mysqli_fetch_array($result);
      
        return  ($row);
           
    }
    function getUserType($user_id)
    {
        global  $db; 
        $query=   "SELECT * FROM `MEMBERS` WHERE `USER_ID`='" .$user_id. "';";
        $r = mysqli_query ($db, $query);
            
        if (mysqli_num_rows($r) > 0){
             return 'member';
        } 
     
        $query=   "SELECT * FROM `sub_admin_details` WHERE `USER_ID`='" .$user_id. "'";     
        $r = mysqli_query ($db, $query);
        if (mysqli_num_rows($r) > 0) 
                return 'sub_admin';
        
        $query=   "SELECT * FROM `leadadmins` WHERE `USER_ID`='" .$user_id. "'";
        $r = mysqli_query ($db, $query);
        if (mysqli_num_rows($r) > 0) 
            return 'lead_admin';
  }
  

    function getWishList($user_id)
    {
        global  $db;
        $query=   "SELECT * FROM `wishlists` WHERE `USER_ID`='" .$user_id. "';";   
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }
    
     function getAnnouncementMainInfo($status, $category_id, $price, $city_id, $district_id) {
        $query = "SELECT A.`ANNOUNCEMENT_ID`,A.`TITLE`, A.`PRICE` FROM PRODUCTS P,ANNOUNCEMENTS A ";
        $query .= "WHERE  P.`PRODUCT_ID`  =A.`PRODUCT_ID`  AND A.`ANNOUNCEMENT_STATUS` = '" . $status . "'";

        if($category_id != 0)
            $query .= " AND P.`CATEGORY_ID`  = " . $category_id;

        if($price != 0)
            $query .= " AND  A.`PRICE` >= " . $price;

        if($city_id != 0)
            $query .= " AND A.`CITY_ID`   = " . $city_id;

        if($district_id != 0)
            $query .= " AND A.`DISTRICT_ID`  = " . $district_id;

        global $db;
        $query .= " ORDER BY A.`PRODUCT_ID`  ASC";
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }
    
    function getImages()
    {
        
        global  $db;
        $query = "SELECT * FROM `images`";
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array ();
        
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
       
return array($nrows, $returnArray);
    }
    
function getCategories()
    {
        global  $db;
        $query =  "SELECT * FROM `categories`";
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array ();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
       }
       
   return array($nrows, $returnArray); 
        
    }


        function getUserById($user_id)
    {
             global $db;
        $query = "SELECT `USER_NAME`,`NAME` ,`SURNAME`, `EMAIL`, `PHONE_NUMBER`,`ADDRESS` ,`AGE`, `PASSWORD` FROM `USERS` WHERE `USER_ID` ='" . $user_id. "';";
        $result= mysqli_query($db,$query);
        

     $returnArray = array ();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
       
return $returnArray;
    }
 
    function checkCity($city_name)
    {
        global $db;
        $query = 'SELECT * FROM CITIES WHERE `NAME` =  \'' .  $city_name . "'";
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);

        if($nrows == 1)
            return True;
        else
            return False;
    }

    function checkDistrict($district_name, $city_id)
    {
        global $db;
        $query = 'SELECT * FROM DISTRICTS D WHERE D.`NAME` =  \'' .  $district_name . '\' AND D.`CITY_ID` = \'' . $city_id . "'";
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);

        if($nrows == 1)
            return True;
        else
            return False;
    }



    function checkCategory($name, $parent_id)
    {
        global $db;
        
        if($parent_id == "NULL")
            $query = 'SELECT * FROM CATEGORIES WHERE `NAME` =  \'' .  $name . '\' AND `PARENT_CAT_ID` IS NULL';
        else
            $query = 'SELECT * FROM CATEGORIES WHERE `NAME` =  \'' .  $name . '\' AND `PARENT_CAT_ID` = \'' . $parent_id . "'";

        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);

        if($nrows == 1)
            return True;
        else
            return False;
    }

    function checkCargoCompany($cargo_company_name)
    {
        global $db;
        
        $query = 'SELECT * FROM CARGO_COMPANIES WHERE `NAME` =  \'' .  $cargo_company_name . "'";
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);

        if($nrows == 1)
            return True;
        else
            return False;
    }

    function checkPrice($announcement_id, $price)
    {
        global $db;
        $query = 'SELECT * FROM OFFERS WHERE `ANNOUNCEMENT_ID` =  ' .  $announcement_id . ' AND ' . $price . '< `HIGHEST_PRICE` ';
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);

        if($nrows >= 1)
            return False;
        else
            return True;
    }

    function checkUserBLock($user_id)
    {
        global $db;
        $query = 'SELECT * FROM MEMBERS WHERE USER_ID =  ' . $user_id . ' AND MEMBER_STATUS = \'Blocked\'';
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);

        if($nrows >= 1)
            return True;
        else
            return False;
    }



    function getComplaints()
    {
        global $db;
        $query = 'SELECT C.COMPLAINT_ID, U.`USER_NAME`, C.`SUBJECT`, C.`DETAILS` AS `TEXT` FROM COMPLAINTS C, USERS U WHERE C.USER_ID = U.USER_ID';
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        
        $returnArray = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }

        return array($nrows, $returnArray);
    }

    function getInboxMessages()
    {
        global $db;
        $query = 'SELECT U.`USER_ID`, M.`MESSAGE_ID`, U.`USER_NAME`, M.`SUBJECT`, M.`TEXT` FROM MESSAGES M, USERS  U WHERE M.`FROM_USER` = U.`USER_ID` AND M.`TO_USER` = ' . $_SESSION["user_id"];
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        
        return array($nrows, $returnArray);
    }

    function getOutboxMessages()
    {
        global $db;
        $query = 'SELECT U.`USER_ID`, M.`MESSAGE_ID`, U.`USER_NAME`, M.`SUBJECT`, M.`TEXT` FROM MESSAGES M, USERS  U WHERE M.`TO_USER` = U.`USER_ID` AND M.`FROM_USER` = ' . $_SESSION["user_id"];
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        
        $returnArray = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }

        return array($nrows, $returnArray);
    }

    function getCities()
    {
        global $db;
        $query = 'SELECT * FROM CITIES';
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        
        $returnArray = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }

        return array($nrows, $returnArray);
    }

    function getDistricts($city_id)
    {
        global $db;
        $query = 'SELECT D.`DISTRICT_ID`, C.`NAME`, D.`NAME` FROM CITIES C, DISTRICTS D WHERE C.`CITY_ID` = D.`CITY_ID` AND C.`CITY_ID` = ' . $city_id;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        
        $returnArray = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        
        return array($nrows, $returnArray);
    }

    function getSubCategories($parent_category_id)
    {
        global $db;
        if($parent_category_id == 'NULL')
            $query = 'SELECT `CATEGORY_ID`, `NAME` FROM CATEGORIES WHERE `PARENT_CAT_ID` IS NULL';
        else
            $query = 'SELECT `CATEGORY_ID`, `NAME` FROM CATEGORIES WHERE `PARENT_CAT_ID` = ' . $parent_category_id;

        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        
        $returnArray = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }

        return array($nrows, $returnArray);
    }

    function getPreviousParentCategoryId($parent_id)
    {
        global $db;
        $query = 'SELECT `PARENT_CAT_ID` FROM CATEGORIES WHERE `CATEGORY_ID` = ' . $parent_id;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $temp = array($nrows, $returnArray);

        return $temp[1][0][0];
    }

    function getSubAdmins()
    {
        $sub_admins = getTypeUsers("SUBADMINS");
        for($i = 0; $i < count($sub_admins[0]); $i++) {
            $sub_admins[1][$i][4]= "Admin";
            $sub_admins[1][$i][5] = "Sub Admin";
        }

        return $sub_admins;
    }

    function getLeadAdmins()
    {
        $lead_admins = getTypeUsers("LEADADMINS");
        
        for($i = 0; $i < count($lead_admins[1]); $i++) {
            $lead_admins[1][$i][4] = "Admin";
            $lead_admins[1][$i][5] = "LeadAdmin";
        }

        return $lead_admins;
    }

  function getPrimaryMembers()
    {
        $members = getTypeUsers("MEMBERS");
        print_r( $members[0]);
       

        return $members;
    }


    function getMembers($user_status, $lower_age, $upper_age)
    {
        $query = 'SELECT `USER_ID`, `USER_NAME`, `NAME`, `SURNAME`, `MEMBER_STATUS` 
                      FROM USERS NATURAL JOIN MEMBERS NATURAL JOIN MEMBERS 
                      WHERE AGE >= ' . $lower_age . ' AND AGE <= ' . $upper_age;

        if($user_status != "")
        {
            $query .= ' AND MEMBER_STATUS = \'' . $user_status . '\'';
        }

        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        
        $members = array($nrows, $returnArray);

        for($i = 0; $i < members[0]; $i++)
        {
            $members[1][$i][5] = "Member";
        }


        $users = array();
        $keys = array(`USER_ID`, `USER_NAME`, `NAME`, `SURNAME`, `MEMBER_STATUS`, `USER_TYPE`);
        $keys_count = count($keys);

        for($i = 0; $i < $keys_count; $i++)
        {
            $counter = 0;

            for($j = 0; $j < $members[0]; $j++)
            {
                $users[1][$counter][$i] = $members[1][$j][$i];
                $counter++;
            }
        }

        $users[0] = $counter;

        return $users;
    }

    function getAdmins($lower_age, $upper_age)
    {
        global $db;
        $query = 'SELECT "USER_ID", "USER_NAME", "NAME", "SURNAME",
                      FROM USERS NATURAL JOIN LEADADMINS 
                      WHERE AGE >= ' . $lower_age . ' AND AGE <= ' . $upper_age;

        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        
        $_lead_admins = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $_lead_admins[] = $row;
          
        }
        
        $lead_admins = array($nrows, $_lead_admins);
        
        for($i = 0; $i < $lead_admins[0]; $i++)
        {
            $lead_admins[1][$i][4] = "Admin";
            $lead_admins[1][$i][5] = "Senior Admin";
        }

        $query = 'SELECT "USER_ID", "USER_NAME", "NAME", "SURNAME"
                      FROM SUB_ADMIN_DETAILS
                      WHERE AGE >= ' . $lower_age . ' AND AGE <= ' . $upper_age;


        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        
        $_sub_admins = Array();
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $_sub_admins[] = $row;
          
        }

        $sub_admins = array($nrows, $_sub_admins);
        
        for($i = 0; $i < $sub_admins[0]; $i++)
        {
            $sub_admins[1][$i][4] = "Admin";
            $sub_admins[1][$i][$i] = "Sub Admin";
        }
        
        $users = array();
        $keys = array("USER_ID", "USER_NAME", "NAME", "SURNAME", "MEMBER_STATUS", "USER_TYPE");
        $keys_count = count($keys);
       
        for($i = 1; $i < $keys_count; $i++)
        {
            $counter = 0;
            
            for($j = 0; $j < $lead_admins[0]; $j++)
            {
                $users[1][$counter][$i] = $lead_admins[1][$j][$i]; //switched
                $counter++;
            }

            for($j = 0; $j < $sub_admins[0]; $j++)
            {
                $users[1][$counter][$i] = $sub_admins[1][$j][$i];
                $counter++;
            }
        }

        $users[0] = $counter;

       
        return array(count($keys),$users);
    }

    function getUserMaxAge()
    {
        $query = 'SELECT MAX(AGE) as MAX_AGE FROM USERS';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $temp = array($nrows, $returnArray);

        return $temp[1][0][0];
    }

    function getUserName($user_id)
    {
        $query = 'SELECT USER_NAME FROM USERS WHERE USER_ID =  ' .  $user_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $temp = array($nrows, $returnArray);
        //print_r($temp);
        return $temp[1][0][0];
    }

    function getCityName($city_id)
    {
        $query = 'SELECT NAME FROM CITIES WHERE CITY_ID =  ' .  $city_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $temp = array($nrows, $returnArray);
        
        return $temp[1][0][0];
    }

    function getMaxSaleRecordPrice()
    {
        $query = 'SELECT MAX(PRICE) as MAX_PRICE FROM SALE_RECORDS NATURAL JOIN ANNOUNCEMENTS';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $temp = array($nrows, $returnArray);

        return $temp[1][0][0];
    }

    function getUserByFilterParameters($table_name, $user_status, $lower_age, $upper_age)
    {
        $query = 'SELECT USER_ID, USER_NAME, NAME, SURNAME';

        if($table_name == "MEMBERS")
        {
            $query .= ', MEMBER_STATUS ';
        }

        $query .= ' FROM USERS NATURAL JOIN ' . $table_name;

        if($table_name == "MEMBERS")
        {
            $query .= ' NATURAL JOIN MEMBERS ';
        }

        $query .= ' WHERE';

        if($table_name == "MEMBERS")
        {
            if($user_status != "") {
                $query .= ' MEMBER_STATUS = ' . '\'' . $user_status . '\'' . ' AND ';
            }
        }

        $query .= ' AGE >= ' . $lower_age . ' AND AGE <= ' . $upper_age;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }

        return array($nrows, $returnArray);
    }

    function getUsersByFilter($user_type, $user_status, $lower_age, $upper_age)
    {
        $users = array();

        if($lower_age == "")
        {
            $lower_age = 0;
        }

        if($upper_age == "")
        {
            $upper_age = getUserMaxAge();
        }

        switch ($user_type)
        {
            case "LeadAdmin":
                if($user_status != "Admin" && $user_status != "") {
                    $upper_age = 0;
                }

                $users = getUserByFilterParameters("LEADADMINS", $user_status, $lower_age, $upper_age);

                for($i = 0; $i < $users[0]; $i++)
                {
                    $users[1][$i][4] = "Admin";
                    $users[1][$i][5] = $user_type;
                }

                break;
            case "SubAdmin":
                if($user_status != "Admin" && $user_status != "")
                {
                    $upper_age = 0;
                }

                $users = getUserByFilterParameters("SUBADMINS", $user_status, $lower_age, $upper_age);

                for($i = 0; $i < $users[0]; $i++)
                {
                    $users[1][$i][4] = "Admin";
                    $users[1][$i][5] = $user_type;
                }

                break;
            case "Member":
                if($user_status == "Admin")
                {
                    $upper_age = 0;
                }

                $users = getUserByFilterParameters("MEMBERS", $user_status, $lower_age, $upper_age);

                for($i = 0; $i < $users[0]; $i++)
                {
                    $users[1][$i][4] = "Member";
                }

                break;
         
            default:
                if($user_status == "Admin")
                {
                    $users = getAdmins($lower_age, $upper_age)[1];
                    $keys_count = getAdmins($lower_age, $upper_age)[0];
                }
                elseif($user_status == "Active" || $user_status == "Passive" || $user_status == "Blocked")
                {
                    $users = getMembers($user_status, $lower_age, $upper_age);
                }
                else
                {
                    $admins = getAdmins($lower_age, $upper_age)[1];
                    $members = getMembers($user_status, $lower_age, $upper_age);

                    //$keys = array_keys($admins[1]);
                    $keys_count = getAdmins($lower_age, $upper_age)[0];

                    for($i = 0; $i < $keys_count; $i++) {
                        $counter = 0;

                        for($j = 0; $j < count($admins[1]); $j++)
                        {
                            $users[1][$counter][$i] = $admins[1][$j][$i];
                            $counter++;
                        }

                        for($j = 0; $j < $members[0]; $j++)
                        {
                            $users[1][$counter][$i] = $members[1][$j][$i];
                            $counter++;
                        }
                    }

                    $users[0] = $counter;
                    //$users[2] = $counter;
                }
        }

        return $users;
    }

    function getSaleRecordsByFilter($seller_name, $buyer_name, $lower_price, $upper_price)
    {
        $sale_records = array();

        if($lower_price == "")
        {
            $lower_price = 0;
        }

        if($upper_price == "")
        {
            $upper_price = getMaxSaleRecordPrice();
        }

        $query = 'SELECT RECORD_ID, ANNOUNCEMENT_ID, SELLER_ID, BUYER_ID, TITLE, PRICE, SELLER, BUYER
                      FROM DETAILS_SALE_RECORD
                      WHERE PRICE >= ' . $lower_price . ' AND PRICE <= ' . $upper_price;

        if($seller_name != "")
            $query .= ' AND US.`USER_NAME` = \'' . $seller_name . '\'';

        if($buyer_name != "")
            $query .= ' AND UB.`USER_NAME` = \'' . $buyer_name . '\'';

        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getTypeUsers($table_name)
    {
        if ($table_name == "MEMBERS") {
        $query = 'SELECT USER_ID, USER_NAME, `NAME`, SURNAME, MEMBER_STATUS FROM USERS NATURAL JOIN MEMBERS';
        
    } else { //is admin
        $query = 'SELECT USER_ID, USER_NAME, `NAME`, SURNAME FROM USERS NATURAL JOIN ' . $table_name;
        
    }
    $fields = array ("USER_ID", "USER_NAME", "NAME", "SURNAME", "MEMBER_TYPE", "MEMBER_STATUS");
    
    global $db;
        $result= mysqli_query($db,$query);
        
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($fields, $returnArray);
    }

    function getSellers()
    {
        $query = 'SELECT DISTINCT U.USER_NAME FROM USERS U NATURAL JOIN SALE_RECORDS S WHERE U.USER_ID = S.SELLER_ID ORDER BY U.USER_NAME ASC';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getBuyers()
    {
        $query = 'SELECT DISTINCT U.USER_NAME FROM USERS U NATURAL JOIN SALE_RECORDS S WHERE U.USER_ID = S.BUYER_ID ORDER BY USER_NAME ASC';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getCargoCompanies()
    {
        $query = 'SELECT * FROM CARGO_COMPANIES';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getAnnouncementsOfUser($user_id)
    {
        $query = 'SELECT ANNOUNCEMENT_ID, CITY_ID, DISTRICT_ID, TITLE, PRICE FROM ANNOUNCEMENTS WHERE USER_ID = ' . $user_id;
        global $db; 
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        
        return array($nrows, $returnArray);
    }

    function getComplaintAndUser($compaint_id)
    {
        $query = 'SELECT `USER_ID`, `USER_NAME`, `NAME`, `SURNAME`, `COMPLAINT_ID`, `SUBJECT` FROM USER_AND_COMPLAINT WHERE COMPLAINT_ID = ' . $compaint_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        
        return array($nrows, $returnArray);
    }

    function getMessageAndUser($message_id)
    {
        $query = 'SELECT M.`TO_USER`, M.`SUBJECT`, M.`TEXT` FROM MESSAGES M, USERS U WHERE M.`FROM_USER` = U.`USER_ID` AND MESSAGE_ID =' . $message_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }



    function getProductById($product_id) {
        $query = 'SELECT * FROM PRODUCTS WHERE PRODUCT_ID =' . $product_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getCityById($city_id)
    {
        $query = 'SELECT * FROM CITIES WHERE CITY_ID =' . $city_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getFavouriteProductsById($user_id)
    {
        $query = 'SELECT A.PRODUCT_ID, A.TITLE, A.PRICE FROM WISHLISTS F, ANNOUNCEMENTS A WHERE A.PRODUCT_ID = F.PRODUCT_ID AND F.USER_ID =' . $user_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        
        return array($nrows, $returnArray);
    }

    function getDistrictById($district_id) {
        $query = 'SELECT * FROM DISTRICTS WHERE DISTRICT_ID =' . $district_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getImageUrl($product_id) {
        $query = 'SELECT URL FROM IMAGES WHERE PRODUCT_ID =' . $product_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
      
        return array($nrows, $returnArray);
       
    }

    function getCargoCompanyName($cargo_company_id)
    {
        $query = 'SELECT "NAME" FROM CARGO_COMPANIES WHERE COMPANY_ID =' . $cargo_company_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $elements = array($nrows, $returnArray);

        return $elements[1]["NAME"][0];
    }

    function getDistrictName($district_id)
    {
        $query = 'SELECT NAME FROM DISTRICTS WHERE DISTRICT_ID =' . $district_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $elements = array($nrows, $returnArray);
       
        return $elements[1][0][0];
    }

    function getCategoryName($category_id)
    {
        if ($category_id == "NULL")
            return "#";

        $query = 'SELECT "NAME" FROM CATEGORIES WHERE CATEGORY_ID =' . $category_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        $elements = array($nrows, $returnArray);

        return $elements[1][0][0];
    }



  function getMember($user_id)
    {
        $query = 'SELECT ANNOUNCEMENT_PERMISSION, MEMBER_STATUS FROM MEMBERS WHERE USER_ID =' . $user_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getLead_Admins($user_id)
    {
        $query = 'SELECT "CATEGORY_COUNT" FROM leadadmins WHERE USER_ID =' . $user_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getAdmin($user_id)
    {
        $query = 'SELECT "CATEGORY_PERMISSION" FROM ADMINS WHERE USER_ID =' . $user_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getCargoCompany($cargo_company_id)
    {
        $query = 'SELECT * FROM CARGO_COMPANIES WHERE COMPANY_ID =' . $cargo_company_id;
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

   function getCargoRecord($sale_record)
    {
            $query = 'SELECT CC.`NAME` AS `NAME`, CC.`ADDRESS`, CC.`PHONE_NUMBER`, DATE_FORMAT(CR.`DATE`, \'%d-%m-%Y %H.%i.%s\') AS `DATE` FROM CARGO_RECORDS CR, CARGO_COMPANIES CC, SALE_RECORDS S WHERE S.RECORD_ID = CR.SALE_RECORD_ID AND CC.COMPANY_ID = CR.COMPANY_ID AND S.RECORD_ID = ' . $sale_record;

    
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        
        return array($nrows, $returnArray);
    }

    function getPassiveUsers()
    {
        $query = 'SELECT U.`USER_ID`, U.`USER_NAME`, U.`NAME`, U.`SURNAME`, U.`EMAIL` FROM USERS U, MEMBERS M WHERE U.`USER_ID` = M.`USER_ID` AND M.`MEMBER_STATUS` = \'Passive\'';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getSaleRecords()
    {
        $query = 'SELECT * FROM DETAILS_SALE_RECORD';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getProcessingHistory()
    { 
        $query = 'SELECT PROCESSING_HISTORY_ID, USER_ID, ACTIVITY, DATE_FORMAT(`DATE`, \'%d-%m-%Y %H.%i.%s\') AS `DATE` FROM PROCESSING_HISTORIES ORDER BY PROCESSING_HISTORY_ID DESC';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getAnnouncementProductId($user_id) {
        $query = 'SELECT * FROM PRODUCTS WHERE "USER_ID" = ' . $user_id . ' ORDER BY "PRODUCT_ID" DESC';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

   

    

    function getDetailsOfAnnouncements($status, $category_id, $lower_price, $upper_price, $city_id, $district_id)
    {
        $query = "SELECT U.USER_NAME, A.TITLE, A.HIGHEST_PRICE, TO_CHAR(A.START_DATE, 'dd/mm/yyyy HH24:MI:SS') AS \"START_DATE\", TO_CHAR(A.END_DATE, 'dd/mm/yyyy HH24:MI:SS') AS \"END_DATE\" FROM PRODUCTS P, USERS U, ANNOUNCEMENTS A";
        $query .= " WHERE U.USER_ID = A.USER_ID AND P.PRODUCT_ID = A.PRODUCT_ID AND A.STATUS = '" . $status . "'";

        if($category_id != 0)
            $query .= " AND P.CATEGORY_ID = " . $category_id;

        if($lower_price != 0)
            $query .= " AND A.HIGHEST_PRICE >= " . $lower_price;

        if($upper_price != 0)
            $query .= " AND A.HIGHEST_PRICE <= " . $upper_price;

        if($city_id != 0)
            $query .= " AND A.CITY_ID = " . $city_id;

        if($district_id != 0)
            $query .= " AND A.DISTRICT_ID = " . $district_id;

        $query .= " ORDER BY A.PRODUCT_ID ASC";
        $stid = oci_parse($GLOBALS["connection"], $query);
        oci_execute($stid);
        $nrows = oci_fetch_all($stid, $res);

        return array($nrows, $res);
    }

    function getAnnouncementById($id) {
        $query = 'SELECT * FROM ANNOUNCEMENTS WHERE ANNOUNCEMENT_ID =' . $id;      
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

   function getStatistic1()
    {
        $query = 'SELECT * FROM ANNOUNCEMENTS WHERE PRICE = (SELECT MAX(PRICE) FROM ANNOUNCEMENTS)';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

   function getStatistic2()
    {
        $query = 'SELECT COUNT(DISTINCT A.ANNOUNCEMENT_ID)/COUNT(DISTINCT P.USER_ID) AS AVERAGE_ANNOUNCEMENT FROM ANNOUNCEMENTS A, MEMBERS P';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

  function getStatistic3()
    {
        $query = "SELECT AVG(A.PRICE) AS AVERAGE_PRICE FROM ANNOUNCEMENTS A, CITIES C WHERE A.CITY_ID = C.CITY_ID AND C.NAME = 'ANKARA'";
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getStatistic4()
    {
        $query = 'SELECT COUNT(*) AS COUNT_PRODUCT FROM SALE_RECORDS S WHERE S.PRODUCT_ID NOT IN (
                        SELECT F.PRODUCT_ID FROM WISHLISTS F WHERE F.USER_ID = S.BUYER_ID)';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getStatistic5()
    {
        $query = 'SELECT COUNT(*) AS COUNT_PRODUCT FROM PRODUCTS P WHERE P.PRODUCT_ID IN (
                        SELECT S.PRODUCT_ID FROM SALE_RECORDS S WHERE S.BUYER_ID IN(
                          SELECT TO_USER FROM MESSAGES WHERE FROM_USER = S.SELLER_ID)
                        AND S.BUYER_ID IN (
                          SELECT FROM_USER FROM MESSAGES WHERE TO_USER = S.SELLER_ID))';
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getStatistic6()
    {
        $query = "SELECT AVG(U.AGE) AS AVERAGE_AGE FROM USERS U WHERE U.USER_ID IN (
                        SELECT DISTINCT O.USER_ID FROM OFFERS O WHERE O.ANNOUNCEMENT_ID IN (
                          SELECT A.ANNOUNCEMENT_ID FROM ANNOUNCEMENTS A, PRODUCTS P WHERE A.PRODUCT_ID = P.PRODUCT_ID AND P.CATEGORY_ID IN (
                            SELECT C.CATEGORY_ID FROM CATEGORIES C WHERE C.NAME = 'FOOTBALL' OR C.NAME = 'TENNIS')))";
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getStatistic7()
    {
        
        $query = "SELECT * FROM ANNOUNCEMENTS WHERE START_DATE >= DATE_FORMAT('01/12/2017', \'%d/%m/%Y') AND START_DATE <= DATE_FORMAT('31/12/2017', \'%d/%m/%Y') AND CITY_ID IN(
                        SELECT C.CITY_ID FROM CITIES C WHERE C.`NAME` = 'ANTALYA')
                      AND START_PRICE IN (
                        SELECT MIN(A.START_PRICE) FROM ANNOUNCEMENTS A WHERE A.`START_DATE` >= DATE_FORMAT('01/12/2017', \'%d/%m/%Y') AND A.`START_DATE` <=  DATE_FORMAT('31/12/2017', \'%d/%m/%Y') AND A.`CITY_ID` IN(
                          SELECT C.`CITY_ID` FROM CITIES C WHERE C.`NAME` = 'ANTALYA'))";
       global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
       
        return array($nrows, $returnArray);
    }

    function getStatistic8()
    {
        $query = "SELECT AVG(PRICE) AS AVERAGE_PRICE FROM OFFERS O WHERE O.ANNOUNCEMENT_ID IN (
                        SELECT A.ANNOUNCEMENT_ID FROM ANNOUNCEMENTS A, PRODUCTS P WHERE A.PRODUCT_ID = P.PRODUCT_ID AND P.MARK = 'Sony')
                      GROUP BY O.ANNOUNCEMENT_ID HAVING COUNT(*) >=ALL (
                        SELECT COUNT(*) FROM OFFERS O GROUP BY O.ANNOUNCEMENT_ID)";
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getStatistic9()
    {
        $query = "SELECT DISTINCT UC.USER_ID, UC.USER_NAME, UC.AGE FROM USER_AND_COMPLAINT UC, USER_AND_COMPLAINT UC2 WHERE UC.COMPLAINT_ID <> UC2.COMPLAINT_ID AND UC.USER_ID = UC2.USER_ID AND UC.AGE IN (
                              SELECT MIN(UC3.AGE) FROM USER_AND_COMPLAINT UC3, USER_AND_COMPLAINT UC4 WHERE UC3.COMPLAINT_ID <> UC4.COMPLAINT_ID AND UC3.USER_ID = UC4.USER_ID)";
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }

    function getStatistic10()
    {
        $query = "SELECT A.* FROM ANNOUNCEMENTS A, PRODUCTS P WHERE A.PRODUCT_ID = P.PRODUCT_ID AND P.CATEGORY_ID IN (
                        SELECT C1.CATEGORY_ID FROM CATEGORIES C1 WHERE C1.`NAME` = 'SMART PHONES')
                      AND A.CITY_ID IN (
                        SELECT C2.CITY_ID FROM CITIES C2 WHERE C2.`NAME` = 'IZMIR')
                      AND A.START_DATE IN (
                        SELECT MAX(A2.START_DATE) FROM ANNOUNCEMENTS A2, PRODUCTS P2 WHERE A2.`PRODUCT_ID` = P2.PRODUCT_ID AND P2.CATEGORY_ID IN (
                          SELECT C3.`CATEGORY_ID` FROM CATEGORIES C3 WHERE C3.`NAME` = 'SMART PHONES')
                        AND A2.`CITY_ID` IN (
                          SELECT C4.CITY_ID FROM CITIES C4 WHERE C4.NAME = 'IZMIR'))";
        global $db;
        $result= mysqli_query($db,$query);
        $nrows = mysqli_num_rows($result);
        $returnArray = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $returnArray[] = $row;
          
        }
        return array($nrows, $returnArray);
    }


    // add functions --------------------------------------------------------------------
   
   function addMember($post)
    {
          global  $db;

        $query="CALL insertMember('".$post['name']."', '".$post['surname']."','".$post['email']."','".$post['password']."','".$post['phone_number']."','".$post['address']."','".$post['user_name']."','".$post['age']."')";                 
         
        mysqli_query($db,$query);
         $message = $post['name'];
            echo "<script type='text/javascript'>alert('$message')";
    }
       

    
function addCity($name)
    {
        global  $db;
       $query="CALL insertCITY('".$name."')";                 
    
        mysqli_query($db,$query);
    }

    function addCargoCompany($post)
    {
        
        global  $db;
        
        $query="CALL insertCARGOCOMPANY('".$post['name']."','".$post['address']."','".$post['phone_number']."')";                 
        mysqli_query($db,$query);
    }

    function addDistrict($district_name, $city_id)
    {
       
        global  $db;
        $query="CALL insertDISTRICT('".$city_id."','".$district_name."')";                 
        mysqli_query($db,$query);
    }

    function addCategory($parent_id, $name)
    {
        if ($parent_id == "NULL")
            $parent_id = NULL;
      
              global  $db;

         $query2="CALL insertCATEGORY('".$parent_id."','".$name."')";                 
         
                   
         
        mysqli_query($db,$query2);
         
           
       $user_id=$_SESSION["user_id"];
        $query="CALL increaseCATEGORYCOUNT('".$user_id."')";     
       

    mysqli_query($db,$query);
           
    }

    function addComplaint($post)
    {
        
        global  $db;
        $query="CALL insertCOMPLAINT('".$_SESSION["user_id"]."','".$post['subject']."','".$post['text']."')";                 
        mysqli_query($db,$query);
     
    }
    function addMessage($post)
    {
        global  $db;
        $query="CALL INSERTMESSAGE('".$post["subject"]."','".$post['text']."','".$post['to_user']."','".$post['from_user']."')";                 
        mysqli_query($db,$query);
    }

    function addFavouriteProduct($product_id, $user_id)
    {
    
         global $db;
        $query="CALL INSERTWISHLIST('".$product_id."','".$user_id."')";                 
        mysqli_query($db,$query);
    }

    function dropFavouriteProduct($product_id, $user_id)
    {
      
         global $db;
        $query="CALL deleteWISHLIST('".$product_id."','".$user_id."')";                 
        mysqli_query($db,$query);
               
    }



  // update functions --------------------------------------------------------------------
    function updateCity($city_id, $city_name)
    {
        
        global  $db;
        $query="CALL updateCITY('".$city_id."','".$city_name."')";                 
        mysqli_query($db,$query);
        
    }

    function updateCargoCompany($post)
    {
        
             global  $db;
        $query="CALL updateCARGOCOMPANY('".$post["cargo_company_id"]."','".$post["name"]."','".$post["address"]."','".$post["phone_number"]."')";                 
        mysqli_query($db,$query);
         
     
    }

    function updateDistrict($district_id, $city_id, $district_name)
    {
               
        global  $db;
        $query="CALL updateDISTRICT('".$district_id."','".$city_id."','".$district_name."')";                 
        mysqli_query($db,$query);
         
    }

    function updateCategory($category_id, $parent_id, $category_name)
    {
        if($parent_id == "NULL")
            $parent_id = NULL;
        
        global  $db;
        $query="CALL updateCATEGORY('".$category_id."','".$parent_id."','".$category_name."')";                 
        mysqli_query($db,$query);
     
    }

    function updateProfile($post,$user_name)
    {
        $user_id = $_SESSION["user_id"];
      
        $post['password'] = md5($post['password']);

        if ($_SESSION["user_type"] == "member")
        {
            $member = getMember($user_id)[1];
           // $primary_member = getPrimaryMember($user_id)[1];
          
            global  $db;
            $query="CALL updateMEMBER('".$user_id."','".$post['name']."','".$post['surname']."','".$post['email']."','".$post['password']."','".$post['phone_number']."','".$post['address']."','".$user_name."','".$member[0][1]."','".$member[0][0]."')";                 

           mysqli_query($db,$query);
           // oci_bind_by_name($stid,':ANNOUNCEMENT_COUNT', $primary_member["ANNOUNCEMENT_COUNT"][0]);
           
        }
      
        elseif ($_SESSION["user_type"] == "lead_admin")
        {
            
            $admin = getAdmin($user_id)[1];
            $lead_admin = getLead_Admins($user_id)[1];
            
            
            global  $db;
        $query="CALL updateLEADADMIN('".$user_id."','".$post['name']."','".$post['surname']."','".$post['email']."','".$post['password']."','".$post['phone_number']."','".$post['address']."','".$user_name."','".$admin[0][0]."','".$lead_admin[0][0]."')";                 
        mysqli_query($db,$query);
           
            
        }
        elseif ($_SESSION["user_type"] == "sub_admin")
        {
            $admin = getAdmin($user_id)[1];
            print_r($admin);
            global  $db;
            $query="CALL updateSUBADMIN('".$user_id."','".$post['name']."','".$post['surname']."','".$post['email']."','".$post['password']."','".$post['phone_number']."','".$post['address']."','".$user_name."','".$admin[0][0].")";                 

           mysqli_query($db,$query);
         
        }
    }

    

    function blockUser($user_id)
    {
        $query = 'BEGIN UPDATE MEMBERS SET "STATUS" = \'Blocked\' WHERE "USER_ID" = ' . $user_id . ';COMMIT;END;';
        global $db;
        $result= mysqli_query($db,$query);
    }

    function unblockUser($user_id)
    {
        $query = 'BEGIN UPDATE MEMBERS SET "STATUS" = \'Active\' WHERE "USER_ID" = ' . $user_id . ';COMMIT;END;';
        global $db;
        $result= mysqli_query($db,$query);
    }

   
?>