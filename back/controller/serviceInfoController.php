<?php
if(!$included) exit;

if (isset($_POST['action'])) $action = $_POST['action']; else $action = '';
if (isset($_POST['frsSelected'])) $frsSelected = $_POST['frsSelected']; else $frsSelected = '';
if (isset($_POST['idClient'])) $clientId = $_POST['idClient']; else $clientId = '';
if (isset($_POST['idService'])) $idService = $_POST['idService']; else $idService ='';

switch ($action) {
    case 'getAccesInternet':
        $rqt = "SELECT SI.auto_s,typeLien, souscrisSNS, fournisseur
        FROM service_informatique SI
        INNER JOIN services S
        ON SI.auto_s = S.auto_s
        WHERE auto_c = '$clientId'
        AND S.isArchive != 1";
        $flux = mysqli_query($liaison,$rqt);
        while ($ligne = mysqli_fetch_assoc($flux)) {
            if($ligne['souscrisSNS'] == 1){
                $ligne['souscrisSNS'] = 'OUI' ;    
            }else{
                $ligne['souscrisSNS'] = 'NON' ;    
            }
            $reponse['data'][] = $ligne;
        }
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        echo json_encode($reponse);
        break;
    
    case 'getAccesInternetDetails':
        $rqt = "SELECT SI.auto_s AS ID, typeLien AS 'Type de lien', souscrisSNS AS 'Souscris SNS', fournisseur AS 'Fournisseur', typeOffre AS 'Type offre', typeAcces AS 'Type accès', offre AS 'Offre', refFournisseurLien AS 'Référence fournisseur Lien', numSupport AS ' Numéro support', GTR AS 'GTR_verif', gtrTexte AS 'GTR', ipFixe AS 'IP Fixe_verif' , ipFixeNum AS 'IP Fixe', typeAuthLien AS 'Type authentification lien', infoAuth as 'Info authentification', dateSouscription AS 'Date souscription', equipementArrivee AS 'Equipement d arrivée', equipementAuth AS 'Equipement authentification', ascendantRsx AS 'Ascendant Reseau', localisation AS 'Localisation'
        FROM service_informatique SI
        INNER JOIN services S
        ON S.auto_s = SI.auto_s
        WHERE S.auto_c = $clientId AND SI.auto_s = '$idService' ";
        $flux = mysqli_query($liaison,$rqt);
        while ($ligne = mysqli_fetch_assoc($flux)) {
            if($ligne['Souscris SNS'] == 1){
                $ligne['Souscris SNS'] = 'OUI' ;  
                unset($ligne['Type offre']);
            }else{
                $ligne['Souscris SNS'] = 'NON' ;
                unset($ligne['Offre']);    
            }
            $reponse['data'][] = $ligne;
        }
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        echo json_encode($reponse);
        break;
    
    case 'getArchiveInternet':
        $rqt= "SELECT SI.auto_s,typeLien, souscrisSNS, fournisseur
        FROM service_informatique SI
        INNER JOIN services S
        ON SI.auto_s = S.auto_s
        WHERE auto_c = '$clientId'
        AND S.isArchive != 0";
        $flux = mysqli_query($liaison,$rqt);
        while ($ligne = mysqli_fetch_assoc($flux)){
            if($ligne['souscrisSNS'] == 1){
                $ligne['souscrisSNS'] = 'OUI' ;    
            }else{
                $ligne['souscrisSNS'] = 'NON' ;    
            }
            $reponse['data'][] = $ligne;
        }
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        echo json_encode($reponse);
        break;

    case 'putData':
        $rqt = 'UPDATE service_informatique SET ';
        $params = array();
        foreach ($_POST as $key => $value) {
            if(isset($_POST[$key]) && $key != 'idService' && $key != 'action' && $key != 'req'){
                $rqt .= $key .' = ?, ';
                $params[] = $value;
            }
        }
        $rqt = substr($rqt,0,-2);
        $rqt .=" WHERE auto_s = ?;"; 
        $params[] = $idService;
        $stmt = mysqli_prepare($liaison,$rqt);
        $exe = mysqli_stmt_execute($stmt,$params);
        if($exe){
            $reponse['status'] = 200;
        }else{
            $reponse['status'] = 304;
        }
        echo(json_encode($reponse));
        break;
    
    case 'postData':
        // AJOUT EN BD du service de type 3 (= internet)
        $rqt = "INSERT INTO services(description,name,auto_ts,auto_c,isArchive) VALUES ('Accès Internet','$frsSelected',3,'$clientId',0);";
        $flux = mysqli_query($liaison, $rqt);

        // Récupération de l'id créé par l'INSERT juste au dessus
        $lastID = mysqli_insert_id($liaison);

        // Récuperation de toutes les infos du formulaire
        $typeLien = $_POST['typeLien'];
        $souscrisSNS = $_POST['isSNSSub'];
        $typeOffre = $_POST['typeOffre'];
        $typeAccesSelected = $_POST['typeAccesSelected'];
        $offre = $_POST['offre'];
        $refFournisseurLien = $_POST['refFournisseurLien'];
        $numSupport = $_POST['numSupport'];
        $isGTR = $_POST['isGTR'];
        $GTRText = $_POST['gtrTexte'];
        $isIP = $_POST['isIPFixe'];
        $ipFixe = $_POST['IPFixe'];
        $authLien = $_POST['authLien'];
        $infoAuth = $_POST['infoAuth'];
        $localisation = $_POST['localisation'];
        $dateSouscription = $_POST['dateSouscription'];
        $equipementArrive = $_POST['equipementArrive'];
        if($equipementArrive == 'SIM'){
            $equipementArrive .= ' '.$_POST['simArrive'];
        }
        $equipementAuth = $_POST['equipementAuth'];
        $ascendnantRsx = $_POST['ascendantRsx'];
        $params = [$lastID,$typeLien,$souscrisSNS,$frsSelected,$typeOffre,$typeAccesSelected,$offre,$refFournisseurLien,$numSupport,$isGTR,$GTRText,$isIP,$ipFixe,$authLien,$infoAuth,$dateSouscription,$equipementArrive,$equipementAuth,$ascendnantRsx,$localisation];

        // Ajout en BD du service informatique
        $rqt = "INSERT INTO service_informatique VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($liaison,$rqt);  
        $exe = mysqli_stmt_execute($stmt,$params);
        $reponse = array();
        if($exe){
            $reponse['status'] = 200;
        } else {
            $reponse['status'] = 304;
        }
        echo(json_encode($reponse));
    default:
        # code...
        break;
}