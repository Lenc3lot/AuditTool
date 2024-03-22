<?php
if(!$included) exit;

if (isset($_POST['action'])) $action = $_POST['action']; else $action = '';
isset($_POST['clientId']) ? $clientId = sanitizeData($_POST['clientId']) : $clientId = '';

switch ($action) {
    case 'getClients':
        //Afficher clients
        $rqt = "SELECT auto_c AS clientId, name AS clientName 
        FROM clients";
        $flux = mysqli_query($liaison, $rqt);
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
    
    case 'getNomCli':
        $rqt = "SELECT name 
        FROM clients 
        WHERE auto_c= $clientId";
        $flux = mysqli_query($liaison, $rqt);
        $reponse['data'][] = mysqli_fetch_assoc($flux);
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        echo json_encode($reponse);
        break;

    default:
        # code...
        break;
}