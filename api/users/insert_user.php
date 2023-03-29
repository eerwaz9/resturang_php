<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
/*$images = uploadCustomerImage("file", '../../images/customer/' , 400 , 600 );
	$img_image = $images['image'];
	$img_thumbnail  = $images['thumbnail'];*/
if (
    isset($_POST["use_name"])
    && isset($_POST["use_pwd"])
    && isset($_POST["use_mobile"])
    && is_auth()
) {
    $use_name = $_POST["use_name"];
    $use_pwd = $_POST["use_pwd"];
    $use_mobile = $_POST["use_mobile"];
    $use_active = isset($_POST["use_active"]) ? $_POST["use_active"] : "0";
    $use_note = isset($_POST["use_note"]) ? $_POST["use_note"] : "";

    $insertArray = array();
    array_push($insertArray, htmlspecialchars(strip_tags($use_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($use_pwd)));
    array_push($insertArray, htmlspecialchars(strip_tags($use_mobile)));
    array_push($insertArray, htmlspecialchars(strip_tags($use_active)));
    array_push($insertArray, htmlspecialchars(strip_tags($use_note)));
//اذا ضهر الخطاء الشائع يتم التخقق وتدقيق في جملة الاستعلام
    $sql = "
            insert into users
            (use_name , use_pwd ,
            use_mobile ,use_active ,
            use_note , use_datetime
            , use_lastdatetime )
                values(?,? ,
                ? , ? ,
                ? , now(),
                 now())";

                 $result = dbExec($sql, $insertArray);
	
	
                 $readArray = array();
    array_push($readArray, htmlspecialchars(strip_tags($use_mobile)));
    $sql = "select * from users where use_mobile = ?  order by use_id desc limit 0,1";
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
