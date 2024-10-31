
<?php $niveau="./";?>
<?php include ($niveau . "liaisons/php/config.inc.php");?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Site web OFF, Festival OFF de Quebec">
	<meta name="keyword" content="HTML, CSS, JavaScript, OFF, musique , festival musique">
	<meta name="author" content=" Marie-Pierre Plante">
	<meta charset="utf-8">
	<link rel="icon" type="image/x-icon" href="">
	<title> O FF - Festival OFF De Québec </title>
	<?php include ($niveau . "liaisons/fragments/headlinks.inc.html");?>
</head>

<body>

	<?php include ($niveau . "liaisons/fragments/entete.inc.php");?>

	<main>
		<div id="contenu" class="conteneur">
			<h2>Entête de page</h2>

			<?php
			$requeteSQL="Select titre from actualites";
			$objStat=$objPdo -> prepare($requeteSQL);
			$objStat -> execute();
			$arrActualite=$objStat -> fetchAll();
			forEach($arrActualite as $actualite){
				echo $actualite["titre"];?><BR>
			<?php } ?>

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
					<footer>
						<h5>Pied d'article</h5>
					</footer>
				</article>
				<article>
					<header>
						<h4>Entête d'article</h4>
					</header>
					<p>Lorem ipsum dolor nunc aut nunquam sit amet, consectetur adipiscing elit. Vivamus at est eros, vel fringilla urna. Pellentesque odio</p>
					<footer>
						<h5>Pied d'article</h5>
					</footer>
				</article>
			</section>
		</div>
	
   
        <p><a href="#" class="bouton">Bouton</a></p>
		<p><a href="#" class="bouton--inverse">Bouton</a></p>
     <a href="#" class="hyperlien">lien test!</a>
	</main>
	
	<aside>
            <h3>Barre latérale</h3>
            <p>Lorem ipsum dolor nunc aut nunquam sit amet, consectetur adipiscing elit. Vivamus at est eros, vel fringilla urna. Pellentesque odio rhoncus</p>
	</aside>
	
	
	<?php include ($niveau . "liaisons/fragments/piedDePage.inc.php");?>

</body>
</html>