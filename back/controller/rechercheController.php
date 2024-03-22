<?php
if(!$included) exit;

if(isset($_POST['action'])) $action = $_POST['action']; else $action = '';
if(isset($_POST['sortBy'])) $sortBy = $_POST['sortBy']; else $sortBy = '';
$reponse = array();
switch($action){
    case 'getAllData':
        $rqt = "SELECT C.name AS 'NomClient', C.auto_c AS clientID, S.name AS 'NomSrvc',TS.name AS 'typeService',S.auto_s AS 'serviceID'
        FROM clients C
        INNER JOIN services S
        ON S.auto_c = C.auto_c
        INNER JOIN type_service TS
        ON TS.auto_ts = S.auto_ts
        ORDER BY $sortBy ASC;
        ";
        $flux = mysqli_query($liaison,$rqt);
        while ($ligne = mysqli_fetch_assoc($flux)) {
            $reponse['data'][] = $ligne;
        }
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        echo json_encode($reponse);
        break;

    case 'advSearch':
        if(isset($_POST['champ'])) $champ = $_POST['champ']; else $champ = '';
        if(isset($_POST['auto_ts'])) $auto_ts = $_POST['auto_ts']; else $auto_ts = 0;
        if(isset($_POST['value'])) $value = $_POST['value']; else $value = '';
        $rqt = '';
        if ($auto_ts == 3){
            $rqt ="SELECT C.auto_c AS clientID, C.name AS nomClient,S.name AS nomService, S.description, SI.$champ AS 'Recherche',S.auto_s AS serviceID
            FROM clients C
            INNER JOIN services S
            ON S.auto_c = C.auto_c
            INNER JOIN service_informatique SI
            ON SI.auto_s = S.auto_s
            WHERE SI.$champ LIKE '%$value%';";
        }
        $flux = mysqli_query($liaison,$rqt);
        while ($ligne = mysqli_fetch_assoc($flux)) {
            $reponse['data'][] = $ligne;
        }
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        echo json_encode($reponse);
        break;

    default :
        $reponse['status'] = 400;
        break;
}