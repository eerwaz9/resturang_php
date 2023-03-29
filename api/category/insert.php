
<?php
	$db = mysqli_connect('localhost','root','','db_restautant');
	if (!$db) {
		echo "Database connection faild";}

	$cat_image = $_FILES['image']['name'];
	$cat_thumball = $_FILES['image']['name'];
	$cat_name = $_POST['cat_name'];
	$cat_name_en = $_POST['cat_name_en'];
	$imagePath = 'images/category/'.$image;
	$tmp_name = $_FILES['image']['tmp_name'];
	move_uploaded_file($tmp_name, $imagePath);
	$db->query("INSERT INTO category(cat_name,cat_name_en,cat_image,cat_thumball,cat_regdate)
	VALUES('".$cat_name."','".$cat_name_en."','".$cat_image."','".$cat_thumball."',now())");
	?>