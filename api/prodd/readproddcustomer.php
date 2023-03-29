<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../library/function.php";
if (
    isset($_GET["start"])
    && is_numeric($_GET["start"])
    && isset($_GET["end"])
    && is_numeric($_GET["end"])
	 && isset($_GET["cus_id"])
    && is_numeric($_GET["cus_id"])
    && is_auth()
) {
    $start = $_GET["start"];
    $end = $_GET["end"];
	$cus_id = $_GET["cus_id"];
	$sqlWhere = "";
	if( isset($_GET["cat_id"])
	&& is_numeric($_GET["cat_id"]))
	{
		$cat_id = $_GET["cat_id"];
		$sqlWhere = " and  cat_id = $cat_id ";
	}
	if( isset($_GET["prod_offer"])
	&& is_numeric($_GET["prod_offer"]))
	{
		$prod_offer = $_GET["prod_offer"];
		$sqlWhere = " and prod_offer != 0 ";
	}
	$txtsearch = !isset($_GET["txtsearch"])   ? "" : $_GET["txtsearch"]  ;
 	$selectArray = array();
	
    array_push($selectArray, "%" . htmlspecialchars(strip_tags($txtsearch)) . "%");
	if(trim($txtsearch) != "")
	{
		$sql = "select * 
		, (select fav_id from favorite where prod_id = prodd.prod_id and cus_id = $cus_id ) as fav_id 
		from prodd where    prod_name like ? $sqlWhere  order by prod_id desc limit $start , $end";
		$result = dbExec($sql, $selectArray);
	}
	else
	{
		$sql = "select * 
		, (select fav_id from favorite where prod_id = prodd.prod_id and cus_id = $cus_id ) as fav_id 
		from prodd where  1 = 1 $sqlWhere order by prod_id desc limit $start , $end";
	
		$result = dbExec($sql, []);
	}
    $arrJson = array();
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // extract($row);
            $arrJson[] = $row;
        }
    }
    $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
