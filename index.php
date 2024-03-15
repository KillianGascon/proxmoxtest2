<?php
session_start();

$token=uniqid();
$_SESSION["token"]=$token;
include "header.php";
include "config.php";

$pdo = new PDO("mysql:host=" . Config::SERVEUR . ";dbname=" . Config::BASEDEDONNEES,
    Config::UTILISATEUR, Config::MOTDEPASSE);


$requete = $pdo->prepare("SELECT * FROM peluche");
$requete->execute();
$peluches = $requete->fetchAll();


?><h1>gestion de peluche</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Couleur</th>
            <th>Matière</th>
            <th>Risque d'allergie</th>
            <th>Dimensions</th>
            <th>Poids</th>
            <th>Code barre</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($peluches as $peluche) { ?>
            <tr>
                <td><?php echo $peluche["titre"]; ?></td>
                <td><?php echo $peluche["description"]; ?></td>
                <td><?php echo $peluche["couleur"]; ?></td>
                <td><?php echo $peluche["matiere"]; ?></td>
                <td><?php if ($peluche["risque_allergie"] == "1") {
                        echo "oui";
                    } else {
                        echo "non";
                    } ?></td>
                <td><?php echo $peluche["dimensions"]; ?></td>
                <td><?php echo $peluche["poids"]; ?></td>
                <td>
                    <?php algoCodeBarre($peluche["code_barre"]); ?>
                </td>
                <td>
                    <form action="modifier.php" method="post">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input type="hidden" name="id_modifier" value="<?php echo $peluche['id'];?>">
                        <input type="submit" value="modifier">
                    </form>
                    <form action="supprimer.php" method="post">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input type="hidden" name="id_supprimer" value="<?php echo $peluche['id'];?>">
                        <input type="submit" value="supprimer">
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br>
    <a href="ajouter.php">ajouter une peluche</a>
<?php

function algoCodeBarre($code_barre) {
    // Convertir le code-barres en tableau de chiffres
    $tableaux = str_split($code_barre);

    // Extraire le dernier chiffre (chiffre de contrôle)
    $chiffre_controle = array_pop($tableaux);


    // Initialiser la somme à 0
    $somme = 0;

    // Parcourir chaque chiffre du code-barres
    for ($i=0;$i<=11;$i+=1) {
        // Ajouter à la somme le chiffre multiplié par 3 si l'index est pair, sinon le chiffre lui-même
        if (($i+1)%2==0){
            $somme+=$tableaux[$i]*3;
        }else{
            $somme+=$tableaux[$i];
        }
    }

    // Calculer le chiffre de contrôle attendu
    $chiffre_valide=$somme%10;

    if ($chiffre_valide!=0){
        $chiffre_valide=10-$chiffre_valide;
    }



    // Vérifier si le chiffre de contrôle calculé est égal au chiffre de contrôle du code-barre
    $estValide = $chiffre_controle == $chiffre_valide;

    // Si le code-barres est valide
    if ($estValide) {
        // Afficher le code-barres
        echo $code_barre;
    } else {
        // Sinon, afficher le code-barres en rouge
        echo "<span style='color:red;'>$code_barre</span>";
    }
}

include "footer.php";
