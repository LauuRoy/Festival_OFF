Programmation!

<?php $niveau="../";?>
<?php include ($niveau . "liaisons/php/config.inc.php");?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="keyword" content="">
	<meta name="author" content="">
	<meta charset="utf-8">
	<link rel="stylesheet" href="../liaisons/css/styles.css">
	<title>Programmation OFF</title>
	<?php include ($niveau . "liaisons/fragments/headlinks.inc.html");?>
	<?php include ($niveau . "liaisons/php/utilitaires.inc.php");?>
</head>
<a href="<?php echo $niveau;?>index.php">Retour</a>
<main>
<h1 class="h1_prog">Programmation</h1>
<?php 

if(isset($_GET['id'])==true){
    $strIdDate = $_GET ['id'];
}
else{
    $strIdDate = 0;
}

if($strIdDate == 0){
    $strRequeteDate = 'SELECT DISTINCT  DAYOFMONTH(date_et_heure) AS jour,  MONTH(date_et_heure) AS mois  FROM evenements ORDER BY jour';
}
else{
    $strRequeteDate = 'SELECT DISTINCT  DAYOFMONTH(date_et_heure) AS jour,  MONTH(date_et_heure) AS mois FROM evenements WHERE DAYOFMONTH(date_et_heure) =' .$strIdDate . ' ORDER BY jour';
}
 
 $pdosResultatDate = $objPdo->query($strRequeteDate);
 
 $arrDatesProg = array();
 
 for($cptEnrDate=0;$ligneDatesProg=$pdosResultatDate->fetch(PDO::FETCH_ASSOC);$cptEnrDate ++){
    $arrDatesProg[$cptEnrDate]['id']=$cptEnrDate;
	$arrDatesProg[$cptEnrDate]['jour']=$ligneDatesProg['jour'];
    $arrDatesProg[$cptEnrDate]['mois']=$ligneDatesProg['mois'];
}
 $pdosResultatDate->closeCursor();
 ?>
 <p class="filtre_date">
 <?php 
 foreach ($arrDatesProg as $date) { 
    echo '<a href="../programmation/index.php?id=' . $date['jour'] . '">' . $date['jour'] . '</a> ';
} 
 ?>
 </p>
 
<?php
if ($strIdDate != 0) {
    $requeteSQL = 'SELECT date_et_heure, lieu_id, artiste_id, artistes.nom, lieux.nom,
    HOUR(date_et_heure) AS heure,
    MINUTE(date_et_heure) AS minute,
    MONTH(date_et_heure) AS mois,
    DAYOFMONTH(date_et_heure) AS jour
    FROM evenements 
    INNER JOIN artistes ON evenements.artiste_id = artistes.id 
    INNER JOIN lieux ON lieux.id = evenements.lieu_id
    WHERE DAYOFMONTH(date_et_heure) = ' . $strIdDate . '
    ORDER BY lieux.nom';
} else {
$requeteSQL=' SELECT date_et_heure,lieu_id, artiste_id, artistes.nom, lieux.nom,
 HOUR(date_et_heure) AS heure,
 MINUTE(date_et_heure) AS minute,
 MONTH(date_et_heure) AS MOIS,
 DAYOFMONTH(date_et_heure) AS jour
 FROM evenements INNER JOIN artistes ON evenements.artiste_id = artistes.id INNER JOIN lieux ON lieux.id = evenements.lieu_id
 WHERE DAYOFMONTH(date_et_heure)=8
 ORDER BY lieux.nom ';
}

$pdosResultat= $objPdo->prepare($requeteSQL);
$pdosResultat -> execute(); 
  //mémorise le lieu présentement traité
  $lieuActuel="";

$arrEvenements = array();


for($cptEnr=0; $ligne=$pdosResultat ->fetch( PDO::FETCH_NUM);$cptEnr++){
    $arrEvenements[$cptEnr]["artistes.nom"]=$ligne[3];
    $arrEvenements[$cptEnr]["date_et_heure"]=$ligne[0];
    $arrEvenements[$cptEnr]["heure"]=$ligne[5];
    $arrEvenements[$cptEnr]["minute"]=$ligne[6];
    $arrEvenements[$cptEnr]["mois"]=$ligne[7];
    $arrEvenements[$cptEnr]["jour"]=$ligne[8];
    $arrEvenements[$cptEnr]["lieux.nom"]=$ligne[4];
    $arrEvenements[$cptEnr]["artiste_id"]=$ligne[2];
}
$pdosResultat -> closeCursor(); 
  //partout tout les événements
  foreach($arrEvenements as $arrEvenement){

      //si le lieu présentement traité
      if($lieuActuel!=$arrEvenement['lieux.nom']){

          if($lieuActuel!=""){?>
              </ul></li>
          <?php } ?>

          <li><h3 class="nom_scene_prog">

              <?php echo $arrEvenement['lieux.nom'];
              $lieuActuel=$arrEvenement['lieux.nom'];?>

          </h3><ul>

      <?php } ?>

      <li class="groupe_heure_nom__style">
            <h4 class="h4_heure-prog">
          <time class="time_prog" datetime="<?php echo $arrEvenement['date_et_heure']?>">
              <?php echo ajouterZero($arrEvenement['heure'])?>h<?php echo ajouterZero($arrEvenement['minute'])?>
          </time>
            </h4>
       <div class="nom_style-prog">
          <h5 class="h5_artiste-prog">
          <a class="lien-artistes_prog" href='<?php echo $niveau;?>artistes/fiches/index.php?id_artiste=<?php echo $arrEvenement['artiste_id'];?>'>
              <?php echo $arrEvenement['artistes.nom'];?></a> 
          </h5>
          <p class="style_artiste-prog" >
              <?php echo trouverStylesArtiste($arrEvenement['artiste_id']);?>
             </p> 
              <img class="img_prog" src="<?php echo $niveau;?>liaisons/images/programmation/<?php echo $arrEvenement["artiste_id"]?>_0_rect-w320.jpg" alt="<?php echo $arrEvenement["artiste_id"]?>">
              </div>
      </li>

  <?php } ?>


</li>
</ul>
</body>
</main>