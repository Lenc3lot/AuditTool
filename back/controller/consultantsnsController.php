<?php
if (!$included)
    exit;

isset($_POST['action']) ? $action = $_POST['action'] : $action = '';
isset($_POST['clientId']) ? $clientId = sanitizeData($_POST['clientId']) : $clientId = '';
isset($_POST['pwd']) ? $mdp = hash('sha256', $_POST['pwd']) : $mdp = '';
isset($_POST['loginSNS']) ? $loginSNS = htmlspecialchars($_POST['loginSNS']) : $loginSNS = '';
$reponse = [];

switch ($action) {
    case 'getSNSAccount':
        $rqt = "SELECT pwd
        FROM consultantsns
        WHERE login = '$loginSNS'";
        $flux = mysqli_query($liaison, $rqt);
        $lignePwd = mysqli_fetch_assoc($flux);
        if ($lignePwd) {
            // $reponse['hashMdp'] = $mdp;
            if ($mdp == $lignePwd['pwd']) {
                $rqt = "SELECT auto_cos AS 'idConsultant', nom AS 'NomConsultant', prenom AS 'PrenomConsultant', auto_ta AS 'permission'
                FROM consultantsns
                WHERE login = '$loginSNS'";
                $flux = mysqli_query($liaison, $rqt);
                $reponsezef['data'][] = mysqli_fetch_assoc($flux);
                if (!$flux) {
                    $reponse['status'] = 400;
                } else {
                    $reponse['status'] = 200;
                    $elToken = craftToken($reponsezef['data']);
                    // $clearToken = decodeToken($elToken);
                    $reponse['token'] = $elToken;  
                }
            }
        } else {
            $reponse['status'] = 400;
        }
        echo json_encode($reponse);
        break;

    default:
        # code...
        break;
}