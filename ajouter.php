<?php
session_start();

$token=uniqid();
$_SESSION["token"]=$token;
include "header.php";
?>
<h1>Ajouter une peluche</h1>

<form method="post" action="ajoutPeluche.php">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <input type="text" name="titre" maxlength="50"
        placeholder="titre" required>
    <input type="text" name="description"
        placeholder="description" required>
    <input type="text" name="couleur" maxlength="20"
        placeholder="couleur" required>
    <input type="text" name="matiere" maxlength="50"
        placeholder="matière" required>
    <input type="checkbox" name="risque_allergie"
        value="1" >
    <input type="text" name="dimensions"
        placeholder="dimensions" required>
    <input type="number" name="poids"
        placeholder="poids" required>
    <input type="text" name="code_barre" maxlength="13"
        placeholder="code barre" required>
    <input type="submit" value="ajouter">
</form>
<?php
include "footer.php";