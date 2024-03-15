<?php
if (!isset($_POST["titre"])){
    header("Location: index.php");
}
session_start();
if ($_POST["token"]!=$_SESSION["token"]) {
    die("Meurs vilain pirate");
}
$titre=filter_input(INPUT_POST, "titre", FILTER_SANITIZE_STRING);
$description=filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$couleur=filter_input(INPUT_POST, "couleur", FILTER_SANITIZE_STRING);
$matiere=filter_input(INPUT_POST, "matiere", FILTER_SANITIZE_STRING);
$risque_allergie = isset($_POST["risque_allergie"]) ? 1 : 0;
$dimensions=filter_input(INPUT_POST, "dimensions", FILTER_SANITIZE_STRING);
$poids=filter_input(INPUT_POST, "poids", FILTER_SANITIZE_STRING);
$code_barre=filter_input(INPUT_POST, "code_barre", FILTER_SANITIZE_STRING);

include "config.php";

$pdo=new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES,
    Config::UTILISATEUR,Config::MOTDEPASSE);

$requete=$pdo->prepare("INSERT INTO peluche(titre, description, couleur, matiere, risque_allergie, dimensions, poids, code_barre)
                                VALUES (:titre, :description, :couleur, :matiere, :risque_allergie, :dimensions, :poids, :code_barre)");

$requete->bindParam(":titre", $titre);
$requete->bindParam(":description", $description);
$requete->bindParam(":couleur", $couleur);
$requete->bindParam(":matiere", $matiere);
$requete->bindParam(":risque_allergie", $risque_allergie);
$requete->bindParam(":dimensions", $dimensions);
$requete->bindParam(":poids", $poids);
$requete->bindParam(":code_barre", $code_barre);

$requete->execute();

header("Location: index.php");