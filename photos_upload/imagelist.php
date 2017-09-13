<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
	<h1>Images in category</h1>
	<a href="index.php">Go back</a>
	
<?php
	
	
	$cid = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT) 
		or die('Missing/illegal category parameter');		

	
	require_once('db_con.php');
	$sql = 'SELECT c.category_id, i.category_category_id, i.imageurl, i.title, i.id
	FROM category c, image i
	WHERE c.category_id = i.category_category_id
	AND c.category_id =?';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('i', $cid); // Bind variables for the parameter markers in the SQL statement that was passed to
	$stmt->execute();
	$stmt->bind_result($cid, $categorynumber, $url, $title, $id);
	while ($stmt->fetch()){ ?>
	
	<h2> <?=$id?>: <?=$title?></h2>
	<img src="<?=$url?>" width="100px" />
<?php } ?>


</body>

</html>