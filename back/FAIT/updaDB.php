<?php include("./functions.php");
ini_set('display_errors','1');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('Europe/Paris');
// $liaison = CallDatabase();
$reponse = array();
isset($_POST["type"]) ? $type = $_POST["type"] : $type = '';
isset($_POST["idService"]) ? $idService = $_POST["idService"] : $idService = '';
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_STRICT);

switch ($type) {
    // case 'storeToArchive':
    //     $rqt = " UPDATE services
    //     SET isArchive = 1
    //     WHERE auto_s = $idService";
    //     $query = mysqli_query($liaison,$rqt);
    //     if ($query) {
    //         $reponse['status'] = 200;
    //     } else {
    //         $reponse['status'] = 304;
    //     }
    //     break;
    
    // case 'restoreFromArchive':
    //     $rqt = " UPDATE services
    //     SET isArchive = 0
    //     WHERE auto_s = $idService";
    //     $query = mysqli_query($liaison,$rqt);
    //     if ($query) {
    //         $reponse['status'] = 200;
    //     } else {
    //         $reponse['status'] = 304;
    //     }
    //     break;
    
    // case 'updateData':
    //     $rqt = 'UPDATE service_informatique SET ';
    //     $params = array();
    //     foreach ($_POST as $key => $value) {
    //         if(isset($_POST[$key]) && $key != 'idService' && $key != 'type'){
    //             $rqt .= $key .' = ?, ';
    //             $params[] = $value;
    //         }
    //     }
    //     $rqt = substr($rqt,0,-2);
    //     $rqt .=" WHERE auto_s = ?;"; 
    //     $params[] = $idService;
    //     $stmt = mysqli_prepare($liaison,$rqt);
    //     $exe = mysqli_stmt_execute($stmt,$params);
    //     if($exe){
    //         $reponse['status'] = 200;
    //     }else{
    //         $reponse['status'] = 304;
    //     }
    //     break;

    // case 'setInUse':
    //     $params = array();
    //     $rqt = 'UPDATE services SET isInEdit = 1 WHERE auto_s = ?';
    //     $params = [$idService];
    //     $stmt = mysqli_prepare($liaison,$rqt);
    //     $exe = mysqli_stmt_execute($stmt,$params);
    //     if($exe){
    //         $reponse['status'] = 200;
    //     }else{ 
    //         $reponse['status'] = 304;
    //     }
    //     break;
    
    // case 'unsetIsInUse':
    //     $params = array();
    //     $rqt = 'UPDATE services SET isInEdit = 0 WHERE auto_s = ?';
    //     $params = [$idService];
    //     $stmt = mysqli_prepare($liaison,$rqt);
    //     $exe = mysqli_stmt_execute($stmt,$params);
    //     if($exe){
    //         $reponse['status'] = 200;
    //     }else{ 
    //         $reponse['status'] = 304;
    //     }
    //     break;
    // default:
    //     $reponse['status'] = 404;
    //     break;
}

echo json_encode($reponse);
mysqli_close($liaison);