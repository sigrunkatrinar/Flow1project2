<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

	<h1>Image stuff</h1>

	Lets <a href="viewimages.php">view those pictures</a>
	<hr>
	<h2>Upload a new picture</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:<br>
    	<input type="text" name="title" placeholder="Image title" required />
    	<input type="file" name="fileToUpload" id="fileToUpload"><br>
    	<input type="submit" value="Upload Image" name="submit">
	</form>
</body>
</html>