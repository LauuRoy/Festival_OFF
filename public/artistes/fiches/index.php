<?php 
// Inclusion du fichier de configuration
$niveau = "../../";
include($niveau . 'liaisons/scripts/config.inc.php');
?>

<a href="<?php echo $niveau;?>index.php">Retour</a>

<?php
// Récupération des événements
if (isset($_GET['style_id'])) {
    $strIdStyle = intval($_GET['style_id']); // Convert to integer for safety
    // Requête pour récupérer les événements filtrés par style
    $strRequete = "SELECT DISTINCT nom, HOUR(date_et_heure) as heure, MINUTE(date_et_heure) as min, DAY(date_et_heure) as jour, MONTH(date_et_heure) as mois  
    FROM evenements
    INNER JOIN lieux ON evenements.lieu_id = lieux.id
    WHERE artiste_id = " . $strIdStyle;
} else {
    // Requête pour récupérer tous les événements
    $strRequete = "SELECT DISTINCT nom, HOUR(date_et_heure) as heure, MINUTE(date_et_heure) as min, DAY(date_et_heure) as jour, MONTH(date_et_heure) as mois  
    FROM evenements
    INNER JOIN lieux ON evenements.lieu_id = lieux.id"
    ;
}

// Exécution de la requête
$pdoResultat = $objPdo ->query($strRequete);
$arrEvenements = $pdoResultat->fetchAll(PDO::FETCH_ASSOC); // Fetch all results at once
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
</head>
<body>
<ul>
<?php
// Affichage des événements
if (count($arrEvenements) > 0) {
    foreach ($arrEvenements as $evenement) {
        echo "<li>";
        echo "<strong>" . $evenement['nom'] . "</strong><br>";
        echo "Heures : <strong>" . $evenement['heure'] . "</strong><br>";
        echo "Minutes : " . $evenement['min'] . "<br>";
        echo "Jour : " . $evenement['jour'] . "<br>";
        echo "Mois : " . $evenement['mois'] . "<br>";
        echo "</li>";
    }
} else {
    echo "<li>Aucun événement</li>";
}
?>
</ul>

</body>
</html>
