Artistes!
<?php
    // Définition de la variable de niveau
    $niveau = '../';
   
 
    // Inclusion du fichier de configuration
    include($niveau . 'liaisons/php/config.inc.php');
 
    // Récupération des paramètres GET
    if (isset($_GET['id_page'])) {
        $strIdPage = $_GET['id_page'];
    } else {
        $strIdPage = 0;
    }
 
    $nbArtistesParPage = 3;
    $enregistrementDepart = $strIdPage * $nbArtistesParPage;
 
    // Initialisation des variables
    $strIdStyle = 0; // Par défaut, aucun style n'est sélectionné
 
    if (isset($_GET['style_id'])) {

        $strIdStyle = $_GET['style_id'];
 
        // Requête pour récupérer les artistes filtrés par style
        $strRequeteData = 'SELECT artistes.id, artistes.nom
        FROM styles_artistes
        INNER JOIN artistes ON styles_artistes.artiste_id = artistes.id
        INNER JOIN styles ON styles_artistes.style_id = styles.id
        WHERE styles_artistes.style_id = ' . ($strIdStyle) . '
        ORDER BY nom
        LIMIT ' . $enregistrementDepart . ', ' . $nbArtistesParPage;
 
        // Requête pour compter le nombre total d'artistes filtrés par style
        $strRequeteCount = 'SELECT COUNT(DISTINCT artistes.id) AS nbArtistes
        FROM styles_artistes
        INNER JOIN artistes ON styles_artistes.artiste_id = artistes.id
        INNER JOIN styles ON styles_artistes.style_id = styles.id
        WHERE styles_artistes.style_id = ' . $strIdStyle;
    } else {
        // Requête pour récupérer tous les artistes
        $strRequeteData = 'SELECT id, nom
                FROM artistes
                ORDER BY nom
                LIMIT ' . $enregistrementDepart . ', ' . $nbArtistesParPage;
 
        // Requête pour compter le nombre total d'artistes
        $strRequeteCount = 'SELECT COUNT(*) AS nbArtistes FROM artistes';
    }
 
    // Exécution de la requête de comptage
    $pdoResultatCpt = $objPdo ->query($strRequeteCount);
    $totalArtistes = $pdoResultatCpt->fetch();
    $nbArtistes = $totalArtistes['nbArtistes'];
 
    $nbPages = ceil($nbArtistes / $nbArtistesParPage);
 
    // Exécution de la requête principale
    $pdosResultat =  $objPdo ->prepare($strRequeteData);
    $pdosResultat->execute();
 
    $arrArtistes = array();
    $ligne = $pdosResultat->fetch();
 
    // Extraction des enregistrements à afficher de la BD
    for ($intCptEnr = 0; $intCptEnr < $pdosResultat->rowCount(); $intCptEnr++) {
        $arrArtistes[$intCptEnr]['id'] = $ligne['id'];
        $arrArtistes[$intCptEnr]['nom'] = $ligne['nom'];
 
        // On établit une deuxième requête pour afficher les styles de l'artiste
        $strRequete = 'SELECT nom FROM styles
             INNER JOIN styles_artistes ON styles_artistes.style_id = styles.id
             WHERE styles_artistes.artiste_id = ' . $ligne['id'];
 
        // Exécution de la requête
        $pdosSousResultat =  $objPdo ->prepare($strRequete);
        $pdosSousResultat->execute();
 
        $ligneStyles = $pdosSousResultat->fetch();
        $strStyles = "";
        // Extraction des noms de styles de la sous-requête
        for ($intCptStyle = 0; $intCptStyle < $pdosSousResultat->rowCount(); $intCptStyle++) {
            if ($strStyles != "") {
                $strStyles = $strStyles . ", ";    // Ajout d'une virgule lorsque nécessaire
            }
 
            $strStyles = $strStyles . $ligneStyles['nom'];
 
            $ligneStyles = $pdosSousResultat->fetch();
        }
        // On libère la sous-requête
        $pdosSousResultat->closeCursor();
 
        // Ajout d'une propriété pour afficher les styles
        $arrArtistes[$intCptEnr]['style_artiste'] = $strStyles;
 
        // On passe à l'autre artiste
        $ligne = $pdosResultat->fetch();
    }
 
    // On libère la requête principale
    $pdosResultat->closeCursor();
 
    // Récupération de la liste des styles
    $strRequete2 = 'SELECT id, nom FROM styles';
    $pdosResultat2 =  $objPdo ->query($strRequete2);
    $ArrayReponse2 = array();
 
    for ($in = 0; $row = $pdosResultat2->fetch(); $in++) {
        $ArrayReponse2[$in]['id'] = $row['id'];
        $ArrayReponse2[$in]['nom'] = $row['nom'];
    }
    $pdosResultat2->closeCursor();
 
    $strRequete = "SELECT id, nom FROM artistes ";
    $pdosResultatArtisteSug =  $objPdo ->query($strRequete);
    $arrArtistesSug = array();
    for($cptEnr=0; $ligneArtistesSug=$pdosResultatArtisteSug->fetch(); $cptEnr++){
        $arrArtistesSug[$cptEnr]['id'] = $ligneArtistesSug['id'];
        $arrArtistesSug[$cptEnr]['nom'] = $ligneArtistesSug['nom'];
    }
 
    $pdosResultatArtisteSug->closeCursor();
 
    $arrArtistesChoisis=array();
 
    for($cpt=0;$cpt<=2;$cpt++){
 
        $artisteChoisi = rand(0,count($arrArtistes)-1);
 
        array_push($arrArtistesChoisis,$arrArtistes[$artisteChoisi]);
        array_splice($arrArtistesSug,$artisteChoisi,1);
    }
    ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Demo de requête imbriquée</title>
</head>
<body>
<a href="<?php echo $niveau;?>index.php">Retour</a>
    <h1>Liste des artistes</h1>
 
    <main>
        
        <ul>
 
       
        <br>
        <br>
     
        <br>
        <br>
        <?php
          echo "<a href=\"index.php\">Tous les styles</a><br><br>";
        // Affichage des liens pour filtrer par style
        for ($i = 0; $i < count($ArrayReponse2); $i++) {
            echo "<a href=\"index.php?style_id=" . $ArrayReponse2[$i]['id'] . "\">" . $ArrayReponse2[$i]['nom'] . "</a><br><br>";
        }
        echo "<br><br>";
 
      
        ?>
        <?php
        // Affichage de la liste des artistes
        for ($intCpt = 0; $intCpt < count($arrArtistes); $intCpt++) { ?>
 
            <li>
                <?php
                echo "<a href=\"./fiches/index.php?style_id=" . $arrArtistes[$intCpt]['id'] . "\">" . "<strong>" . $arrArtistes[$intCpt]['nom'] . "</strong>";
                ?>
                <br>
                <?php echo "Styles : " . $arrArtistes[$intCpt]['style_artiste']; ?>
            </li>
        <?php } ?>
        </ul>
        <?php
        // Liens de navigation pour la pagination
        if ($strIdPage > 0) { ?>
            <a href="index.php?id_page=<?php echo $strIdPage - 1; ?><?php if ($strIdStyle > 0) { echo '&style_id=' . $strIdStyle; } ?>">Page précédente</a>
        <?php } ?>
        <?php
        if ($nbPages > 1) {
            for ($intCpt = 0; $intCpt < $nbPages; $intCpt++) { ?>
                <a href="index.php?id_page=<?php echo $intCpt; ?><?php if ($strIdStyle > 0) { echo '&style_id=' . $strIdStyle; } ?>"><?php echo $intCpt + 1; ?></a>
            <?php } ?>
        <?php } ?>
        <?php
        if ($strIdPage < $nbPages - 1) { ?>
            <a href="index.php?id_page=<?php echo $strIdPage + 1; ?><?php if ($strIdStyle > 0) { echo '&style_id=' . $strIdStyle; } ?>">Page suivante</a>
        <?php } ?>
        
        <br>
        <br>
        <?php
 
        echo ($strIdPage + 1); ?> de <?php echo $nbPages; ?>
        <h2>Artistes suggérés</h2>
        <ul>
        <ul>
            
    <?php
    for($cpt=0; $cpt < count($arrArtistesChoisis); $cpt++) {
        echo "<li>";
        echo "<a href='./fiches/index.php?id_page=" . $arrArtistesChoisis[$cpt]["id"] . "'>" . $arrArtistesChoisis[$cpt]["nom"] . "</a>";
        echo "</li>";
    }
    ?>
</ul>
 
    </main>
</body>
<footer class="piedDePage">
    <nav>
        <ul>
            <li>
                <a href="#">LE OFF</a>
                <ul>
                    <li><a href="#">Tarifs</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Programmation</a>
                <ul>
                    <li><a href="#">Par lieu</a></li>
                    <li><a href="#">Par dates</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Artistes</a>
                <ul>
                    <li><a href="#">Par style musical</a></li>
                    <li><a href="#">Artistes A-Z</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Partenaires</a>
                <ul>
                    <li><a href="#">Devenir partenaires</a></li>
                    <li><a href="#">Partenaires actuels</a></li>
                </ul>
            </li>
    </nav>
    <div class="informations__secondaires">
        <div class="nos__coordonnees">
            <h3>Nos coordonnées</h3>
                <address>
                    <p>Festival OFF de Québec<br>
                       82 boul. René-Lévesque Ouest<br>
                       C.P. 48010<br>
                       Québec, Québec<br>
                       G1S 4X2</p>
                       <p><a href="mailto:info@quebecoff.org">info@quebecoff.org</a><br>
                       <a href="mailto:media@quebecoff.org">media@quebecoff.org</a>
                    </p>
                </address>
        </div>
        <div class="nous__rejoindre">
    <div class="medias">
        <h3> Nos médias sociaux </h3>
        <div class="logo__reseaux">
            <a href="https://www.facebook.com/?locale=fr_CA">
                <img class="sociaux" src="../public/liaisons/images/svg/ic--baseline-facebook.svg" alt="Facebook">
            </a>
            <a href="https://www.youtube.com/">
                <img class="sociaux" src="../public/liaisons/images/svg/mdi--youtube.svg" alt="Youtube">
            </a>
            <a href="https://twitter.com/?lang=fr">
                <img class="sociaux" src="../public/liaisons/images/svg/prime--twitter.svg" alt="Twitter">
            </a>
            <a href="https://www.instagram.com/">
                <img class="sociaux" src="../public/liaisons/images/svg/mdi--instagram.svg" alt="Instagram">
            </a>
        </div>
    </div>
    <div id="logo__footer">
        <a href="#">
        <img class="Festival__OFF_LogoFooter" src="../public/liaisons/images/svg/logo_OFF.svg" alt="Festival-OFF" title="Festival-OFF" /></a>
    </div>
    <h5 class="piedDePage__copyRights">© 2009-2024 Festival OFF Tous droits réservés</h5>
</div>
</footer>

<script src="liaisons/js/_menu.js"></script>
<link rel="stylesheet" href="liaisons/css/styles.css">

</html>
 