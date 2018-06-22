<?php if(!session_id() && !isset($_SESSION["user_id"])) session_start();?>


<html>
<head>
    <script src="javascripts/jquery-latest.min.js" type="text/javascript"></script>
    <script src="javascripts/drop_down_menu.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div id="main_body">
        <div id="menu_bar"></div>
        <div id="filter_menu"></div>
        <div id="content"></div>
    </div>
</body>
</html>

<script>
    function getDistrictContent(val) {
        $.ajax({
            type: "POST",
            url: "ajax_functions.php?type=getDistrictContent",
            data:'city_id='+val,
            success: function(data){
                $("#district_list").html(data);
            }
        });
    }

    function getDistrictFilter(val) {
        $.ajax({
            type: "POST",
            url: "ajax_functions.php?type=getDistrictFilter",
            data:'city_id='+val,
            success: function(data){
                $("#district_filter").html(data);
            }
        });
    }
    
    function getFavoriteContent(val) {
        var task = document.getElementById("announcement_" + val).value;

        if(task === '0') {
            $.ajax({
                type: "POST",
                url: "ajax_functions.php?type=getAddFavoriteContent",
                data:'id='+val,
                success: function(data){
                    document.getElementById("announcement_" + val).value = '1';
                    document.getElementById("announcement_" + val).innerHTML = data;
                }
            });
        }
        else if(task === '1') {
            $.ajax({
                type: "POST",
                url: "ajax_functions.php?type=getDropFavoriteContent",
                data:'id='+val,
                success: function(data){
                    document.getElementById("announcement_" + val).value = '0';
                    document.getElementById("announcement_" + val).innerHTML = data;
                }
            });
        }
    }

    function getBlockContent(val) {
        var isBlock = document.getElementById("block_" + val).value;

        if(isBlock == 0) {
            $.ajax({
                type: "POST",
                url: "ajax_functions.php?type=getBlockContent",
                data:'user_id='+val,
                success: function(data){
                    document.getElementById("block_" + val).value = '1';
                    document.getElementById("block_" + val).innerHTML = data;
                }
            });
        }
        else if(isBlock == 1) {
            $.ajax({
                type: "POST",
                url: "ajax_functions.php?type=getUnblockContent",
                data:'user_id='+val,
                success: function(data){
                    document.getElementById("block_" + val).value = '0';
                    document.getElementById("block_" + val).innerHTML = data;
                }
            });
        }
    }
</script>

<?php
    function appendMenuBar($is_index)
    {
        $menu_bar_content = "";

        if(!isset($_SESSION['user_type']))
        {
            $menu_bar_content = $menu_bar_content . "<ul><li><a id='home_a' href='index.php'>Home</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right;'><a href='register.php'>Register</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right;'><a href='login.php'>Login</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='login.php'>Post Announcement</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='login.php'>Post Complaint</a></li></ul>";
        }
        elseif ($_SESSION["user_type"] == "member")
        {
            $menu_bar_content = $menu_bar_content . "<ul><li><a id='home_a' href='index.php'>Home</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='index.php?logout=true'>Logout</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='profile.php'>Profile</a></li>";
            $status = getMemberStatus($_SESSION["user_id"]);

            if($status[0] == "Active")
                $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='post_announcement.php'>Post Announcement</a></li>";

            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='post_complaint.php'>Post Complaint</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='favourite_products.php'>Favourite Products</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='outbox.php'>Outbox</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='inbox.php'>Inbox</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='my_announcements.php'>My Announcements</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='processing_history.php'>Processing History</a></li></ul>";
        }
        
        elseif ($_SESSION["user_type"] == "lead_admin")
        {
            $menu_bar_content = $menu_bar_content . "<ul><li style='float: left'><a id='home_a' href='index.php'>Home</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='categories.php?parent_id=NULL'>Categories</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='users.php'>Users</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='cities.php'>Cities</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='cargo_companies.php'>Cargo Companies</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='sale_records.php'>Sale Records</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='complaints.php'>Complaint Box</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='statistics.php'>Statistics</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='index.php?logout=true'>Logout</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='profile.php'>Profile</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='outbox.php'>Outbox</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='inbox.php'>Inbox</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='processing_history.php'>Processing History</a></li></ul>";
        }
        elseif ($_SESSION["user_type"] == "sub_admin")
        {
            $menu_bar_content = $menu_bar_content . "<ul><li style='float: left'><a id='home_a' href='index.php'>Home</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='users.php'>Users</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='cities.php'>Cities</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='cargo_companies.php'>Cargo Companies</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='sale_records.php'>Sale Records</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='complaints.php'>Complaint Box</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: left'><a href='statistics.php'>Statistics</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='index.php?logout=true'>Logout</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='profile.php'>Profile</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='outbox.php'>Outbox</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='inbox.php'>Inbox</a></li>";
            $menu_bar_content = $menu_bar_content . "<li style='float: right'><a href='processing_history.php'>Processing History</a></li></ul>";
        }

        if(!$is_index)
        {
            echo '<script type="text/javascript">           
                document.getElementById("menu_bar").innerHTML = "' . $menu_bar_content . '";
                document.getElementById("content").style.width = "100%";
                document.getElementById("filter_menu").style.width = "0px";
                document.getElementById("filter_menu").style.padding = "0px";
              </script>';
        }
        else
        {
            echo '<script type="text/javascript">           
                document.getElementById("menu_bar").innerHTML = "' . $menu_bar_content . '";
              </script>';
        }
    }

    function appendCategoryFilter(&$content)
    {
        $content .= "<div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>CATEGORIES</div>";
        $category = getCategories();
        
        $nrows = $category[0]; //number of rows
        
        $res = $category[1]; //result
                 

        if ($nrows == 0)
            return;

        $content = $content . "<ul>";
        
        $param = -1; //parent == null
        $parent_row_ids = checkparent($param, $res)[0];
        $parents = checkparent($param, $res)[1];
        
        for($i = 0; $i < count($parents); $i++)
        
        {
            
            $is_last_level = checkLastLevel($res[$parent_row_ids[$i]][0], $res);     
            if ($is_last_level == 0 and $res[$parent_row_ids[$i]][1] == NULL) {
                $content = $content . "<li class='active has-sub'><a href='#'><span>" . $res[$parent_row_ids[$i]][2] . "</span></a>";
                addSubCategories($content, $res, $res[$parent_row_ids[$i]][0]);
            }
            elseif ($is_last_level == 1 and $res[$parent_row_ids[$i]][1] == NULL)
            {
                
                echo  $res[$parent_row_ids[$i]][0];
                              
                   $content = $content . "<li class='active'><a href='index.php?category_id=" . $res[$parent_row_ids[$i]][0] . "'><span>" . $res[$parent_row_ids[$i]][1]. "</span></a>";

            }

            $content = $content . "</li>";
        }

        $content = $content . "</ul>";
    }
    function checkparent(&$parent, &$res){
        
        $filtered = array();
        $row_ids = array();
        for($i = 0; $i< count($res); $i++){
            if ($res[$i][1] == $parent) {
            $filtered[] = $res[$i]; $row_ids[] = $i;
            }
            if ($parent == -1 && $res[$i][1] == null) {
            $filtered[] = $res[$i]; $row_ids[] = $i;
            }
    }
        
        return array($row_ids, $filtered);
    }
    
   function checkLastLevel($parent, $res)
    {
        for ($i = 0; $i < count($res); $i++) {
            if ($res[$i][1] == $parent) {
            return 0;
        }
    }

    return 1;
    }

    function appendPriceFilter(&$content)
    {
        $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>PRICE</div>";
        $content .= "<input type='number' name='lower_price' maxlength='20' style='width: 45%; float: left'>";
        $content .= "<div style='float: left; color: black; width: 10%; font-size: 30px; text-align: center'> - </div>";
        $content .= "<input type='number' name='upper_price' maxlength='20' style='width: 45%; float: left'><br><br>";
    }

    function appendCityFilter(&$content)
    {
        $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>CITIES</div>";
        $cities = getCities();

        if($cities[0] > 0)
        {
            $elements_length = count($cities[1]);
            $content .= "<select style='width: 100%' name='city_id' onChange='getDistrictFilter(this.value)'>";
            $content .= "<option value='value+1' selected='selected'></option>";

            for($i = 0; $i < $elements_length; $i++)
            {
                $content .= "<option value='" . $cities[1][$i][0] . "'>";
                $content .= $cities[1][$i][1]. "</a>";
                $content .= "</option>";
            }

            $content .= "</select><br><br>";
        }

        $content .= "<div id='district_filter'></div>";
    }

    function appendUserTypeFilter(&$content)
    {
        $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>USER TYPES</div>";
        $user_types = array("Lead Admin", "Sub Admin", "Member");

        $elements_length = count($user_types);
        $content .= "<select style='width: 100%' name='user_type'>";
        $content .= "<option value='' selected='selected'></option>";

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<option value='" . $user_types[$i] . "'>";
            $content .= $user_types[$i] . "</a>";
            $content .= "</option>";
        }

        $content .= "</select><br><br>";
    }

function appendSellerFilter(&$content)
    {
        $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>SELLERS</div>";
        $sellers = getSellers();

        $content .= "<select style='width: 100%' name='seller_name'>";
        $content .= "<option value='' selected='selected'></option>";

        for($i = 0; $i < $sellers[0]; $i++)
        {
            $content .= "<option value='" . $sellers[1][$i][0] . "'>";
            $content .= $sellers[1][$i][0] . "</a>";
            $content .= "</option>";
        }

        $content .= "</select><br><br>";
    }

    function appendBuyerFilter(&$content)
    {
        $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>BUYERS</div>";
        $sellers = getBuyers();

        $content .= "<select style='width: 100%' name='buyer_name'>";
        $content .= "<option value='' selected='selected'></option>";

        for($i = 0; $i < $sellers[0]; $i++)
        {
            $content .= "<option value='" . $sellers[1][$i][0] . "'>";
            $content .= $sellers[1][$i][0] . "</a>";
            $content .= "</option>";
        }

        $content .= "</select><br><br>";
    }

    function appendUserStatusFilter(&$content)
    {
        $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>USER STATUSES</div>";
        $user_statuses = array("Admin", "Passive", "Active", "Blocked");

        $elements_length = count($user_statuses);
        $content .= "<select style='width: 100%' name='user_status'>";
        $content .= "<option value='' selected='selected'></option>";

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<option value='" . $user_statuses[$i] . "'>";
            $content .= $user_statuses[$i] . "</a>";
            $content .= "</option>";
        }

        $content .= "</select><br><br>";
    }

    function appendAgeFilter(&$content)
    {
        $content .= "<br><div style='color:white; background-color: #333333; font-size:25px; width:100%; padding-top: 3px; padding-bottom: 3px; text-align: center'>AGE</div>";
        $content .= "<input type='number' name='lower_age' maxlength='20' style='width: 45%; float: left'>";
        $content .= "<div style='float: left; color: black; width: 10%; font-size: 30px; text-align: center'> - </div>";
        $content .= "<input type='number' name='upper_age' maxlength='20' style='width: 45%; float: left'><br><br>";
    }

    function addSubCategories(&$content, $res, $parent)
    {
        $content = $content . "<ul>";
        
        $parent_row_ids = checkparent($parent, $res)[0];
        $parents = checkparent($parent, $res)[1];

        for($i = 0; $i < count($parents); $i++)
        {
            $is_last_level = checkLastLevel($res[$parent_row_ids[$i]][0], $res);

            if ($is_last_level == 0 and $res[$parent_row_ids[$i]][1] == $parent) {
                $content = $content . "<li class='has-sub'><a href='#'><span>" . $res[$parent_row_ids[$i]][2] . "</span></a>";
                addSubCategories($content, $res, $res[$parent_row_ids[$i]][0]);
            }
            elseif ($is_last_level == 1 and $res[$parent_row_ids[$i]][1] == $parent)
                $content = $content . "<li><a href='index.php?category_id=" . $res[$parent_row_ids[$i]][0] . "'><span>" . $res[$parent_row_ids[$i]][2] . "</span></a>";

            $content = $content . "</li>";
        }

        $content = $content . "</ul>";
    }

    function announcementCategories(&$content)
    {
        $category = getCategories();
        $nrows = $category[0];
        $res = $category[1];

        if ($nrows == 0)
            return;

        $content = $content . "<select required name='category_id'>";
        $content .= "<option value='></option>";

        announcementSubCategories($content, $res, NULL);

        $content = $content . "</select>";
    }

    function announcementSubCategories(&$content, $res, $parent)
    {
        for($i = 0; $i < count($res[array_keys($res)[0]]); $i++)
        {
            $is_last_level = checkLastLevel($res[array_keys($res)[0]][$i], $res);

            if ($is_last_level == 0 and $res[array_keys($res)[1]][$i] == $parent) {
                if($parent == NULL)
                    $content = $content . "<optgroup label='" . $res[array_keys($res)[2]][$i] . "'>";
                else
                    $content = $content . "<optgroup label='   " . $res[array_keys($res)[2]][$i] . "'>";

                announcementSubCategories($content, $res, $res[array_keys($res)[0]][$i]);
                $content .= "</optgroup>";
            }
            elseif ($is_last_level == 1 and $res[array_keys($res)[1]][$i] == $parent) {
                $content = $content . "<option value='" . $res[array_keys($res)[0]][$i] . "'>" . $res[array_keys($res)[2]][$i] . "</option>";
            }
        }
    }

    function appendFilterMenu($content)
    {
        print_r($content);
        echo'burası';
        echo '<script type="text/javascript">
                document.getElementById("filter_menu").innerHTML = "' . $content .'";
              </script>';
    }

    function appendContent($content)
    {
        echo '<script type="text/javascript">
                document.getElementById("content").innerHTML = "' . $content .'";
              </script>';
    }
?>