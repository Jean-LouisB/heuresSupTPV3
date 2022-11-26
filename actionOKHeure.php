<?php
$titre = "Validation de l'heure par responsable";
include('includes/AllIncludes.php'); //contient tous les includes necessaires

$idligne = $_GET['id'];
$matricule = $_GET['matricule'];
$datev = date('Y/m/d');
$valideok = ValideHeures($idligne,$datev,$pdo);
$archiveok = archiveDetailSemaine($matricule,$pdo);

function ValideHeures($idligne,$datev,$pdo){
        $sql = "UPDATE stock_hs set Validation_Resp = 1, DateValidation = :datev WHERE ID_enr = :idligne";
        $stmt = $pdo->prepare($sql);
        $params = ['datev' => $datev, 'idligne' => $idligne];
        $stmt->execute($params);
        $result = $stmt->execute($params);
        return $result;
       
 
}

function archiveDetailSemaine($matricule,$pdo){
        $sql = "UPDATE semaineencours set valide = 1 WHERE valide = 2 and matricules = :matricule";
        $stmt = $pdo->prepare($sql);
        $params = ['matricule' => $matricule];
        $stmt->execute($params);
        $result = $stmt->execute($params);
        return $result;
}


header('Location: validationresp.php');

?>
</html>


