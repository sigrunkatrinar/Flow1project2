<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Category images</title>
</head>

<body>

<?php
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'add_category') {
		$catname = filter_input(INPUT_POST, 'catname') 
			or die('Missing/illegal catname parameter');
		
		require_once('db_con.php');
		$sql = 'INSERT INTO category (name) VALUES (?)';
		$stmt = $con->prepare($sql);
		$stmt->bind_param('s', $catname);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'Added '.$catname.' as category number '.$stmt->insert_id;
		}
		else {
			echo 'Could not create the new category!!!';
		}	
	}
	elseif($cmd == 'del_category') {
		$cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT) 
			or die('Missing/illegal cid parameter');
		
		require_once('db_con.php');
		$sql = 'DELETE FROM category WHERE category_id=?';
		$stmt = $con->prepare($sql); //Prepare an SQL statement for execution
		$stmt->bind_param('i', $cid); //parameter 
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo 'Deleted category number '.$cid;
		}
		else {
			echo 'Could not delete category '.$cid;
		}
	}
	else {
		die('Unknown cmd: '.$cmd);
	}
}
?>


	<h1>Categories</h1>
	<ul>
<?php
	require_once('db_con.php');
	
	$sql = 'SELECT category_id, name FROM category';
	$stmt = $con->prepare($sql);
	// $stmt->bind_param();  not needed - no placeholders....
	$stmt->execute();
	$stmt->bind_result($cid, $nam);
	
	while($stmt->fetch()){ 
//  	echo '<li><a href=”filmlist.php?categoryid='.$cid.'”>'.$nam.'</a>';
//		echo '<a href=”renamecategory.php?categoryid='.$cid.'”>Rename</a>';
//		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
//		echo '<input type="hidden" name="cid" value="'.$cid.'" />';
//		echo '<button name="cmd" type="submit" value="del_category">Delete</button>';
//		echo '</form></li>'.PHP_EOL;
?>

<!--CATEGORY LIST-->
<div class="catlist">
	<li>	 

		<a href="imagelist.php?category_id=<?=$cid?>"><?=$nam?>
		</a> 
        <br> 
        <a href="renamecategory.php?cid=<?=$cid?>">
        <button type="button">Rename!</button>
        </a>
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<input type="hidden" name="cid" value="<?=$cid?>" />
		<button name="cmd" type="submit" value="del_category">Delete</button>
	</form>
	</li>
</div>
<?php
	}	
?>
	</ul>
	<hr>

	<p>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name='newcategory'>

<!-- NEW CATEGORY-->
	<h2>Create New Category</h2>
    <input  name="catname" type="text" placeholder="Category name" required />
	
    <button name="cmd" type="submit" value="add_category">Create</button>
	
</form>

<!--VIEW ALL PICTURES-->
<h2>Images</h2>

	<a href="allimages.php">View all pictures</a>
	<hr>
</p>

<!--UPLOAD PICTURES-->
	<h2>Upload a new picture</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:<br>
    	<input type="text" name="title" placeholder="Image title" required /><br>
    	<input type="file" name="fileToUpload" id="fileToUpload"><br>
    	<input type="submit" value="Upload Image" name="submit">
   
    <select name='minDropListe'>
      <?php
	require_once('db_con.php');
	
	$sql = 'SELECT category_id, name FROM category';
	$stmt = $con->query($sql);
		
		if($stmt->num_rows > 0){
			
		while($row = $stmt->fetch_assoc()){ 
			
			echo "<option name='category_id' value='".$row['category_id']."'>".$row['name']."</option>";
		}}
		else {
			echo 'Could not find category '.$cid;
		
		}
		?>	</select>
   	
   	
	</form>
	
</body>
</html>