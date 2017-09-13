<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>All imgages</title>
</head>

<body>
	<h1>Images uploaded to the system</h1>
	<a href="index.php">Go back</a>
	
<?php
	if($submit = filter_input(INPUT_POST, 'submit')){
	if($submit == 'del_image') {
		
		$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) 
			or die('Missing/illegal id parameter');
			
		$url = filter_input(INPUT_POST, 'url') 
			or die('Missing/illegal id parameter');
		
		require_once('db_con.php');
		$sql = 'DELETE FROM image WHERE id=?';
		$stmt = $con->prepare($sql);
		$stmt->bind_param('i', $id);
		$stmt->execute();
	
		if($stmt->affected_rows > 0){
			echo 'Deleted image number '.$id;
			unlink($url);
			}
		
		else {
			echo 'Could not delete image '.$id;
		}
	}
	else {
		die('Unknown cmd: '.$submit);
	}
	}
	require_once('db_con.php');
	$sql = 'SELECT c.category_id, c.name, i.id, i.imageurl, i.title, i.category_category_id
	FROM image i, category c 
	WHERE c.category_id = i.category_category_id';
	$stmt =$con->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($cid, $cname, $id, $url, $title, $category_id);
	
	while($stmt->fetch()){ ?>
	
      	
	<h2><?=$cname?> : <?=$title?></h2>
	<img src="<?=$url?>" width="100px" /> <br>
    <a href="rename_images.php?id=<?=$id?>"><button type="button">Rename!</button></a>
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <input type="hidden" name="id" value="<?=$id?>" />
	<input type="hidden" name="url" value="<?=$url?>" />
	<button name="submit" type="submit" value="del_image">Delete</button>
	</form>
  
<?php } ?>

	
</body>
</html>