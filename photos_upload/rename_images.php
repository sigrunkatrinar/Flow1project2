<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Rename images</title>
</head>

<body>

<?php
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'rename_image') {
		$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) 
			or die('Missing/illegal id parameter');
		$imgtitle = filter_input(INPUT_POST, 'imgtitle') 
			or die('Missing/illegal title parameter');
		
		require_once('db_con.php');
		$sql = 'UPDATE image SET title=? WHERE id=?';
		$stmt = $con->prepare($sql);
		$stmt->bind_param('si', $imgtitle, $id);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'Changed image name to '.$imgtitle;
		}
		else {
			echo 'Could not change the name of the image';
		}	
	}
}
?>

<hr>


<?php
	if (empty($id)){
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) 
			or die('Missing/illegal id parameter');	
	}
	require_once('db_con.php');
	$sql = 'SELECT title FROM image WHERE id=?';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($imgtitle);
	while($stmt->fetch()){} 
?>

<p>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
    	<legend>Rename Category</legend>
    	<input name="id" type="hidden" value="<?=$id?>" />
    	<input name="imgtitle" type="text" value="<?=$imgtitle?>" />
    	<button name="cmd" type="submit" value="rename_image">Save new name</button>
	</fieldset>
</form>
</p>
<hr>
	<a href="allimages.php">View all Categories</a>

</body>
</html>