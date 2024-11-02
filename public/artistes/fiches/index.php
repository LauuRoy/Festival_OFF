<?php 
// Inclusion du fichier de configuration
$niveau = "../../";
include($niveau . 'liaisons/php/config.inc.php');

// Tableau de liens sociaux par ID d'artiste (sans touché à la base de données)
$liensSociaux = [
    3 => [
        'facebook' => '',
        'instagram' => '',
        'youtube' => 'https://www.youtube.com/channel/UCNZFHjORk1f90TfenIgxtgg',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/1pcqjPVtlhYZThnmAKiRq4?si=VWWuot1LTKW10bzwgXle0Q',
    ],
    4 => [
        'facebook' => 'https://www.facebook.com/purityringmusic/',
        'instagram' => 'https://www.instagram.com/purityring/',
        'youtube' => 'https://www.youtube.com/channel/UCoGAL0CVivticy9z6lSjSLA',
        'spotify' => 'https://open.spotify.com/artist/1TtJ8j22Roc24e2Jx3OcU4?autoplay=true',
    ],
    5 => [
        'facebook' => '',
        'instagram' => '',
        'youtube' => '',
        'spotify' => '',
    ],
    7 => [
        'facebook' => '',
        'instagram' => '',
        'youtube' => '',
        'spotify' => '',
    ],
    8 => [
        'facebook' => 'https://www.facebook.com/peterpeteroffcl',
        'instagram' => 'https://www.instagram.com/peterpeteroffcl/',
        'youtube' => 'https://www.youtube.com/channel/UCr73Iq1ValJUPTrJJ6m_SYQ',
        'spotify' => 'https://open.spotify.com/artist/52NQGJWKvdWMbKxThs2fNC?autoplay=true',
    ],
    11 => [
        'facebook' => 'https://www.facebook.com/profile.php?id=100071306867237',
        'instagram' => '',
        'youtube' => '',
        'spotify' => '',
    ],
    12 => [
        'facebook' => 'https://www.facebook.com/ponctuation',
        'instagram' => 'https://www.instagram.com/ponctuationqc/',
        'youtube' => 'https://www.youtube.com/channel/UCF1ReKe15jfP2XVFxBNNYtQ',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/5uhodULRKQX6WqWmuos3t8?si=g3aWxACESCqgRXd450-JUg',
    ],
    14 => [
        'facebook' => 'https://www.facebook.com/LSBOVROUV/',
        'instagram' => 'https://www.instagram.com/lesbovrouven/',
        'youtube' => 'https://www.youtube.com/channel/UCDSlCZGXerddSbrK2qhGASg',
        'spotify' => '',
    ],
    15 => [
        'facebook' => '',
        'instagram' => '',
        'youtube' => 'https://www.youtube.com/channel/UCB06T2M6bZW7VtkkYrf8mGg',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/4grpTfgLJjYtqMiFxDVheE',
    ],
    18 => [
        'facebook' => 'https://www.facebook.com/lunice/?locale=fr_FR',
        'instagram' => 'https://www.instagram.com/lunice/?hl=fr',
        'youtube' => 'https://www.youtube.com/channel/UCv5oUaLbS2cSwfAH2LKIAiw',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/5I0593TTVPzkanWW8xsTns?autoplay=true',
    ],
    21 => [
        'facebook' => 'https://www.facebook.com/blacktaboo',
        'instagram' => '',
        'youtube' => 'https://www.youtube.com/user/Blacktaboovideo',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/7l3tJokhtkXbhiV0af1Q0t?si=KW8RVIq6S4-sfiWQIIFwVw',
    ],
    24 => [
        'facebook' => 'https://www.facebook.com/troupeolibriusfolkestra/',
        'instagram' => '',
        'youtube' => '',
        'spotify' => '',
    ],
    28 => [
        'facebook' => '',
        'instagram' => '',
        'youtube' => '',
        'spotify' => '',
    ],
    30 => [
        'facebook' => 'https://www.facebook.com/koriassreal',
        'instagram' => 'https://www.instagram.com/koriassreal/',
        'youtube' => 'https://www.youtube.com/channel/UCiS54GSYK4XtWVI6BDVmfhw',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/4aLij7W6aqtpsRriCSjGLq?si=tyfIfABJQd2IiF-6oUeTXA',
    ],
    31 => [
        'facebook' => 'https://www.facebook.com/boogatmusic',
        'instagram' => 'https://www.instagram.com/boogatmusic/',
        'youtube' => 'https://www.youtube.com/channel/UCYjuj_Gp7WS3miugpbArjXg',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/2y2bEk3zCBVBMDkrXgA29R?autoplay=true',
    ],
    33 => [
        'facebook' => '',
        'instagram' => '',
        'youtube' => 'https://www.youtube.com/channel/UCJKsYkfaZ0qNDSIQ5dtrsqw',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/4oStK9ciafm8YIPRarrOir',
    ],
    33 => [
        'facebook' => 'https://www.facebook.com/@K6Acrew',
        'instagram' => 'https://www.instagram.com/k6a_crew/',
        'youtube' => 'https://www.youtube.com/channel/UCsQow4Q0HiakQ55YIXkIs0w',
        'spotify' => 'https://open.spotify.com/intl-fr/artist/4rG9Fygl7lq2VRw4P1yPUC?autoplay=true',
    ],
];
?>

<a href="<?php echo $niveau;?>index.php">Retour</a>

<?php
// Récupération des événements et informations de l'artiste
if (isset($_GET['style_id'])) {
    $strIdStyle = intval($_GET['style_id']); 

    // Requête pour récupérer le nom et la description de l'artiste
    $strRequeteNom = "SELECT nom, description, provenance, pays, site_web, myspace FROM artistes WHERE id = " . $strIdStyle;
    $pdoResultatNom = $objPdo->query($strRequeteNom);
    $noms = $pdoResultatNom->fetch(PDO::FETCH_ASSOC);

    // Vérification si un nom a été trouvé
    if (!$noms) {
        echo "<p>Artiste non trouvé.</p>";
    }

    // Requête pour récupérer les événements filtrés par style
    $strRequete = "SELECT DISTINCT nom, HOUR(date_et_heure) as heure, MINUTE(date_et_heure) as min, DAY(date_et_heure) as jour, MONTH(date_et_heure) as mois  
    FROM evenements
    INNER JOIN lieux ON evenements.lieu_id = lieux.id
    WHERE artiste_id = " . $strIdStyle;
} else {
    // Requête pour récupérer tous les événements
    $strRequete = "SELECT DISTINCT nom, HOUR(date_et_heure) as heure, MINUTE(date_et_heure) as min, DAY(date_et_heure) as jour, MONTH(date_et_heure) as mois  
    FROM evenements
    INNER JOIN lieux ON evenements.lieu_id = lieux.id";
}

// Exécution de la requête des événements
$pdoResultat = $objPdo->query($strRequete);
$arrEvenements = $pdoResultat->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
</head>
<body>

<h1 class="noms_artistes">
    <?php 
    // Affichage du nom de l'artiste si disponible
    echo isset($noms['nom']) ? htmlspecialchars($noms['nom']) : "Artiste inconnu"; 
    ?>
</h1>

<ul>
<?php
// Affichage des événements
if (count($arrEvenements) > 0) {
    foreach ($arrEvenements as $evenement) {
        echo "<li>";
        echo "<strong>" . htmlspecialchars($evenement['nom']) . "</strong><br>";
        echo "Heures : <strong>" . htmlspecialchars($evenement['heure']) . "</strong><br>";
        echo "Minutes : " . htmlspecialchars($evenement['min']) . "<br>";
        echo "Jour : " . htmlspecialchars($evenement['jour']) . "<br>";
        echo "Mois : " . htmlspecialchars($evenement['mois']) . "<br>";
        echo "</li>";
    }
} else {
    echo "<li>Aucun événement</li>";
}
?>
</ul>

<p class="provenance__artiste">
    Provenance:
<?php 
    // Affichage de la description de l'artiste si disponible
    echo isset($noms['provenance']) ? htmlspecialchars($noms['provenance']) : "indisponible"; 
    ?>
</p>

<p class="pays__artiste">
    Pays:
<?php 
    // Affichage de la description de l'artiste si disponible
    echo isset($noms['pays']) ? htmlspecialchars($noms['pays']) : "indisponible"; 
    ?>
</p>

<p class="description__artiste">
<?php 
    // Affichage de la description de l'artiste si disponible
    echo isset($noms['description']) ? htmlspecialchars($noms['description']) : "indisponible"; 
    ?>
</p>

<p class="site__web__artiste">
    site internet:
<?php 
    // Affichage de la description de l'artiste si disponible
    echo isset($noms['site_web']) ? htmlspecialchars($noms['site_web']) : "indisponible"; 
    ?>
</p>

<!-- Liens vers les réseaux sociaux -->
<!-- Liens vers les réseaux sociaux -->
<p class="reseaux_sociaux">
    Réseaux sociaux :
    <?php 
    // Vérifiez si des liens sociaux sont disponibles pour l'artiste
    if (isset($liensSociaux[$strIdStyle])) {
        $liens = $liensSociaux[$strIdStyle];
        
        // Facebook
        if (!empty($liens['facebook'])) {
            echo '<a href="' . htmlspecialchars($liens['facebook']) . '" target="_blank">';
            echo '<img src="' . $niveau . '../public/liaisons/images/svg/ic--baseline-facebook.svg" alt="Facebook" width="20" height="20"></a> ';
        }

        // Instagram
        if (!empty($liens['instagram'])) {
            echo '<a href="' . htmlspecialchars($liens['instagram']) . '" target="_blank">';
            echo '<img src="' . $niveau . '../public/liaisons/images/svg/mdi--instagram.svg" alt="Instagram" width="20" height="20"></a> ';
        }

        // YouTube
        if (!empty($liens['youtube'])) {
            echo '<a href="' . htmlspecialchars($liens['youtube']) . '" target="_blank">';
            echo '<img src="' . $niveau . '../public/liaisons/images/svg/mdi--youtube.svg" alt="YouTube" width="20" height="20"></a> ';
        }

        // Spotify
        if (!empty($liens['spotify'])) {
            echo '<a href="' . htmlspecialchars($liens['spotify']) . '" target="_blank">';
            echo '<img src="' . $niveau . '../public/liaisons/images/svg/Spotify--Streamline-Plump.svg" alt="Spotify" width="20" height="20"></a>';
        }
    } else {
        echo "Liens sociaux non disponibles";
    }
    ?>
</p>


</body>
</html>