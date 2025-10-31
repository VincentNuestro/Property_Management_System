<?php
  header('Content-type: text/plain');


if (!empty($_FILES['files']['name'])) {
    //$reqtype = $_REQUEST['typeofleave'];
    $upload_dir = "../../mall_images/tenant_request/";  
    if (!file_exists($upload_dir)) {
        mkdir("../../mall_images/tenant_request/", 0777);
    }
    date_default_timezone_set('Asia/Manila');

    $tempFile = $_FILES['files']['tmp_name'];   
    $random = rand();                 
      // using DIRECTORY_SEPARATOR constant is a good practice, it makes your code portable.
    $targetPath =  $upload_dir;  
     // Adding timestamp with image's name so that files with same name can be uploaded easily.
    $path = $_FILES['files']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $finalname = strtotime(date('Y-m-d h:i:s')).$random;
    $fname =  $targetPath.$finalname.".".$ext;  
    echo  $finalname.".".$ext;
    move_uploaded_file($tempFile,$fname);       
    

}




?> 