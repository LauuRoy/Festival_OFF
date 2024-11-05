<?php $niveau="./";?>
<?php include ($niveau . "liaisons/php/config.inc.php");?>

<?php 
	//---------------------------------- Variables importantes ----------------------------------//
	//Gestion des jours et des mois
	$arrJours = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
	$arrMois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
//----------------------------------------------------------------------------------------------------//
	//Requête pour obtenir les trois à 5 derniers articles
	$intNbArticlesAffichage = rand(3, 5);
	$strRequeteActualites="SELECT id, titre, auteurs, date_actualite AS date_complete,
						YEAR(date_actualite) AS annee, 
						MONTH(date_actualite) AS mois, 
						DAYOFMONTH(date_actualite) AS jour, 
						HOUR(date_actualite) AS heure, 
						MINUTE(date_actualite) AS minute, 
						article FROM actualites ORDER BY date_actualite DESC LIMIT 0, " . $intNbArticlesAffichage;


	$objResultatArticles = $objPdo -> query($strRequeteActualites);

	$arrArticles = array();

	for($i=0; $ligne = $objResultatArticles->fetch(); $i++){
		$arrArticles[$i]['id'] = $ligne['id'];
		$arrArticles[$i]['titre'] = $ligne['titre'];
		$arrArticles[$i]['auteurs'] = $ligne['auteurs'];
		$arrArticles[$i]['date_complete'] = $ligne['date_complete'];
		$arrArticles[$i]['annee'] = $ligne['annee'];
		$arrArticles[$i]['mois'] = $ligne['mois'];
		$arrArticles[$i]['jour'] = $ligne['jour'];
		$arrArticles[$i]['heure'] = $ligne['heure'];
		$arrArticles[$i]['minute'] = $ligne['minute'];

		$arrContenuArticle = explode(' ', $ligne['article']);
		if(count($arrContenuArticle) > 45){
			array_splice($arrContenuArticle, 45, count($arrContenuArticle));
		}
		$arrArticles[$i]['article_preview'] = implode(' ', $arrContenuArticle);
	}

	$objResultatArticles->closeCursor();

	//---------------------------------- Suggestions d'artistes ----------------------------------//

    //Sélection aléatoire de 3 à 5 artistes
    $nbSuggestions = rand(3, 5);

    //Sélection de tous les artistes
    $strRequeteSuggestion = "SELECT artistes.nom, artistes.id FROM artistes ORDER BY nom";

    //Récupération des artistes 
    $pdoResultatSuggestion = $objPdo ->query($strRequeteSuggestion);
    $arrArtistesSuggestionPotentiel = array();
    for($i = 0; $ligne = $pdoResultatSuggestion->fetch(); $i++){
        $arrArtistesSuggestionPotentiel[$i]['nom'] = $ligne['nom'];
        $arrArtistesSuggestionPotentiel[$i]['id'] = $ligne['id'];
    }

    //Fermeture de la requête
    $pdoResultatSuggestion->closeCursor();

    //---------------------------------------------------
    $arrArtistesSuggestion = array();
    for($i = 0; $i < $nbSuggestions; $i++){
        //Sélection aléatoire d'un artiste
        $artisteChoisi = rand(0, count($arrArtistesSuggestionPotentiel) - 1);
        //Ajout de l'artiste dans le tableau
        array_push($arrArtistesSuggestion, $arrArtistesSuggestionPotentiel[$artisteChoisi]);
        //Suppression de l'artiste du tableau potentiel
        array_splice($arrArtistesSuggestionPotentiel, $artisteChoisi, 1);
    }
?>
	<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Site web OFF, Festival OFF de Quebec">
	<meta name="keyword" content="HTML, CSS, JavaScript, OFF, musique , festival musique">
	<meta name="author" content=" Marie-Pierre Plante">
	<meta charset="utf-8">
	<link rel="icon" type="image/x-icon" href="">
	<script src="liaisons/js/_menu.js"></script>
	<title> O FF - Festival OFF De Québec </title>
	<?php include ($niveau . "liaisons/fragments/headlinks.inc.html");?>
</head>

<body>
	<?php include ($niveau . "liaisons/fragments/entete.inc.php");?>
	<main>
     	<figure class="accueil__banniere">

			<img  class="accueil__banniere__deskop" src="liaisons/images/accueil/header_table1440w.jpg" 
                 alt="musiciens et dj en fond, festival off de quebec">

			<img class="accueil__banniere__mobile" src="liaisons/images/accueil/header_mobile340w.jpg" 
                 alt="dj en fond, festival off de quebec" >
		</figure>


		       <!-- SECTION ARTICLE -->
		   <section>
			<div id="contenu" class="conteneur">
			<h2 class="article_h2">ARTICLES</h2>
			<section class="article">
				<?php foreach($arrArticles as $article){ ?>
					<article>
						<header>
							<h3 class="article_h3" ><?php echo $article['titre'];?></h3>
						</header>
						<p class="article_preview">
							<!-- PHP preview des artistes-->
							<?php echo $article['article_preview'];?>
							<a href="#">...</a>
						</p>
						<footer class="article_footer">
							<p class="article_auteur"> <?php echo $article['auteurs']; ?></p>
							<time class="article_datetime" <?php echo $article['date_complete'];?>>
								<?php echo "Le " . $article['jour'] . " " . $arrMois[$article['mois'] - 1] . " " . $article['annee'] . " à " . $article['heure'] . "h" . $article['minute'];?>
							</time>
						</footer>
					</article>
				<?php } ?>
			</section>

				<!-- SECTION ARTISTES SUGÉRÉS -->

			<section class="suggestions">
				<h2 class="artiste_h2">Artistes suggérés</h2>
				<ul class="artiste_ul">
					<?php foreach($arrArtistesSuggestion as $artiste){ ?>
						<li class="artiste_fiche">
							<a href="<?php echo $niveau ?>artistes/fiches/index.php?id_artiste=<?php echo $artiste['id']; ?>">
							<span>	<?php echo $artiste['nom']; ?> </span>
								<!-- Sources des images pas encore définies par l'équipe. Vérification sur le alt -->
								<picture class="artiste_imagefiche">
                <source media="(min-width:920px)" srcset="<?php echo $niveau; ?>liaisons/images/programmation/<?php echo $arrEvenement["artiste_id"]?>_0_rect-w320.jpg " alt="<?php echo $arrEvenement["artiste_id"]?>">
                <img class="suggestions_article_image" src="<?php echo $niveau; ?>liaisons/images/programmation/<?php echo $artiste['id']; ?>_0_rect-w320.jpg" alt="Image de l'artiste <?php echo $artiste['nom']; ?>">
                      </picture>
							</a>
						</li>
					<?php } ?>
				</ul>
	         </div>	
			</section>


    <!-- SECTION ACTUALITÉE -->
	<div class="sections_container">
    <div class="actualite_section">
        <h2 class="actualite_h2">ACTUALITÉE</h2>
        <div class="conteneur actualite_conteneur">
            <?php
            $requeteSQL = "SELECT titre FROM actualites";
            $objStat = $objPdo->prepare($requeteSQL);
            $objStat->execute();
            $arrActualite = $objStat->fetchAll();
            foreach ($arrActualite as $actualite) {
                echo "<p class='titre'>" . htmlspecialchars($actualite["titre"]) . "</p>"; 
            }
            ?>
        </div>
    </div>

    <!-- SECTION TARIFS -->
    <div class="tarif_section">
        <h2 class="tarif_h2">TARIFS</h2>
        <div class="conteneur tarif_conteneur">
            <ul class="tarif_ul">
                <li class="tarif_li">Festival Complet: 10$</li>
                <li class="tarif_li">Soirée chez Méduse: 5$</li>
                <li class="tarif_li">Spectacles extérieurs: Gratuit</li>
                <li class="tarif_li">Spectacles chez le Sacrilège et Fou-Bar: Gratuit</li>
            </ul>
        </div>  
    </div>

     <!-- SECTION PREVENTE -->
	 <div class="prevente_section">
        <h2 class="prevente_h2">PRÉVENTES</h2>
        <div class="conteneur prevente_conteneur">
            <ul class="prevente_ul">
                <li class="prevente_li">
                    <h4 class="prevente_h4">La Ninkasi</h4>
                    811 Rue Saint-Jean Québec
                </li>
                <li class="prevente_li">
                    <h4 class="prevente_h4">Érico</h4>
                    635 Rue Saint-Jean Québec
                </li>
                <li class="prevente_li">
                    <h4 class="prevente_h4">Le Sacrilège</h4>
                    447 Rue Saint-Jean Québec
                </li>
            </ul>
        </div>  
    </div>
</div>


	</main>
	<?php include ($niveau . "liaisons/fragments/piedDePage.inc.php");?>

</body>
</html>