<?php
	$db = mysqli_connect('localhost','root','','db_restautant');
	if (!$db) {
		echo "Database connection faild";}
	$prod_image = $_FILES['image']['name'];
	$prod_thumbnail = $_FILES['image']['name'];
	$cat_id = $_POST["cat_id"];
    $prod_name = $_POST["prod_name"];
    $prod_name_en = $_POST["prod_name_en"];
	$prod_price = $_POST["prod_price"];
	$prod_offer = $_POST["prod_offer"] == null ? "" : $_POST["prod_offer"]  ;
    $prod_info = $_POST["prod_info"];
	$prod_info_en = $_POST["prod_info_en"] == null ?"" : $_POST["prod_info_en"] ;
	$imagePath = 'images/category/'.$image;
	$tmp_name = $_FILES['image']['tmp_name'];
	move_uploaded_file($tmp_name, $imagePath);
	$db-> query ("INSERT INTO  prodd
	(cat_id,prod_name , prod_name_en ,
	prod_price , prod_offer ,
	prod_info , prod_info_en ,		
	prod_image , prod_thumbnail	
	, prod_regdate )
	VALUES('".$cat_id."','".$prod_name."','".$prod_name_en."','".$prod_price."','".$prod_offer."',
	'".$prod_info."','".$prod_info_en."','".$prod_image."','".$prod_thumbnail."',now())");
		 
?>