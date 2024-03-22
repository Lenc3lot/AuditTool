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
if (isset($_POST['frsSelected'])) $frsSelected = $_POST['frsSelected']; else $frsSelected = '';
if (isset($_POST['idClient'])) $clientId = $_POST['idClient']; else $clientId = '';

// AJOUT EN BD du service de type 3 (= internet)
$rqt = "INSERT INTO services(description,name,auto_ts,auto_c) VALUES ('Accès Internet','$frsSelected',3,'$clientId');";
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
$params = [$lastID,$typeLien,$souscrisSNS,$frsSelected,$typeOffre,$typeAccesSelected,$offre,$refFournisseurLien,$numSupport,$isGTR,$GTRText,$isIP,$ipFixe,$authLien,$infoAuth,$dateSouscription,$equipementArrive,$localisation,$equipementAuth,$ascendnantRsx];

// Ajout en BD du service informatique
$rqt = "INSERT INTO service_informatique VALUES('?','?',?,'?','?','?','?','?','?',?,'?',?,'?','?','?','?','?','?','?','?')";
$stmt = mysqli_prepare($liaison,$rqt);
$exe = mysqli_stmt_execute($stmt,$params);
$reponse = array();
if($exe){
    $reponse['status'] = 200;
} else {
    $reponse['status'] = 304;
}
echo(json_encode($reponse));