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
$newHR = $_POST['recup'];
$newHS = $_POST['hsupp'];
$newJS = $_POST['JS'];
$newCommentaire = $_POST['comment']." || Enregistrement Modifié le ".$maintenant." à ".$maintenantH;



        function modifieEntree($newDate,$newHR,$newHS,$newJS,$newCommentaire,$idheure,$pdo){
                $sql ="UPDATE stock_hs set Date = :date, Recup = :newHR, HS_Maj = :newHS, JS = :newJS, Commentaire = :newCommentaire 
                WHERE ID_enr = :idheure";
                $params=['date'=> $newDate,'newHR'=>$newHR,'newHS'=>$newHS,'newJS'=>$newJS,'newCommentaire'=>$newCommentaire,'idheure' => $idheure];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $result = $stmt->fetchall(PDO :: FETCH_ASSOC);
        
        }

        $modifieHeure = modifieEntree($newDate,$newHR,$newHS,$newJS,$newCommentaire,$idheure,$pdo);
        header('location:accueil.php');

}

?>

<body class="bodyperso">
<div class="container">


        <form action="modifieheure.php" method="post">
                        <div class="form-group">

                            <div class="containerperso">   
                          
                            <input type="hidden" class="form-control" name="idheure" id="idheure" value="<?=$heureACorriger[0]['ID_enr']?>">
                            </div>


                            <div class="containerperso">   
                            <label for="dateenregistree">Date :</label>
                            <input required type="date" class="form-control" name="date" id="dateenregistree" value="<?=$heureACorriger[0]['Date']?>">
                            </div>
                           
                            <div class="containerperso">
                            <label for="recup">Contingent de récupération (1 pou 1) :</label>
                            <p style="font-size:0.8em;"><i>valeur inscrite en décimale : 15mn = 0,25 | 30mn = 0,50 | 45mn = 0,75.</i></p>
                            <input required type="number" class="form-control" step="0.25" name="recup" id="recup" value="<?=$heureACorriger[0]['Recup']?>">
                            </div>
                            
                            <div class="containerperso">
                            <label for="JS">Contingent d'heures supplémentaires :</label>
                            <p style="font-size:0.8em;"><i>valeur inscrite en décimale : 15mn = 0,25 | 30mn = 0,50 | 45mn = 0,75. Ne les majorez pas.</i></p>
                            <input required type="number" class="form-control"step="0.25" name="hsupp" id="hsupp" value="<?=$heureACorriger[0]['HS_Maj']/1.25?>">
                            </div>
                            <div class="containerperso">
                            <label for="hsupp">Journée de solidarité :</label>
                            <input required type="number" class="form-control" step="0.25"name="JS" id="JS" value="<?=$heureACorriger[0]['JS']?>">
                            </div>
                            <div class="containerperso">
                            <label for="comment">Commentaire (yc tranche horaire)</label>
                            <input required type="text" class="form-control" name="comment" id="comment" value="<?=$heureACorriger[0]['Commentaire']?>">
                            </div>
                            <div class="containerperso">
                            <button class="btn btn-danger" type="submit">MODIFIER</button>
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