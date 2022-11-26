<?php

$titre="ptV"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/header.php'); //contient tous les includes necessaires
include('includes/function-pdo.php'); //contient tous les includes necessaires

if (isset($_POST['dateMAJ'])){

    
            $listeSalariePresent = getSalarie($pdo);
            $dateSysteme = $date_Sys;
            $dateRAZ = $_POST['dateMAJ'];



            for ($i=0 ; $i<count($listeSalariePresent);$i++){
                $id = $listeSalariePresent[$i]['Matricule'];
                $go = petitsVieux($id,$dateRAZ,$dateSysteme,$pdo);

}

}
?>
<body class="bodyperso">
    
             <H1>Remise à (-7) heures du compteur de la journée de solidarité.</H1>  
             <h3>- Une fois la date de la mise à jour renseignée (ex:01/01/2023), appuyez sur "VALIDER". <br>
             - Chacun des salariés présent aura son compteur décrémenté de 7 heures. <br>
             - Puis vous serez redirigés sur la <a href="adminApercu.php" target="_blank">page de détail</a> de chacun.</h3> 
    <div class = "containerperso">  
        <h4 style="color:red;">/!\ Aucun retour en arrière n'est possible.</h4>    
             <form action="adminptitvieux.php" method="post">

                <Label>Date de mise à jour</Label>
                <input type="date" name="dateMAJ" id="dateMAJ" required>
                <button type="submit" class="btn btn-danger">VALIDER</button>
            </form>
    </div>

    <p>ex : Un salarié dont le solde est de -2h30 avant la mise à jour, aura un compteur à 9h30 après la mise à jour.</p>
</body>

</html>

