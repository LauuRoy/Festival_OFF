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
	<figure class="entete__banniere">
<img src="liaisons/images/accueil/header_table1440w.jpg" alt="musiciens et dj en fond, festival off de quebec sur le dessus " class="entete__banniere__img">
</figure>
		  <!-- SECTION ACTUALITÉE -->
		<div id="contenu" class="conteneur">
			<?php
			$requeteSQL="Select titre from actualites";
			$objStat=$objPdo -> prepare($requeteSQL);
			$objStat -> execute();
			$arrActualite=$objStat -> fetchAll();
			forEach($arrActualite as $actualite){
				echo $actualite["titre"];?><BR>
			<?php } ?>
	             <!-- SECTION ARTICLE -->
			<section>
			<div id="contenu" class="conteneur">
			<section class="article">
				<h2>Articles</h2>
				<?php foreach($arrArticles as $article){ ?>
					<article>
						<header>
							<h3><?php echo $article['titre'];?></h3>
						</header>
						<p>
							<!-- PHP preview des artistes-->
							<?php echo $article['article_preview'];?>
							<a href="#">...</a>
						</p>
						<footer>
							<p> <?php echo $article['auteurs']; ?></p>
							<time datetime="<?php echo $article['date_complete'];?>">
								<?php echo "Le " . $article['jour'] . " " . $arrMois[$article['mois'] - 1] . " " . $article['annee'] . " à " . $article['heure'] . "h" . $article['minute'];?>
							</time>
						</footer>
					</article>
				<?php } ?>
			</section>

				<!-- SECTION ARTISTES SUGÉRÉS -->

			<section class="suggestions">
				<h2>Artistes suggérés</h2>
				<ul>
					<?php foreach($arrArtistesSuggestion as $artiste){ ?>
						<li>
							<a href="<?php echo $niveau ?>artistes/fiches/index.php?id_artiste=<?php echo $artiste['id']; ?>">
								<?php echo $artiste['nom']; ?>
								<!-- Sources des images pas encore définies par l'équipe. Vérification sur le alt -->
								<img src="#" alt="<?php echo "ID artiste : " . $artiste['id'] ?>">
							</a>
						</li>
					<?php } ?>
				</ul>
		</div>
				
				</article>
			</section>
		</div>
	
   
       
	</main>
	

	
	
	<?php include ($niveau . "liaisons/fragments/piedDePage.inc.php");?>

</body>
</html>