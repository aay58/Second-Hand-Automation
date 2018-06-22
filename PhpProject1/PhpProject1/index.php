<?php  include "base.php"; include "query.php" ?>

<?php
    if(isset($_SESSION["user_name"]))
    {
        $action = $_SESSION["user_name"] . " viewed announcements.";
        addProcessingHistory($action);
    }

    $elements = initialize($_GET, $_POST);
    $page_number = $elements[0];
    $category_id = $elements[1];
    $district_id = $elements[2];
    $lower_price = $elements[3];
    $upper_price = $elements[4];
    $city_id = $elements[5];
    
    $element_count = 9;
    $start_index = ($page_number-1) * $element_count;
    $finish_index = $start_index + $element_count;

    $content = "";
    appendMenuBar(true);
    appendCategoryFilter($content);
    $content .= "<form action='index.php' method='post' accept-charset='UTF-8'>";
    appendPriceFilter($content);
    appendCityFilter($content);
    $content .= "<input type='number' style='display: none' name='category_id' value='" . $category_id . "'>";
    $content .= "<input type='submit' style='width: 100%; height: 40px; background-color:darkslategray; color: white;' value='Apply Filter'>";
    $content .= "</form>";
    appendFilterMenu($content);

    $content = "";
    $info = getAnnouncementMainInfo("IN SALE", $category_id, $lower_price, $upper_price, $city_id, $district_id);
    $images = getImages();
  
    if(isset($_SESSION["user_id"]))
        $wishList = getWishList($_SESSION["user_id"]);
    else
        $wishList = getWishList(0);
    
    

    $keys = $info[1];
    
    $count = $info[0];
    
    //$id = array_column($keys, 'ANNOUNCEMENT_ID');
    $id = 0;
    //$title = array_column($keys, 'TITLE');var_dump($title);
    $title = 1;
   // $price = array_column($keys, 'PRICE');    
    $price = 2;
    
    if ($finish_index > $count) {
    $finish_index = $count;
}

for ($i = $start_index; $i < $finish_index; $i++)
    {
        $title_str = str_replace('"', '\"', $info[1][$i][$title]);
        $imageUrl = imageIndexOfAnnouncement($images, $info[1][$i][$id] );
        
        $content .= "<div style='margin-left:6%; margin-top: 10px; float:left; width: 25%; height: 580px; background-color: lightgray; border-style: solid; border-width: medium; border-color: darkgray'>";
        $content .= "<div style='font-size: 20px; padding-top: 10px; width: 100%; height: 25px; text-align: center;  overflow: hidden; text-overflow: ellipsis'><b>" . $title_str . "</b></div>";
        $content .= "<img src='images/" . $imageUrl . "' alt='Image not found' onerror=this.src='images/default.jpg' style='width: 90%; margin-left: 5%; margin-top: 10px; height: 420px'>";
        $content .= "<div style='font-size: 20px; padding-top: 10px; width: 100%; text-align: center;  overflow: hidden; text-overflow: ellipsis'><b style='font-size: 24px'>$</b>" . $info[1][$i][$price] . "</div>";

        if(isset($_SESSION["user_type"]))
        {
            if($_SESSION["user_type"] == "member" ) {
                $value = 0;

                for($j = 0; $j < $wishList[0]; $j++) {
                    if($wishList[1][$j][1] == $info[1][$i][$id])
                    {
                        $value = 1;
                        
                        $content .= "<button id='announcement_" . $info[1][$i][$id] . "' value='" . $value . "' style='width:30%; margin-top:10px; height:50px; margin-left:4%' title='Add favorite' onclick='getFavoriteContent(" . $info[1][$i][$id] . ");'><i class='fa fa-heart'></i></button>";

                        break;
                    }
                }

                if($value == 0)
                {
                  
                    $content .= "<button id='announcement_" . $info[1][$i][$id] . "' value='" . $value . "' style='width:30%; margin-top:10px; height:50px; margin-left:4%' title='Add favorite' onclick='getFavoriteContent(" . $info[1][$i][$id] . ");'><i class='fa fa-heart-o'></i></button>";
                }

                $content .= "<input type='button' style='width:30%; margin-top:10px; height:50px; margin-left:1%' value='See Details' onclick=location.href='announcement_details.php?id=" . $info[1][$i][$id] . "&page_name=announcements&page_number=" . $page_number . "&previous_page=index.php?page_number=" . $page_number . "'>";
                $content .= "<input type='button' style='width:30%; margin-top:10px; height:50px;  margin-left:1%' value='Offer' onclick=location.href='offer.php?id=" . $info[1][$i][$id] . "&page_name=index&page_number=" . $page_number . "'>";
            }
            else
            {
                $content .= "<input type='button' style='width:48%; margin-top:10px; height:50px; margin-left:2%' value='See Details' onclick=location.href='announcement_details.php?id=" . $info[1][$i][$id] . "&page_name=announcements&page_number=" . $page_number . "&previous_page=index.php?page_number=" . $page_number . "'>";
                $content .= "<button style='width:48%; margin-top:10px; height:50px;' onclick=location.href='delete.php?page_name=index.php&table_name=ANNOUNCEMENT&id_name=ANNOUNCEMENT_ID&id=" . $info[1][$i][$id] . "'><i class='fa fa-times'></i></button>";
            }
        }
        else
        {
            $content .= "<input type='button' style='width:48%; margin-top:10px; height:50px; margin-left:2%' value='See Details' onclick=location.href='announcement_details.php?id=" . $info[1][$i][$id] . "&page_name=announcements&page_number=" . $page_number . "&previous_page=index.php?page_number=" . $page_number . "'>";
            $content .= "<input type='button' style='width:48%; margin-top:10px; height:50px;  margin-left:1%' value='Offer' onclick=location.href='login.php'>";
        }

        $content .= "</div>";
    }

    $content .= "<div style='float: inherit; width: 100%;  margin-bottom: 10px; margin-top: 20px;  '>";

    if($page_number == 1)
    {
        $content .= "<input type='button' style='float:left; width:20%; margin-left:30%; height:50px;' value='❮ Previous' disabled>";
    }
    else
    {
        $content .= "<input type='button' style='float:left; width:20%; margin-left:30%; height:50px;' value='❮ Previous' onclick=location.href='index.php?page_number=" . ($page_number - 1) . "'>";
    }

    if($start_index + $element_count >= $count)
    {
        $content .= "<input type='button' style='float:left; width:20%; height:50px;' value='Next ❯' disabled>";
    }
    else
    {
        $content .= "<input type='button' style='float:left; width:20%; height:50px;' value='Next ❯' onclick=location.href='index.php?page_number=" . ($page_number + 1) . "'>";
    }

    $content .= "</div>";
    $content .= "<div style='float: inherit; width: calc(100% - 800px); margin-top: 40px; margin-left: calc(50% - 200px)'>";
    $content .= "<form action='download_file.php?type=announcements' method='post' accept-charset='UTF-8'>";
    $content .= "<input type='number' style='float:left; display:none' name='category_id' value='" . $category_id . "'>";
    $content .= "<input type='text' style='float:left; display:none' name='lower_price' value='" . $lower_price . "'>";
    $content .= "<input type='text' style='float:left; display:none' name='upper_price' value='" . $upper_price . "'>";
    $content .= "<input type='number' style='float:left; display:none' name='city_id' value='" . $city_id . "'>";
    $content .= "<input type='number' style='float:left; display:none' name='district_id' value='" . $district_id . "'>";
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

    function initialize($get, $post)
    {
        if (isset($_GET['logout']))
        {
            unset($_SESSION["user_name"]);
            unset($_SESSION["user_id"]);
            unset($_SESSION["user_type"]);
            unset($_SESSION["name"]);
            unset($_SESSION["surname"]);
        }

        if (isset($get['page_number']))
            $page_number = $get['page_number'];
        else
            $page_number = 1;

        if (isset($get['category_id']))
            $category_id = $get['category_id'];
        else
            $category_id = 0;

        if (isset($post['category_id']))
            $category_id = $post['category_id'];

        if (isset($post['district_id']))
            $district_id = $post['district_id'];
        else
            $district_id = 0;

        if(isset($post['lower_price']))
            $lower_price = $post['lower_price'];
        else
            $lower_price = 0;

        if(isset($post['upper_price']))
            $upper_price = $post['upper_price'];
        else
            $upper_price = 0;

        if(isset($post['city_id']))
            $city_id = $post['city_id'];
        else
            $city_id = 0;

        $elements = array($page_number, $category_id, $district_id, $lower_price, $upper_price, $city_id);

        return $elements;
    }
    
    function imageIndexOfAnnouncement($images, $product_id)
    {
              
        for($i = 0; $i < $images[0]; $i++)
        {
            if($images[1][$i][1] == $product_id)
                return $images[1][$i][2];
        }
    }
 
?>