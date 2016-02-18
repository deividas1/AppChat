<?php
if (file_exists('chat.txt')) {
	file_put_contents("chat.txt", "");
	echo "CHAT HISTORY CLEARED";
} else {
	echo "ERROR - NO FILE";
}

// delete all uploaded files
$files = glob('uploads/*'); // get all file names
foreach($files as $file) { 
  if(is_file($file))
    unlink($file);
}

