<?php

//connection à la base de données :

//session locale:

 session_start();
$dsn='mysql:host=localhost;dbname=heurestp';
$user='root';
$pass='';
$nomSession ="Session locale";
$pdo = new \PDO($dsn, $user, $pass);
$pdo->exec("SET CHARACTER SET utf8");
setlocale(LC_TIME, "FR_fr");

//session distante
/*
session_start();
$dsn='mysql:host=fabrickopf.mysql.db;dbname=fabrickopf';
$user='fabrickopf';
$pass='Ar17xaxMna';
$pdo = new \PDO($dsn, $user, $pass);
$pdo->exec("SET CHARACTER SET utf8");
$nomSession ="";
*/

$date_Sys = date('Y-m-d');


?>


<!-- cette partie ouvre la balise html pour toutes les pages et sert de "head" à tous. -->

<!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex"> <!--refuse le passage des robots-->

  <!-- Bootstrap CSS -->
  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
-->
  <!--lien local pour CSS :-->
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/styleperso.css">
  <link rel="stylesheet" href="css/styleperso22.css">
  <link rel="icon" href="images/favicon.png">
  <title><?=$titre;?></title> <!--Le titre de chaque page est défini dans chacune par la variable $titre--> 
  <!--Liens locaux pour le JS:-->
  <script src="js/jsquery.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  
  
  



</head>