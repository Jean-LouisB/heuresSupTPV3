<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">


<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>


<?php
//Défini le niveau d'autorisatrion 1 = Salarié, 2=Rresponsable de service, 3 = Administrateur
//ces trois lignes permettent de connaitre la page courrante et de mettre le menu correspondant en surbrillance
$page = $_SERVER['REQUEST_URI']; 
$page1 = explode('/',$page);
$currantPage = end($page1);
if (!isset($_SESSION['Matricule'])){ // si la session n'est pas ouverte :
}else{//si la session est ouverte :
//Ces lignes suivantes récupèrent le matricule de l'utilisateur connecté et regarde ses droits (champ "niveau" dans la bdd)
$Matricule = $_SESSION['Matricule'];
$userConnect = getUserConnect($Matricule, $pdo);
$niveauUserConnecte = $userConnect[0]['Type'];
$prenomUserConnecte = $userConnect[0]['Prenom'];
$nomUserConnecte = $userConnect[0]['Nom'];
?>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
<li class="nav-item">
<a class="nav-link" href="actions/logout.php">Deconnexion</a>
</li>
<li class="nav-item <?php if ($currantPage=="accueil.php"){echo 'active';}?>"> <!--si c'est la page courrante, alors le menu est en surbrillance $currantePage est définie au début de la page-->
<a class="nav-link" href="accueil.php">Accueil</a>
</li>
<li class="nav-item <?php if ($currantPage=="enregistre.php"){echo 'active';}?>"><!--si c'est la page courrante, alors le menu est en surbrillance $currantePage est définie au début de la page-->
<a class="nav-link" href="enregistre.php">Déclarer</a>
</li>
<li class="nav-item <?php if ($currantPage=="cloture.php"){echo 'active';}?>"><!--si c'est la page courrante, alors le menu est en surbrillance $currantePage est définie au début de la page-->
<a class="nav-link" href="cloture.php">Cloturer ma semaine</a>
</li>
<?php
if ($niveauUserConnecte > 1) {//affiche cette partie si l'utilisateur est responsable
?>
                    <li class="nav-item <?php if ($currantPage=="validationresp.php"){echo 'active';}?>"><!--si c'est la page courrante, alors le menu est en surbrillance $currantePage est définie au début de la page-->
                    <a class="nav-link" href="validationresp.php">Valider les heures</a>
                    </li>

<?php
}
?>
<?php
if ($niveauUserConnecte > 2){//affiche cette partie si l'utilisateur est administrateur
?>
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Administrateur</a>
    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
      <li><a class="nav-link" style="color: blue" href="adminDetailheures.php">Détail</a></li>
      <li><a class="nav-link" style="color: blue" href="adminDetailHeuresSem.php">Détail Semaine</a></li>
      <li><a class="nav-link" style="color: blue" href="adminApercu.php">Aperçu de la semaine</a></li>
      <li><a class="nav-link" style="color: blue" href="adminApayer.php">A payer</a></li>
      <li><hr class="dropdown-divider">Paramètres :</li>
      <li><a class="nav-link" style="color: blue" href="adminDefiniBornes.php">Dates</a></li>
      <li><a class="nav-link" style="color: blue" href="export.php">Exports</a></li>
      <li><a class="nav-link" style="color: blue" href="adminptitvieux.php">RAZ J.S.</a></li>
      <li><hr class="dropdown-divider">Utilisateurs :</li>
      <li><a class="nav-link" style="color: blue" href="userList.php">Gestion</a></li>
      <li><a class="nav-link" style="color: blue" href="userAdd.php">Ajouter</a></li>
    </ul>
</li>

<?php
}
?>
<li class="nav-item <?php if ($currantPage=="updatemdp.php"){echo 'active';}?>"><!--si c'est la page courrante, alors le menu est en surbrillance $currantePage est définie au début de la page-->
<a class="nav-link" href="updatemdp.php">Mot de passe</a>
</li>

<?php
        if ($niveauUserConnecte == 3){

        $tabHeuresAPayer = getAPayer($pdo);
        $nbHeureAPayer = count($tabHeuresAPayer);
            if ($nbHeureAPayer>0){


}//ferme de if de l'alerte
}//ferme le if qui valide le niveau de droit pour l'alerte
?>
</div>

<?php
}// ferme la condition ouverte au début du menu qui valide si la session est ouverte
//affichage dans la barre de navigation du nom de l'utilisateur, ou de la mention "connectez-vous"
if(!isset($_SESSION['Matricule'])){
?>
  <p style="color: #343a40">Connectez-vous</p>
<?php
}else {
?>
<p style="color: #343a40"><?= "Bonjour ".($prenomUserConnecte)." ".($nomUserConnecte)." ".$nomSession;?></p>

<?php
}//ferme le else précédent
?>
</nav>