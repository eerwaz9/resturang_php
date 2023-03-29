<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
if (
    isset($_GET["prod_id"])
    && is_numeric($_GET["prod_id"])
//  && is_auth()
 )
 
 {
    $prod_id = htmlspecialchars(strip_tags($_GET["prod_id"]));
    $deleteArray = array();
    array_push($deleteArray, $prod_id);
    $sql = "delete from prodd where prod_id =?";
    $result = dbExec($sql, $deleteArray);

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
