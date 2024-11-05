<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site web du festival Off ">
    <meta name="keywords" content="festival, Off, programmation, artistes">
    <meta name="author" content="Laurie Roy">
    <meta charset="utf-8"><link rel="stylesheet" href="../../liaisons/css/styles.css">
    <title>Festival Off - Fiches d'artistes</title>
</head>


<?php
// Définition du niveau et inclusion de la configuration
$niveau = "../../";
include($niveau . 'liaisons/php/config.inc.php');
?>

<a href="<?php echo $niveau;?>index.php">Retour</a>

<?php
// Récupération des événements d'artistes
if (isset($_GET['style_id'])) {
    $strIdStyle = intval($_GET['style_id']); 
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


// Tableau des réseaux sociaux par ID d'artiste (sans toucher à la base de données)
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

<body class="page">
<?php include ($niveau . "liaisons/fragments/entete.inc.php");?>
<!-- <a href="#contenu" class="screen-reader-only focusable">Allez au contenu</a> -->

<a href="<?php echo $niveau;?>index.php">Retour</a>
<main class="main" id="contenu" role="main">   
<?php

$niveau = "../../";
include($niveau . 'liaisons/php/config.inc.php');

$cheminImages = $niveau . './liaisons/images/artistes/';

// ID de l'artiste à afficher
$strIdStyle = isset($_GET['style_id']) ? intval($_GET['style_id']) : 0;

// Récupération des informations de l'artiste
$strRequeteNom = "SELECT nom, description, provenance, pays, site_web, myspace FROM artistes WHERE id = " . $strIdStyle;
$pdoResultatNom = $objPdo->query($strRequeteNom);
$noms = $pdoResultatNom->fetch(PDO::FETCH_ASSOC);
?>

<!-- NOM ARTISTE -->
<h1 class="nom_artiste"><?php echo isset($noms['nom']) ? htmlspecialchars($noms['nom']) : "Artiste inconnu"; ?></h1>

<section class="evenement__section">
    <article class="emplacements">
<!-- DATE EVENEMENTS -->
<ul class="evenements">
<?php

if (count($arrEvenements) > 0) {
    foreach ($arrEvenements as $evenement) {
        echo '<li class="evenements__informations">';
        echo " <strong> Emplacement </strong>  :" . $evenement['nom'] . "<br>";
        echo "Heures : " . $evenement['heure'] . "<br>";
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

<!-- PROVENANCE -->
<p class="provenance__artiste">
    <strong> Provenance: </strong>
    <?php echo isset($noms['provenance']) ? htmlspecialchars($noms['provenance']) : "indisponible"; ?>
</p>

<!-- PAYS -->
<p class="pays__artiste">
    <strong> Pays: </strong>
    <?php echo isset($noms['pays']) ? htmlspecialchars($noms['pays']) : "indisponible"; ?>
</p>
</article>
<div class="carrousel-container">
    <div class="carrousel-images">
        <?php
        
        for ($i = 0; $i <= 3; $i++) {
            $cheminImageArtiste = $cheminImages . $strIdStyle . "_" . $i . "_W320.jpg";
            if (file_exists($cheminImageArtiste)) {
                echo '<img src="' . htmlspecialchars($cheminImageArtiste) . '" class="carousel-image" alt="Image de l\'artiste ' . htmlspecialchars($noms['nom']) . '" width="320" height="214">';
            }
        }
        ?>
    </div>
      <!-- Boutons de navigation -->
      <button class="carrousel-btn prev" onclick="prevImage()">&#10094;</button>
    <button class="carrousel-btn next" onclick="nextImage()">&#10095;</button>
    </section>
  
</div>

<div class='image__artiste__4'>
<?php
$imageArtisteNum4 = $cheminImages . $strIdStyle . "_4_W320.jpg";
?>
</div>

<!-- DESCRIPTION -->
 <!-- METTRE BALISE A POUR LIEN CLIQUABLE -->
<p class="description__artiste">
    <?php echo isset($noms['description']) ? htmlspecialchars($noms['description']) : "indisponible"; ?>
</p>

<!-- DÉCOUVRIR ARTISTE -->
<h2 class="nom_artiste__h2"> 
    Découvrir <?php echo isset($noms['nom']) ? htmlspecialchars($noms['nom']) : "Artiste inconnu"; ?>
</h2>
<section class="decouvrir__reseau">
<!-- RÉSEAUX SOCIAUX -->
<nav class="reseaux_sociaux">
    <!-- Réseaux sociaux : -->
    <?php 
    if (isset($liensSociaux[$strIdStyle])) {
        $liens = $liensSociaux[$strIdStyle];
        
        // Vérifier si tous les liens de réseaux sociaux sont vides
        if (empty($liens['facebook']) && empty($liens['instagram']) && empty($liens['youtube']) && empty($liens['spotify'])) {
            echo "Aucun réseau social disponible";
        } else {
            // Afficher les liens s'ils existent
            if (!empty($liens['facebook'])) {
                echo '<a href="' . htmlspecialchars($liens['facebook']) . '" target="_blank"><img src="' . $niveau . '../public/liaisons/images/svg/blanc-ic--baseline-facebook.svg" alt="Facebook" width="" height=""></a> ';
            }
            
            if (!empty($liens['instagram'])) {
                echo '<a href="' . htmlspecialchars($liens['instagram']) . '" target="_blank">
                <img src="' . $niveau . '../public/liaisons/images/svg/blanc-mdi--instagram.svg" alt="Instagram" width="" height=""></a> ';
            }
            if (!empty($liens['youtube'])) {
                echo '<a href="' . htmlspecialchars($liens['youtube']) . '" target="_blank"><img src="' . $niveau . '../public/liaisons/images/svg/blanc-mdi--youtube.svg" alt="YouTube" width="" height=""></a> ';
            }
            if (!empty($liens['spotify'])) {
                echo '<a href="' . htmlspecialchars($liens['spotify']) . '" target="_blank"><img src="' . $niveau . '../public/liaisons/images/svg/blanc-mdi--spotify.svg" alt="Spotify" width="" height=""></a>';
            }
        }
    }
    ?>


<!-- SITE WEB -->
<p class="site__web__artiste">
    <strong>Site internet: </strong> <br>
    <?php echo isset($noms['site_web']) ? htmlspecialchars($noms['site_web']) : "indisponible"; ?>
</p>
</nav>

<!-- IMAGE NUM.4 -->
<?php 
if (file_exists($imageArtisteNum4)) {
    echo '<img class="image__artiste__4" src="' . htmlspecialchars($imageArtisteNum4) . '" alt="Image de l\'artiste" width="320" height="214">';
} else {
    echo "<p>L'image de l'artiste n'est pas disponible.</p>";
}
?>
</section>
</body>
</main>


<?php include ($niveau . "liaisons/fragments/piedDePage.inc.php");?>


</html>



<!-- JAVASCRIPT -->
<script src="liaisons/js/_menu.js"></script>
<script>
    let currentIndex = 0;
    const images = document.querySelectorAll('.carousel-image');

    // Affiche l'image correspondant à l'index actuel
    function showImage(index) {
        // Si l'index dépasse le nombre d'images, on revient au début ou à la fin
        if (index >= images.length) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = images.length - 1;
        } else {
            currentIndex = index;
        }

        // Masquer toutes les images
        images.forEach(image => image.style.display = 'none');

        // Afficher l'image actuelle
        images[currentIndex].style.display = 'block';
    }

    // Fonction pour afficher l'image précédente
    function prevImage() {
        showImage(currentIndex - 1);
    }

    // Fonction pour afficher l'image suivante
    function nextImage() {
        showImage(currentIndex + 1);
    }

    // Initialisation du carrousel en affichant la première image
    showImage(currentIndex);
</script>