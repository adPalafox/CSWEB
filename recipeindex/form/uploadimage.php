<?php

include '../db.php';
$statusMsg = '';

if(isset($_FILES['file']['name'])){
   // file name
   $filename = $_FILES['file']['name'];

   // Location
   $location = '../assets/'.$filename;
   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("pdf","doc","docx","jpg","png","jpeg");

   $response = 0;
   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
         $response = 1;
         //$insert = $db->query("INSERT into recipe (user_id, recipe_name, recipe_description, servings, cook_time, img_name, category) VALUES (1, 'Kenneth', 'Monggo', '100', '50', 'monggo.png', 'vegetable')");
      } 
   }
   echo $response;
   
   exit;
}