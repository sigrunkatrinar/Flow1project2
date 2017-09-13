<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php
	$tile= filter_input(INPUT_POST, 'title');
		or die('no title');

	$target_dir = "img/"; //img is the name of the folder http://localhost:8888/TUE/photos_upload/img/
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); //"fileToUpload" -THe same name as on the fifilter input
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image / filetype checker
	if(isset($_POST["submit"])) { //if pressed on submit
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . "."; //mime types is a definition of different type of media (img, gif, png)
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists, have same name 
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size, limit file size
	if ($_FILES["fileToUpload"]["size"] > 50000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			
		require_once('db_con.php');
		
		$sql = 'INSERT INTO proj2_images (imageurl, title) VALUES (?, ?)';
		$stmt = $link-> prepare($sql);
		$stmt-> bind_param(ss, $target_file, $title);
		$stmt -> execute();
		if($stmt-> affected_rows > 0)
			echo 'File data added to the database'
		
	
		} 
		else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
?>

<hr>
<a href="index.php"> Go back</a>
</body>
</html>