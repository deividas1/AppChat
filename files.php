<?php

if (isset($_GET['function'])) {
  if ($_GET['function'] == 'get' && isset($_GET['file'])) {
    $folder = "uploads/";
    $file = $_GET['file'];

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=\"".$file. "\"");
    header("Content-Transfer-Encoding: binary ");
    readfile($folder."/".$file);
  }
} else { 
  $data = array();

  if(isset($_FILES['inputFile'])) {  
      $error = false;
      $files = array();

      $uploaddir = 'uploads/';
      foreach($_FILES as $file)
      {
        if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
        {
            $files[] = $uploaddir .$file['name'];
        }
        else
        {
            $error = true;
        }
      }

      $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);

  }
  else
  {
      $data = array('error' => 'No files set');
  }

  echo json_encode($data);
}
?>