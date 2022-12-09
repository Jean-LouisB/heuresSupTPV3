<?php
$titre="Modifier une entrée"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include ('includes/AllIncludes.php');

if(!isset($_SESSION['Matricule'])){
  header('Location: accueil.php');
}

if (!isset($_GET['id'])){
        header('location:adminDetailheures.php');
}
$idheure = $_GET['id'];
$heureACorriger = getHeureArchive($idheure,$pdo);

date_default_timezone_set('Europe/Paris');
$maintenant = date("d/m/Y");
$maintenantH = date("H:i");

if (count($_POST)>0){

        $idheure =  $_POST['idheure'];
        $newDate = $_POST['date'];
        $newHR = $_POST['recup'];
        $newHS = $_POST['hsupp'];
        $newJS = $_POST['JS'];
        $newhap = $_POST['hap'];
        $newCommentaire = $_POST['comment']." || Enregistrement Modifié le ".$maintenant." à ".$maintenantH;

                function modifieEntree($newDate,$newHR,$newHS,$newJS,$newCommentaire,$idheure,$newhap,$pdo){
                        $sql ="UPDATE stock_hs set Date = :date, Recup = :newHR, HS_Maj = :newHS, JS = :newJS, heureAPayer = :newhap, Commentaire = :newCommentaire
                        WHERE ID_enr = :idheure";
                        $params=['date'=> $newDate,'newHR'=>$newHR,'newHS'=>$newHS,'newJS'=>$newJS,'newCommentaire'=>$newCommentaire,'idheure' => $idheure, 'newhap' => $newhap];
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($params);
                        $result = $stmt->fetchall(PDO :: FETCH_ASSOC);

                                
                }

        $modifieHeure = modifieEntree($newDate,$newHR,$newHS,$newJS,$newCommentaire,$idheure,$newhap,$pdo);
        
}

?>

<body class="bodyperso">
<div class="container">


        <form action="modifieheurearchive.php" method="post">
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
                            <input required type="number" class="form-control"  name="recup" id="recup" value="<?=$heureACorriger[0]['Recup']?>">
                            </div>
                            
                            <div class="containerperso">
                            <label for="JS">Contingent d'heures supplémentaires :</label>
                            <p style="font-size:0.8em;"><i>valeur inscrite en décimale : 15mn = 0,25 | 30mn = 0,50 | 45mn = 0,75. Ne les majorez pas.</i></p>
                            <input required type="number" class="form-control" name="hsupp" id="hsupp" value="<?=$heureACorriger[0]['HS_Maj']?>">
                            </div>
                            <div class="containerperso">
                            <label for="hsupp">Journée de solidarité :</label>
                            <input required type="number" class="form-control" name="JS" id="JS" value="<?=$heureACorriger[0]['JS']?>">
                            </div>
                            <div class="containerperso">
                            <label for="hsupp">Heure à payer :</label>
                            <input required type="number" class="form-control" name="hap" id="hap" value="<?=$heureACorriger[0]['heureAPayer']?>">
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