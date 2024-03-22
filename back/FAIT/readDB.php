<?php
include "./functions.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('Europe/Paris');
$liaison = CallDatabase();
// Verfier que le type existe
isset($_POST["type"]) ? $type = $_POST["type"] : $type = '';

$reponse = array();

// TESTS

// $type ='detailsServices';
// $_POST['clientId'] = 1;
// $_POST['serviceId'] = 17;
// $_POST['clientId'] = 'ddd10';
// echo sanitizeData($_POST['clientId']);

// FIN TESTS

switch ($type) {
    // case 'clients':
    //     //Afficher clients
    //     $rqt = "SELECT auto_c AS clientId, name AS clientName 
    //     FROM clients";
    //     $flux = mysqli_query($liaison, $rqt);
    //     while ($ligne = mysqli_fetch_assoc($flux)) {
    //         $reponse['data'][] = $ligne;
    //     }
    //     if(!$flux){
    //         $reponse['status'] = 400;
    //     }else{
    //         $reponse['status'] = 200;
    //     }
    //     echo json_encode($reponse);
    //     break;

    case 'typeOption':
        $rqt = "SELECT name,auto_ts 
        FROM type_service
        ORDER BY name";
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

    // case 'nomCli':
    //     isset($_POST['clientId']) ? $clientId = sanitizeData($_POST['clientId']) : $clientId = '';
    //     $rqt = "SELECT name FROM clients WHERE auto_c= $clientId";
    //     $flux = mysqli_query($liaison, $rqt);
    //     $nomCli = mysqli_fetch_assoc($flux);
    //     echo json_encode($nomCli);
    //     break;

// PAS UTILE //
    case 'detailsServices':
        isset($_POST['clientId']) ? $clientId = sanitizeData($_POST['clientId']) : $clientId = '';
            $rqt = "SELECT auto_s AS serviceId, S.name AS serviceName,address,S.description AS serviceDescription,TS.name AS typeServiceName,version
            FROM services S
            INNER JOIN type_service TS
            ON TS.auto_ts = S.auto_ts
            WHERE S.auto_c = $clientId";
        $flux = mysqli_query($liaison, $rqt);
        while ($ligne = mysqli_fetch_assoc($flux)) {
            $reponse['data'][] = $ligne;
        }
        $rqt2 = " SELECT COUNT(*) AS nbServices FROM services S WHERE S.auto_c = $clientId";
        $flux2 = mysqli_query($liaison,$rqt2);
        $ligne = mysqli_fetch_assoc($flux2);
        $reponse['nbServices'] = $ligne['nbServices'];
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        echo json_encode($reponse);
        break;

// PAS UTILE //
    case 'detailsUser':
        if (isset($_POST['clientId']) && isset($_POST['serviceId'])) {
            $serviceId = sanitizeData($_POST['serviceId']);
            $clientId = sanitizeData($_POST['clientId']);
        }
        $rqt = "SELECT A.auto_u AS utilisateurID,lastName,firstName,id as userLogin,password 
        FROM compte_service CS
        INNER JOIN associer A
        ON A.auto_cs = CS.auto_cs
        INNER JOIN utilisateurs U
        ON U.auto_u = A.auto_u	
        INNER JOIN services S
        ON S.auto_s = CS.auto_s
        WHERE S.auto_s = $serviceId AND S.auto_c = $clientId";
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

// PAS UTILE // 
    case 'detailsLicence':
        if (isset($_POST['clientId']) && isset($_POST['serviceId'])) {
            $serviceId = sanitizeData($_POST['serviceId']);
            $clientId = sanitizeData($_POST['clientId']);
        }
        $rqt = "SELECT L.auto_l AS licenceId,type,cleLicence,buyDate,expirationDate
        FROM licences L 
        INNER JOIN services S
        ON S.auto_l = L.auto_l
        WHERE S.auto_s = $serviceId AND S.auto_c = $clientId";
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

// PAS UTILE   
    case 'detailsGestion':
        if (isset($_POST['clientId']) && isset($_POST['serviceId'])) {
            $serviceId = sanitizeData($_POST['serviceId']);
            $clientId = sanitizeData($_POST['clientId']);
        }
        $rqt = " SELECT GS.auto_gs AS idGestion, GS.address as adresseCompte, GS.description, login, password 
        FROM gestion_service GS 
        INNER JOIN services S
        ON S.auto_gs = GS.auto_gs 
        WHERE S.auto_s = $serviceId AND S.auto_c = $clientId;";
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

    // case 'AccesInternet':
    //     if (isset($_POST['idClient'])) {
    //         $clientId = $_POST['idClient'];
    //     }
    //     $rqt = "SELECT SI.auto_s,typeLien, souscrisSNS, fournisseur
    //     FROM service_informatique SI
    //     INNER JOIN services S
    //     ON SI.auto_s = S.auto_s
    //     WHERE auto_c = '$clientId'
    //     AND S.isArchive != 1";
    //     $flux = mysqli_query($liaison,$rqt);
    //     while ($ligne = mysqli_fetch_assoc($flux)) {
    //         if($ligne['souscrisSNS'] == 1){
    //             $ligne['souscrisSNS'] = 'OUI' ;    
    //         }else{
    //             $ligne['souscrisSNS'] = 'NON' ;    
    //         }
    //         $reponse['data'][] = $ligne;
    //     }
    //     if(!$flux){
    //         $reponse['status'] = 400;
    //     }else{
    //         $reponse['status'] = 200;
    //     }
    //     echo json_encode($reponse);
    //     break;
    
    // case 'AccesInternetDetails':
    //     if (isset($_POST['idClient']) && isset($_POST['idService'])) {
    //         $clientId = $_POST['idClient'];
    //         $idService = $_POST['idService'];
    //     }
    //     $rqt = "SELECT SI.auto_s AS ID, typeLien AS 'Type de lien', souscrisSNS AS 'Souscris SNS', fournisseur AS 'Fournisseur', typeOffre AS 'Type offre', typeAcces AS 'Type accès', offre AS 'Offre', refFournisseurLien AS 'Référence fournisseur Lien', numSupport AS ' Numéro support', GTR AS 'GTR_verif', gtrTexte AS 'GTR', ipFixe AS 'IP Fixe_verif' , ipFixeNum AS 'IP Fixe', typeAuthLien AS 'Type authentification lien', infoAuth as 'Info authentification', dateSouscription AS 'Date souscription', equipementArrivee AS 'Equipement d arrivée', equipementAuth AS 'Equipement authentification', ascendantRsx AS 'Ascendant Reseau', localisation AS 'Localisation'
    //     FROM service_informatique SI
    //     INNER JOIN services S
    //     ON S.auto_s = SI.auto_s
    //     WHERE S.auto_c = $clientId AND SI.auto_s = '$idService' ";
    //     $flux = mysqli_query($liaison,$rqt);
    //     while ($ligne = mysqli_fetch_assoc($flux)) {
    //         if($ligne['Souscris SNS'] == 1){
    //             $ligne['Souscris SNS'] = 'OUI' ;  
    //             unset($ligne['Type offre']);
    //         }else{
    //             $ligne['Souscris SNS'] = 'NON' ;
    //             unset($ligne['Offre']);    
    //         }
    //         $reponse['data'][] = $ligne;
    //     }
    //     if(!$flux){
    //         $reponse['status'] = 400;
    //     }else{
    //         $reponse['status'] = 200;
    //     }
    //     echo json_encode($reponse);
    //     break;
    
    // case 'getArchiveInternet':
    //     if (isset($_POST['idClient'])){
    //         $clientId = $_POST['idClient'];
    //     }
    //     $rqt= "SELECT SI.auto_s,typeLien, souscrisSNS, fournisseur
    //     FROM service_informatique SI
    //     INNER JOIN services S
    //     ON SI.auto_s = S.auto_s
    //     WHERE auto_c = '$clientId'
    //     AND S.isArchive != 0";
    //     $flux = mysqli_query($liaison,$rqt);
    //     while ($ligne = mysqli_fetch_assoc($flux)){
    //         if($ligne['souscrisSNS'] == 1){
    //             $ligne['souscrisSNS'] = 'OUI' ;    
    //         }else{
    //             $ligne['souscrisSNS'] = 'NON' ;    
    //         }
    //         $reponse['data'][] = $ligne;
    //     }
    //     if(!$flux){
    //         $reponse['status'] = 400;
    //     }else{
    //         $reponse['status'] = 200;
    //     }
    //     echo json_encode($reponse);
    //     break;

    // case 'getIsInUse':
    //     if (isset($_POST['idService'])){
    //         $idService = sanitizeData($_POST['idService']);
    //     }
    //     $rqt = "SELECT isInEdit 
    //     FROM services
    //     WHERE auto_s = $idService";
    //     $flux = mysqli_query($liaison,$rqt);
    //     $ligne = mysqli_fetch_assoc($flux);
    //     $reponse['data'][]=$ligne;
    //     if(!$flux){
    //         $reponse['status'] = 400;
    //     }else{
    //         $reponse['status'] = 200;
    //     }
    //     echo json_encode($reponse);
    //     break;
    default:
        # code..
        break;
}
mysqli_close($liaison);
