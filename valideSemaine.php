<?php

$titre = "Valide la semaine du service";
include ('includes/AllIncludes.php');

if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}


$matricule = $_SESSION['Matricule'];

    $date1 = $tabDate[0]['datedebut'];
    $date2 = $tabDate[0]['datefin'];

$valideSemaine = valideSemaine($matricule,$date1,$date2,$pdo);


function valideSemaine($matricule,$date1,$date2,$pdo)
{

  $sql ="INSERT INTO validesemaine (matricule,date1,date2,valide) values (:matricule,:date1,:date2,1)";
  $stmt = $pdo->prepare($sql);
  $params=['matricule' => $matricule, 'date1'=> $date1, 'date2' => $date2];
  $stmt->execute($params);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;



}

header('location:accueil.php');
?>

</html>
