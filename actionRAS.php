<?php

$titre = "RAS";
include ('includes/AllIncludes.php');



if(!isset($_SESSION['Matricule'])){
  header('Location: index.php');
}

$prenom = getUserConnect ($_SESSION['Matricule'],$pdo);
$Matricule = $_SESSION['Matricule'];
$date_Sys = date('Y/m/d');
$date_enr = $tabDate[0]['datefin'];
$commentaire = "R.A.S. pour la semaine du ".$borne1." au ".$borne2.".";
$ras = rasSemaine($date_enr,$Matricule,$commentaire,$date_Sys,$pdo);

function rasSemaine($date_enr,$Matricule,$commentaire,$date_Sys,$pdo){
    $sql = "INSERT INTO stock_hs (Date, Matricule, JS, Recup, HS_Maj, Commentaire, Date_sys, APayer, Payee) 
    VALUES (:date_enr, :matricule, 0, 0, 0, :Commentaire, :Date_sys, 0 , 0)";
    $stmt = $pdo->prepare($sql);
    $params =['date_enr' => $date_enr, 'matricule' => $Matricule,'Commentaire' => $commentaire, 'Date_sys' => $date_Sys];
    $result = $stmt->execute($params);
    return $result;


}

header('location:accueil.php');


?>