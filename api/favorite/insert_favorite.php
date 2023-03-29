<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";


if (
    isset($_POST["cus_id"])
    && isset($_POST["prod_id"])
    && is_auth()
  
) {
	
    $cus_id = $_POST["cus_id"];
    $prod_id = $_POST["prod_id"];
	
	


    $insertArray = array();
    array_push($insertArray, htmlspecialchars(strip_tags($cus_id)));
    array_push($insertArray, htmlspecialchars(strip_tags($prod_id)));
	
	  

    $sql = "insert into favorite
        (cus_id , prod_id , fav_regdate )
            values(? , ? ,  now())";
    $result = dbExec($sql, $insertArray);

	  $readArray = array();
	
    array_push($readArray, htmlspecialchars(strip_tags($cus_id)));
	array_push($readArray, htmlspecialchars(strip_tags($prod_id)));
	
    $sql = "select * from favorite where cus_id = ? and prod_id = ?  order by prod_id desc limit 0,1";
    $result = dbExec($sql, $readArray);
    $arrJson = array();
    if ($result->rowCount() > 0) {
        $arrJson  = $result->fetch();
	}

	

    $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
