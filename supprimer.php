<?php
if (!isset($_POST["id_supprimer"])){
    header("Location: index.php");
}
session_start();
if ($_POST["token"]!=$_SESSION["token"]){
    die("Meurs vilain pirate");
}

$id=filter_input(INPUT_POST, "id_supprimer", FILTER_SANITIZE_STRING);

include "config.php";

$pdo = new PDO("mysql:host=" . Config::SERVEUR . ";dbname=" . Config::BASEDEDONNEES,
    Config::UTILISATEUR, Config::MOTDEPASSE);

$requete=$pdo->prepare("DELETE FROM peluche WHERE id=:id");

$requete->bindParam(":id", $id);

$requete->execute();

header("Location: index.php");
