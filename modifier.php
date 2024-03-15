<?php
if (!isset($_POST["id_modifier"])){
    header("Location: index.php");
}
session_start();
if ($_POST["token"]!=$_SESSION["token"]){
    die("Meurs vilain pirate");
}
include "header.php";
include "config.php";

$id_modifier=filter_input(INPUT_POST, "id_modifier", FILTER_SANITIZE_STRING);

$pdo = new PDO("mysql:host=" . Config::SERVEUR . ";dbname=" . Config::BASEDEDONNEES,
    Config::UTILISATEUR, Config::MOTDEPASSE);

$requete2 = $pdo->prepare("SELECT * FROM peluche WHERE id=:id");
$requete2->bindParam(":id", $id_modifier);
$requete2->execute();
$peluches2 = $requete2->fetchAll();
?>
<form action="modifierPeluche.php" method="post">
    <input type="hidden" name="id" value="<?php echo $peluches2[0]['id']?>">
    <label for="titre">Titre</label>
    <input type="text" name="titre" maxlength="50"
           placeholder="titre" required value="<?php echo $peluches2[0]["titre"]; ?>">
    <label for="description">Description</label>
    <input type="text" name="description"
           placeholder="description" required value="<?php echo $peluches2[0]["description"]; ?>">
    <label for="couleur">Couleur</label>
    <input type="text" name="couleur" maxlength="20"
           placeholder="couleur" required value="<?php echo $peluches2[0]["couleur"]; ?>">
    <label for="matiere">Matière</label>
    <input type="text" name="matiere" maxlength="50"
           placeholder="matière" required value="<?php echo $peluches2[0]["matiere"]; ?>">
    <label for="risque_allergie">Risque allergie</label>
    <input type="checkbox" name="risque_allergie"
           value="<?php echo $peluches2[0]["risque_allergie"]; ?>" >
    <label for="dimensions">Dimensions</label>
    <input type="text" name="dimensions"
           placeholder="dimensions" required value="<?php echo $peluches2[0]["dimensions"]; ?>">
    <label for="poids">Poids</label>
    <input type="number" name="poids"
           placeholder="poids" required value="<?php echo $peluches2[0]["poids"]; ?>">
    <label for="code_barre">Code barre</label>
    <input type="text" name="code_barre" maxlength="13"
           placeholder="code barre" required value="<?php echo $peluches2[0]["code_barre"]; ?>">
    <input type="submit" value="modifier">
</form>
<?php
include "footer.php";