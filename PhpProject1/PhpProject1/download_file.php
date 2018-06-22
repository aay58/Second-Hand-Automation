<?php include "query.php"; require("./fpdf/fpdf.php");?>

<?php
    $type = $_GET["type"];
    $report_format = $_POST['report_format'];

    if($type == "announcements")
    {   
        print_r($_POST);
        
        $category_id = $_POST['category_id'];
        $lower_price = $_POST['lower_price'];
        $upper_price = $_POST['upper_price'];
        $city_id = $_POST['city_id'];
        $district_id = $_POST['district_id'];

        $announcements = getDetailsOfAnnouncements("IN SALE", $category_id, $lower_price, $upper_price, $city_id, $district_id);

        if($report_format == "html")
            $content = getAnnouncementsHtmlReport($announcements);
        else
            $content = getAnnouncementsTxtReport($announcements);

        writeFile($report_format, $content);
    }
    elseif ($type == "users")
    {
        $report_format = $_POST['report_format'];

        if(isset($_POST['user_type']))
        {
            $start_index = 0;
            $user_type = $_POST['user_type'];
            $user_status = $_POST['user_status'];
            $lower_age = $_POST['lower_age'];
            $upper_age = $_POST['upper_age'];

            $users = getUsersByFilter($user_type, $user_status, $lower_age, $upper_age);
            $start_index = 0;

            if($report_format != "html")
            {
                $temp = getUserKeyContent();
                $temp .= getUsersTxtReport($users, $start_index);
            }
            else
            {
                $temp = getUsersReportHeader();
                $temp .= getUsersHtmlReport($users, $start_index);
                $temp .= getUsersReportFooter();
            }
        }
        else
        {
            $start_index = 0;

            if($report_format != "html")
            {
                $temp = getUserKeyContent();

                $users = getSeniorAdmins();
                $temp .= getUsersTxtReport($users, $start_index);

                $users = getSubAdmins();
                $temp .= getUsersTxtReport($users, $start_index);

                $users = getPrimaryMembers();
                $temp .= getUsersTxtReport($users, $start_index);

                $users = getSecondaryMembers();
                $temp .= getUsersTxtReport($users, $start_index);
            }
            else
            {
                $temp = getUsersReportHeader();

                $users = getSeniorAdmins();
                $temp .= getUsersHtmlReport($users, $start_index);

                $users = getSubAdmins();
                $temp .= getUsersHtmlReport($users, $start_index);

                $users = getPrimaryMembers();
                $temp .= getUsersHtmlReport($users, $start_index);

                $users = getSecondaryMembers();
                $temp .= getUsersHtmlReport($users, $start_index);

                $temp .= getUsersReportFooter();
            }
        }

        writeFile($report_format, $temp);
    }
    elseif ($type == "sale_records")
    {
        if(isset($_POST['seller_name']))
        {
            $seller_name = $_POST['seller_name'];
            $buyer_name = $_POST['buyer_name'];
            $lower_age = $_POST['lower_price'];
            $upper_age = $_POST['upper_price'];

            $sale_records = getSaleRecordsByFilter($seller_name, $buyer_name, $lower_age, $upper_age);
        }
        else
        {
            $sale_records = getSaleRecords();
        }

        if($report_format == "html")
            $content = getSaleRecordsHtmlReport($sale_records);
        else
            $content = getSaleRecordsTxtReport($sale_records);

        writeFile($report_format, $content);
    }

    function getUserKeyContent()
    {
        $content = str_pad("#", 10);
        $content .= str_pad("USER NAME", 30);
        $content .= str_pad("NAME", 30);
        $content .= str_pad("SURNAME", 30);
        $content .= str_pad("STATUS", 30);
        $content .= str_pad("USER TYPE", 30);
        $content .= "\n";

        return $content;
    }

    function writeFile($report_format, $content)
    {
        if($report_format == "txt")
        {
            $file = fopen("report.txt", "w");
            fwrite($file, $content);
            fclose($file);

            header('Content-Description: File Transfer');
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="report.txt"');
            header('Expires: 0');
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize("report.txt"));
            readfile("report.txt");
        }
        elseif ($report_format == "html")
        {
            $file = fopen("report.html", "w");
            fwrite($file, $content);
            fclose($file);

            header('Content-Description: File Transfer');
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="report.html"');
            header('Expires: 0');
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize("report.html"));
            readfile("report.html");
        }
        elseif ($report_format == "pdf")
        {
            $pdf=new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',6);
            $pdf->Write(10,$content);
            $pdf->Output("D", "report.pdf");
        }
    }

    function getAnnouncementsTxtReport($announcements)
    {
        $content = "";
        $keys = array("USER_NAME", "TITLE", "HIGHEST_PRICE", "START_DATE", "END_DATE");
        $keys_length = count($keys);
        $elements_length = count($announcements[1]["USER_NAME"]);

        $content .= "#\t";
        $content .= str_pad("USER NAME", 20);
        $content .= str_pad("TITLE", 50);
        $content .= str_pad("HIGHEST PRICE", 20);
        $content .= str_pad("START DATE", 30);
        $content .= str_pad("END DATE", 20);
        $content .= "\n";

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= ($i+1) . "\t";

            for($j = 0; $j < $keys_length; $j++)
            {
                $str = $announcements[1][$keys[$j]][$i];

                if($j == 1)
                    $content .= str_pad($str, 50);
                elseif($j == 3)
                    $content .= str_pad($str, 30);
                else
                    $content .= str_pad($str, 20);
            }

            $content .= "\n";
        }

        return $content;
    }

    function getAnnouncementsHtmlReport($announcements)
    {
        $content = "
                     <style>
                        body {
                            overflow: auto;
                        }
                        table {
                            text-align: center;
                            table-layout: fixed;
                            width: 75%;
                            margin-top: 30px;   
                        }
                        table, table th, table td {
                            border: 1px solid blue;
                        }
                        table th, table td {
                            padding: 10px 10px 10px 10px;
                        }
                     </style>
                     <center>
                     <p style='text-align: center; color: blue; font-size: 25px;'><b> Announcements Report </b></p>
                     <table>
                        <tr>
                            <th><b>#</b></th>
                            <th><b>USER NAME</b></th>
                            <th><b>TITLE</b></th>
                            <th><b>HIGHEST PRICE</b></th>
                            <th><b>START DATE</b></th>
                            <th><b>END DATE</b></th>
                        </tr>
                    ";

        $keys = array("USER_NAME", "TITLE", "HIGHEST_PRICE", "START_DATE", "END_DATE");
        $keys_length = count($keys);
        $elements_length = count($announcements[1][$keys[0]]);

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<tr>";
            $content .= "<td>" . ($i+1) .  "</td>";

            for($j = 0; $j< $keys_length; $j++)
            {
                $str = $announcements[1][$keys[$j]][$i];
                $content .= "<td>" . $str .  "</td>";
            }

            $content .= "</tr>";
        }

        $content .= "</table></center><br><br><br>";

        return $content;
    }

    function getUsersTxtReport($users, &$index)
    {
        $content = "";
        $keys = array_keys($users[1]);
        $keys_length = count($keys);
        $elements_length = count($users[1][$keys[0]]);

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= str_pad($index + 1, 10);
            $index++;

            for($j = 1; $j< $keys_length; $j++)
            {
                $record_str = $users[1][$keys[$j]][$i];
                $content .= str_pad($record_str, 30);
            }

            $content .= "\n";
        }

        return $content;
    }

    function getUsersReportHeader()
    {
        $content = "
                     <style>
                        body {
                            overflow: auto;
                        }
                        table {
                            text-align: center;
                            table-layout: fixed;
                            width: 75%;
                            margin-top: 30px;   
                        }
                        table, table th, table td {
                            border: 1px solid blue;
                        }
                        table th, table td {
                            padding: 10px 10px 10px 10px;
                        }
                     </style>
                     <center>
                     <p style='text-align: center; color: blue; font-size: 25px;'><b> Users Report </b></p>
                     <table>
                        <tr>
                            <th><b>#</b></th>
                            <th><b>USER NAME</b></th>
                            <th><b>NAME</b></th>
                            <th><b>SURNAME</b></th>
                            <th><b>TYPE</b></th>
                            <th><b>STATUS</b></th>
                        </tr>
                    ";

        return $content;
    }

    function getUsersHtmlReport($users, &$index)
    {
        $content = "";
        $keys = array("USER_NAME", "NAME", "SURNAME", "USER_TYPE", "STATUS");
        $keys_length = count($keys);
        $elements_length = count($users[1][$keys[0]]);

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<tr>";
            $content .= "<td>" . ($index + 1) .  "</td>";
            $index++;

            for($j = 0; $j< $keys_length; $j++)
            {
                $str = $users[1][$keys[$j]][$i];
                $content .= "<td>" . $str .  "</td>";
            }

            $content .= "</tr>";
        }

        return $content;
    }

    function getUsersReportFooter()
    {
        $content = "";
        $content .= "</table></center>";

        return $content;
    }

    function getSaleRecordsTxtReport($sale_records)
    {
        $content = "";
        $keys = array("TITLE", "PRICE", "SELLER", "BUYER");
        $keys_length = count($keys);
        $elements_length = count($sale_records[1][$keys[0]]);

        $content .= str_pad("#", 10);
        $content .= str_pad("TITLE", 60);
        $content .= str_pad("PRICE", 20);
        $content .= str_pad("SELLER", 20);
        $content .= str_pad("BUYER", 20);
        $content .= "\n";

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= str_pad(($i+1), 10);

            for($j = 0; $j< $keys_length; $j++)
            {
                $str = $sale_records[1][$keys[$j]][$i];

                if($keys[$j] == 'SELLER')
                    $content .= str_pad($str, 20);
                elseif ($keys[$j] == 'BUYER')
                    $content .= str_pad($str, 20);
                elseif ($keys[$j] == 'TITLE')
                    $content .= str_pad($str, 60);
                else
                    $content .= str_pad($str, 20);
            }

            $content .= "\n";
        }

        return $content;
    }

    function getSaleRecordsHtmlReport($sale_records)
    {
        $content = "
                 <style>
                    body {
                        overflow: auto;
                    }
                    table {
                        text-align: center;
                        table-layout: fixed;
                        width: 75%;
                        margin-top: 60px;   
                    }
                    table, table th, table td {
                        border: 1px solid blue;
                    }
                    table th, table td {
                        padding: 10px 10px 10px 10px;
                    }
                 </style>
                 <center>
                 <table>
                    <tr>
                        <th><b>#</b></th>
                        <th><b>TITLE</b></th>
                        <th><b>PRICE</b></th>
                        <th><b>SELLER</b></th>
                        <th><b>BUYER</b></th>
                    </tr>
                ";

        $keys = array("TITLE", "PRICE", "SELLER", "BUYER");
        $keys_length = count($keys);
        $elements_length = count($sale_records[1][$keys[0]]);

        for($i = 0; $i < $elements_length; $i++)
        {
            $content .= "<tr>";
            $content .= "<td>" . ($i+1) .  "</td>";

            for($j = 0; $j< $keys_length; $j++)
            {
                $str = $sale_records[1][$keys[$j]][$i];
                $content .= "<td>" . $str .  "</td>";
            }

            $content .= "</tr>";
        }

        $content .= "</table></center>";

        return $content;
    }
?>