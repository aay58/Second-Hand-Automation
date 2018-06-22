<?php include "base.php"; include "query.php"; ?>

<?php
    appendMenuBar(false);

    if (isset($_GET['page_number'])) {
        $page_number = $_GET['page_number'];
    }
    else
    {
        $page_number = 1;
    }

    if(isset($_GET['previous_page'])) {
        $previous_page = $_GET['previous_page'];
        $page_name = $_GET['page_name'];
    }
    else
    {
        $previous_page = "index.php?page_number=" . $page_number;
        $page_name = "announcements";
    }

    $announcement_id = $_GET['id'];
    $announcement =  getAnnouncementById($announcement_id)[1];

    if(isset($_SESSION["user_name"]))
    {
        $action = $_SESSION["user_name"] . " viewed the announcement details titled " . $announcement[0][0] . ".";
        addProcessingHistory($action);
    }

    $user_id = $announcement[0][2];
  
    $product_id = $announcement[0][1];
    
    $city_id = $announcement[0][3];
    $district_id = $announcement[0][4];
    $user =  getUserById($user_id)[0];
   
    $product =  getProductById($product_id);

    $city =  getCityById($city_id);
        
    $district =  getDistrictById($district_id);
    
    $image =  getImageUrl($product_id);
   
 
    $content = "";
    $content .= "<fieldset>";
    $content .= "<legend style='color:gray'><b>Announcement Details</b></legend>";
    $content .= "<fieldset>";
    print_r( $image[1][0][0]);
    for($i = 0; $i < $image[0]; $i++)
    {    $content .= "<img src='images/" . $image[1][$i][0] . "' style='height: 250px; width:200px; margin-right: 10px; float:left' alt='Image not found' onerror=this.src='images/default.jpg'>";
    
    if ($image[0] <= 0)
        $content .= "<img src='" . $image[$i] . "' style='height: 250px; width:200px; margin-right: 10px; float:left' alt='Image not found' onerror=this.src='images/default.jpg'>";
    }

    $content .= "<br><br><div style='text-align:right'>" . "<b>Start Date:</b>" . " " . $announcement[0][8] . "</div><br>";
    $content .= "<div style='text-align:right'>" . "<b>End Date:</b>" .  " " . $announcement[0][9] . "</div><br><br><br><br><br><br><br><br>";

    if($user_id != $_SESSION["user_id"])
    {
        $content .= "<br><b>Advertiser: </b>";
        $content .= "<a href='user_details.php?user_id=" . $user_id . "&page_name=announcement&previous_page=announcement_details.php?id=" . $announcement_id . "&page_number=" . $page_number .  "'>" . $user[1] . " " . $user[2] . "</a>";
    }
    
    $content .= "<br><br><b>Title: </b>" . $announcement[0][5] . "<br><br>";
    $content .= "<b>Text: </b>" . $announcement[0][7] . "<br><br>";
    $content .= "<b>Price: </b>" . "$" . $announcement[0][6] . "<br><br>";
    $content .= "<b>Color: </b>" . $product[1][0][4] . "<br><br>";
    $content .= "<b>Mark: </b>" . $product[1][0][5] . "<br><br>";
    $content .= "<b>Dimension: </b>" . $product[1][0][6] . "<br><br>";
    $content .= "<b>City: </b>" . $city[1][0][1] . "<br><br>";
    $content .= "<b>District: </b>" . $district[1][0][2] . "<br><br>";
    $content .= "<input type='button' value='Back to " . $page_name . "' onclick=location.href='" . $previous_page . "'>";

    if($user_id != $_SESSION["user_id"])
    {
        $content .= "<input type='button' value='Offer' onclick=location.href='offer.php?id=" . $announcement_id . "&page_name=announcement_details&page_number=" . $page_number . "'>";
    }

    $content .= "</fieldset>";

    appendContent($content);
?>