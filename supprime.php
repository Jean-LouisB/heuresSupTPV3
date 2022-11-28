<?php
$titre="Supprimer une heure";//La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php');//contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){//vérifie si l'utilisateur est connecté
  header('location:index.php');
}

$idheureasupprimer = $_GET['id'];

if (isset($_POST['ouiValide'])){
    $idheureasupprimer = $_GET['id'];
    $deleteHeure = supprimeHeure($idheureasupprimer,$pdo);
}

function supprimeHeure($idheureasupprimer,$pdo){
    $sql = "DELETE FROM semaineencours WHERE id = :idheureasupprimer";
    $params = ['idheureasupprimer' => $idheureasupprimer];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    header('location:cloture.php');

}
function detailHeureASupprimer($idheureasupprimer,$pdo){
    $sql = "SELECT * FROM semaineencours WHERE id = :idheureasupprimer";
    $params = ['idheureasupprimer'=>$idheureasupprimer];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;

}
?>
<body class="bodyperso">

<div class="containerperso">
    <H1 class="important">Vous allez supprimer définitivement cet événement :</H1>
    <?php
    $info = detailHeureASupprimer($idheureasupprimer,$pdo);
    ?>

<table class="tableperso">
    <thead>
        <tr>
            <th class="thperso">Titre</th>
            <th class="thperso">Détail</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tdperso">Date de l'événement</td>
            <td class="tdperso"><?php
                $d1=$info[0]['date_evenement'];
                $dateEvenement = strftime('%d-%m-%Y',strtotime($d1));
                echo $dateEvenement;
            ?></td>
        </tr>
        <tr>
            <td class="tdperso">Commentaire</td>
            <td class="tdperso"><?=$info[0]['commentaire'];?></td>
        </tr>
        <tr>
            <td class="tdperso">Durée</td>
            <td class="tdperso"><?=afficheHeureMinute($info[0]['temps']);?></td>
        </tr>
    </tbody>
</table>



        <H2 class="important">Pour confirmer la suppression définitive, écrivez "OUI" ci dessous et valider.</H2>
    <div class="containerpersoaligne">
        <form action="supprime.php?id=<?=$idheureasupprimer;?>" method="post">
            <div class="containerpersocourt">
            <input type="text" class="inputDivers" name="ouiValide">
            </div>
            <div class="containerpersocourt">
            <button type="submit" class="buttondanger">Supprimer l'événement</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>