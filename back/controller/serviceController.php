<?php
if(!$included) exit;

if(isset($_POST['action'])) $action = $_POST['action']; else $action = '';
if (isset($_POST['idService'])){ 
    $idService = sanitizeData($_POST['idService']);
}else{
    $idService ='';
}

isset($_POST['token']) ? $token = $_POST['token'] : $token = ''; 
switch ($action) {
    case 'putStoreToArchive':
        $rqt = " UPDATE services
        SET isArchive = 1
        WHERE auto_s = $idService";
        $query = mysqli_query($liaison,$rqt);
        if ($query) {
            $reponse['status'] = 200;
        } else {
            $reponse['status'] = 304;
        }
        break;
    
    case 'putRestoreFromArchive':
        $rqt = " UPDATE services
        SET isArchive = 0
        WHERE auto_s = $idService";
        $query = mysqli_query($liaison,$rqt);
        if ($query) {
            $reponse['status'] = 200;
        } else {
            $reponse['status'] = 304;
        }
        break;

    case 'putSetInUse':
        $params = array();
        if(isset($token)){
            $clearToken = decodeToken($token);
            // $NomConsultant = $clearToken[0]['NomConsultant'];
            // $PnomConsultant = $clearToken[0]['PrenomConsultant'];
            // $rqt2 = "UPDATE services
            // SET nomEditeur = $NomConsultant,PnomEditeur = $PnomConsultant";
            // $exe2 = mysqli_query($liaison,$rqt2);
        }   
        $rqt = 'UPDATE services 
        SET isInEdit = 1, 
        nomEditeur = ?,
        PnomEditeur = ?
        WHERE auto_s = ?';
        $params = [$clearToken[0]['NomConsultant'],$clearToken[0]['PrenomConsultant'],$idService];
        $stmt = mysqli_prepare($liaison,$rqt);
        $exe = mysqli_stmt_execute($stmt,$params);


        if($exe){
            $reponse['status'] = 200;
        }else{ 
            $reponse['status'] = 304;
        }
        break;
    
    case 'getConsolutantModif':
        $rqt = "SELECT nomEditeur,PnomEditeur
        FROM services
        WHERE auto_s = $idService";
        $flux = mysqli_query($liaison,$rqt);
        while ($ligne = mysqli_fetch_assoc($flux)) {
            $reponse['data'][] = $ligne;
        }
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        break;

    
    case 'putUnsetIsInUse':
        $params = array();
        $rqt = "UPDATE services 
        SET isInEdit = 0,
        nomEditeur = '',
        PnomEditeur = ''
        WHERE auto_s = ?";
        $params = [$idService];
        $stmt = mysqli_prepare($liaison,$rqt);
        $exe = mysqli_stmt_execute($stmt,$params);
        // $rqt2 = "UPDATE services
        // SET nomEditeur = '',PnomEditeur = ''";
        // $exe2 = mysqli_query($liaison,$rqt2);
        if($exe){
            $reponse['status'] = 200;
        }else{ 
            $reponse['status'] = 304;
        }
        break;
        
    case 'getIsInUse':
        $rqt = "SELECT isInEdit 
        FROM services
        WHERE auto_s = $idService";
        $flux = mysqli_query($liaison,$rqt);
        $ligne = mysqli_fetch_assoc($flux);
        $reponse['data'][]=$ligne;
        if(!$flux){
            $reponse['status'] = 400;
        }else{
            $reponse['status'] = 200;
        }
        // echo json_encode($reponse);
        break;

        
    default:
        $reponse['status'] = 404;
        break;
}

echo json_encode($reponse);
mysqli_close($liaison);