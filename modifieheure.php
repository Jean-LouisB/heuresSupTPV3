<?php
$titre="Modifier une entrée"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){
        header('location:index.php');
}


$idheure = $_GET['id'];
$heureACorriger = getHeure($idheure,$pdo);

date_default_timezone_set('Europe/Paris');
$maintenant = date("d/m/Y");
$maintenantH = date("H:i");


if (count($_POST)>0){

$idheure =  $_POST['idheure'];       
$newDate = $_POST['date'];
$duree = $_POST['duree'];
$newCommentaire = $_POST['comment']." || Enregistrement Modifié le ".$maintenant." à ".$maintenantH;



        function modifieEntree($newDate,$duree,$newCommentaire,$idheure,$pdo){
                $sql ="UPDATE semaineencours set date_evenement = :newDate,temps = :duree, commentaire = :newCommentaire 
                WHERE id = :idheure";
                $params=['newDate'=> $newDate,'duree'=>$duree,'newCommentaire'=>$newCommentaire,'idheure' => $idheure];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $result = $stmt->fetchall(PDO :: FETCH_ASSOC);
        
        }

        $modifieHeure = modifieEntree($newDate,$duree,$newCommentaire,$idheure,$pdo);
        header('location:cloture.php');

}

?>

<body class="bodyperso">
<div class="containerpersocourt">


        <form action="modifieheure.php" method="post">
                        <div class="form-group">

                            <div class="containerperso">   
                          
                            <input type="hidden" class="form-control" name="idheure" id="idheure" value="<?=$heureACorriger[0]['id']?>">
                            </div>


                            <div class="containerperso">   
                            <label for="dateenregistree">Date :</label>
                            <input required type="date" class="form-control" name="date" id="dateenregistree" value="<?=$heureACorriger[0]['date_evenement']?>">
                            </div>                           
                            <div class="containerperso">
                            <label for="recup">Durée :</label>
                            <p style="font-size:0.8em;"><i>valeur inscrite en décimale : 15mn = 0,25 | 30mn = 0,50 | 45mn = 0,75.</i></p>
                            <input required type="number" class="form-control" step="0.25" name="duree" id="duree" value="<?=$heureACorriger[0]['temps']?>">
                            </div>
                            <div class="containerperso">
                            <label for="comment">Commentaire (yc tranche horaire)</label>
                            <input required type="text" class="form-control" name="comment" id="comment" value="<?=$heureACorriger[0]['commentaire']?>">
                            </div>
                            <div class="containerperso">
                            <button class="buttonnormal" type="submit">MODIFIER</button>
                            </div>

                            
                            
                           

        </form>
</div>

</body>
<footer>
    <?php
    include('includes/footer.php')
    ?>
</footer>
</html>