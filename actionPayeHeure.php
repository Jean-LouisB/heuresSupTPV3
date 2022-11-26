<?php
$titre = "Paye";
include ('includes/AllIncludes.php');

$idligne = $_GET['id'];


function payeHeure($idligne,$date_Sys,$pdo){

    $sql = "UPDATE stock_hs 
    set Payee = 1 ,DatePaye=:dateSys
    where ID_enr = :idligne";
$stmt = $pdo->prepare($sql);
$params=['idligne'=>$idligne,'dateSys'=>$date_Sys];
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $result;

}

$paye = payeHeure($idligne,$date_Sys,$pdo);
header('location:adminApayer.php');

?>