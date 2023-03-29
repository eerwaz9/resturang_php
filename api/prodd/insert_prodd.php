 

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../library/function.php";
include_once "../../library/create_image.php";

if (isset($_POST["prod_name"])
&& isset($_POST["prod_name_en"])
&& isset($_POST["prod_price"])
&& isset($_POST["prod_info"])
&& isset($_POST["prod_info_en"])
&& is_auth()
  
) {
  
	$cat_id = $_POST["cat_id"];
     $prod_name = $_POST["prod_name"];
    $prod_name_en = $_POST["prod_name_en"];
	$prod_price = $_POST["prod_price"];
	$prod_offer = $_POST["prod_offer"] == null ? "" : $_POST["prod_offer"]  ;
    $prod_info = $_POST["prod_info"];
	$prod_info_en = $_POST["prod_info_en"] == null ?"" : $_POST["prod_info_en"] ;
	if (!empty($_FILES["file"]['name']) )
	{
		$images = uploadImage("file" , '../../images/prodd/' , 200 , 600);
		$img_image = $images["image"];
		$img_thumbnail = $images["thumbnail"];
    
	} 
	else
{
$img_image ="";
$img_thumbnail = "";
}  
	$insertArray = array();
	array_push($insertArray, htmlspecialchars(strip_tags($cat_id)));
    array_push($insertArray, htmlspecialchars(strip_tags($prod_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($prod_name_en)));
	array_push($insertArray, htmlspecialchars(strip_tags($prod_price)));
    array_push($insertArray, htmlspecialchars(strip_tags($prod_offer)));
	array_push($insertArray, htmlspecialchars(strip_tags($prod_info)));
    array_push($insertArray, htmlspecialchars(strip_tags($prod_info_en)));
	array_push($insertArray, htmlspecialchars(strip_tags($img_image)));
    array_push($insertArray, htmlspecialchars(strip_tags($img_thumbnail)));

    
    $sql = "insert into prodd
        (cat_id,prod_name , prod_name_en ,
		prod_price ,prod_offer ,
		prod_info ,prod_info_en ,		
		prod_image , prod_thumbnail	
		, prod_regdate )
            values(? ,?  , ? ,
			? , ? ,
			? , ? ,
			? , ? ,
			 now())";
    $result = dbExec($sql, $insertArray);
    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}