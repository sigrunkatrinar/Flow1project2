<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Rename Category</title>
</head>

<body>

<?php
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'rename_category') {
		$cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT) 
			or die('Missing/illegal cid parameter');
		$catname = filter_input(INPUT_POST, 'catname') 
			or die('Missing/illegal catname parameter');
		
		require_once('db_con.php');
		$sql = 'UPDATE category SET name=? WHERE category_id=?';
		$stmt = $con->prepare($sql);
		$stmt->bind_param('si', $catname, $cid);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'Changed category name to '.$catname;
		}
		else {
			echo 'Could not change the name of the category';
		}	
	}
}
?>

<hr>


<?php
	if (empty($cid)){
		$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT) 
			or die('Missing/illegal cid parameter');	
	}
	require_once('db_con.php');
	$sql = 'SELECT name FROM category WHERE category_id=?';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('i', $cid);
	$stmt->execute();
	$stmt->bind_result($catname);
	while($stmt->fetch()){} 
?>

<p>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
    	<legend>Rename Category</legend>
    	<input name="cid" type="hidden" value="<?=$cid?>" />
    	<input name="catname" type="text" value="<?=$catname?>" />
    	<button name="cmd" type="submit" value="rename_category">Save new name</button>
	</fieldset>
</form>
</p>
<hr>
	<a href="index.php">View all Categories</a>

</body>
</html>