<?php
$titre = "Paye de l'heure par responsable";
include('includes/AllIncludes.php'); //contient tous les includes necessaires

$idligne = $_GET['id'];
$datev = date('Y/m/d');
$valideok = payeHeures($idligne,$datev,$pdo);

function payeHeures($idligne,$datev,$pdo){
        $sql = "UPDATE stock_hs set APayer = 1, Validation_Resp = 1, DateValidation = :datev WHERE ID_enr = :idligne";
        $stmt = $pdo->prepare($sql);
        $params = ['datev' => $datev, 'idligne' => $idligne];
        $stmt->execute($params);
        $result = $stmt->execute($params);
        return $result;
       
 
}
header('Location: validationresp.php');

?>
</html>
