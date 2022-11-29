<?php
$titre="Enregistrez vos heures"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){
    header('location:index.php');
}
//récupère les dates et les mets en forme française (jours/mois/année)

$DateDebut = $borne1;
$DateFin = $borne2;
$bornes = $borne1." au ".$borne2;
?>

<body class="bodyperso" onload="">
<?php

if (isset($_POST['matricule'])){
                   
                    $matricule = $_POST['matricule'];
                    $dateEvenement = $_POST['dateEvenement'];
                    $commentaire = "De ". $_POST['heureDebut'] ." à ".$_POST['heureFin']." | ".$_POST['commentaire'];
                /* Calcule les heures en décimale  */
                    $tabHeureDebut = explode(':',$_POST['heureDebut']);
                    $tabHeureFin = explode(':',$_POST['heureFin']);
                    $heureDebutDecimale = $tabHeureDebut[0]+($tabHeureDebut[1]/60);
                    $heureFinDecimale = $tabHeureFin[0]+($tabHeureFin[1]/60);
                        if ($_POST['sens']==1){
                            $dureeEvenement = $heureFinDecimale - $heureDebutDecimale;


                        }else{
                            $dureeEvenement = -($heureFinDecimale - $heureDebutDecimale);
                        }
                                          
                $ajoute = addHeureV3($bornes,$matricule,$dateEvenement,$dureeEvenement,$commentaire,$pdo);
echo "<div class='containerpersocourt'><p class='valideOK'>Evénement du ".$dateEvenement." enregistré. </p></div>";
}


?>

<div class="containerperso">
<H3>Semaine du <?=$bornes;?></H3>
<p>Utiliser la touche "TABULATION" pour naviguer et valider vos réponses.</p>
<form action="enregistre.php" method="post">
        
        <input type="text" class="inputInformation" id="matricule" name="matricule" readonly value="<?=$_SESSION['Matricule'];?>">
        <br>
        
        <label for="date" class="labelForm-perso disparait" id="labeldate">Quelle est la date de l'évènement ?</label>
        <input type="date" class="form-control-perso disparait"  name="dateEvenement" id="dateEvenement"  min="<?=$tabDate[0]['datedebut'];?>" max="<?=$tabDate[0]['datefin'];?>" required onblur="addClassApresDate()">
        
        <label for="heuredebut" class="labelForm-perso disparait" id="labelHeureDebut">Quelle est l'heure de début :</label>
        <input type="time" class="form-control-perso disparait"  name="heureDebut" id="heureDebut" step="900" onblur="addClassApresHeureDebut()">
        
        <label for="heurefin" class="labelForm-perso disparait" id="labelHeureFin">Quelle est l'heure de fin :</label>
        <input type="time" class="form-control-perso disparait"  name="heureFin" id="heureFin" step="900" onblur="addClassApresHeureFin()">
        
        <select  aria-label="Default select example" class="form-select-perso disparait" id="sens" name="sens" required onblur="addClassApresSens()">
                    <option selected>En plus ou en moins ?</option>
                    <option value="1">En plus</option>
                    <option value="2">En moins</option>
        </select> 
        
        <label for="commentaire" class="labelForm-perso disparait" id="labelCommentaire">Justification :</label>
        <input type="text" class="form-control-perso disparait"  name="commentaire" id="commentaire" required onblur="addClassTerminer()">
       
        <button class="bouttonValider masqueObjet" type="submit" id="bouttonValider">VALIDER</button>
    </form>

</div>
 
<script type="text/javaScript">

        /*Temporise l'apparission de la première étiquette (date) */
            var tempo = setTimeout(addClass, 200);

                                    
                                    function addClass(){
                                        let element = (document.getElementById("labeldate"));
                                        element.classList.add("apparait");
                                        console.log("Voila le premier");
                    
                                    }

        /*Temporise l'apparission du premier input (date) */
                                    
            var tempo1 = setTimeout(addClass2, 1000);

                                    
                                    function addClass2(){
                                        let element = (document.getElementById("dateEvenement"));
                                        element.classList.add("apparait");
                                        console.log("Voila le second");

                                      }
        /*Fonction pour l'apparition de chaque élément après la validation du précédent */
                                      function addClassApresDate(){
                                        let element1 = (document.getElementById("labelHeureDebut"));
                                        let element = (document.getElementById("heureDebut"));
                                        element1.classList.add("apparait");
                                        element.classList.add("apparait");
                                        console.log("Voila le troisième");

                                      }
                                      function addClassApresHeureDebut(){
                                        let element1 = (document.getElementById("labelHeureFin"));
                                        let element = (document.getElementById("heureFin"));
                                        element1.classList.add("apparait");
                                        element.classList.add("apparait");
                                        console.log("Voila le 4iem");

                                      }

                                      function addClassApresHeureFin(){
                                        let element = (document.getElementById("sens"));
                                        element.classList.add("apparait");
                                        console.log("Voila le 5iem");

                                      }

                                      function addClassApresSens(){
                                        let element = (document.getElementById("labelCommentaire"));
                                        let element1 = (document.getElementById("commentaire"));
                                        element.classList.add("apparait");
                                        element1.classList.add("apparait");
                                        console.log("Voila le 6iem");

                                      }

                                      function addClassTerminer(){
                                        let element = (document.getElementById("bouttonValider"));
                                        element.classList.add("afficheObjet");
                                        console.log("Voila la fin");

                                      }





</script>
    
</body>



<footer>
    <?php
    include('includes/footer.php')
    ?>
</footer>
</html>