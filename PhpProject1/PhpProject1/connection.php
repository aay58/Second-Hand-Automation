<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    define("DB_SERVER", "127.0.0.1");
   define("DB_USERNAME", "root");
   define("DB_PASSWORD", "");
   define("DB_DATABASE", "project3");
   global $db;
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
   
   