<?php
// Include the database configuration file
$statusMsg = '';
$backlink = ' <a href="./">Go back</a>';

// File upload path
$targetDir = "assets/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;//change the file name here
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"]))
{
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if (!file_exists($targetFilePath)) {
        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
            }
        }
    }
    else
    {
        $statusMsg = "The file <b>".$fileName. "</b> is already exist." . $backlink;
    }
}
else{
    $statusMsg = 'Please select a file to upload.' . $backlink;
}
// Display status message
echo $statusMsg;
?>