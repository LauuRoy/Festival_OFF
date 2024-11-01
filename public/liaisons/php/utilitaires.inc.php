<?php
    function trouverStylesArtiste($id){
        //Faire une requête pour les styles de ce artiste
        $strSql='SELECT nom 
                FROM styles 
                INNER JOIN styles_artistes ON styles.id=styles_artistes.style_id
                WHERE artiste_id='.$id;

        global $objPdo ;
        //Exécution de la requête
        $objStmtStylesArtiste = $objPdo ->prepare($strSql);
        $objStmtStylesArtiste->execute();
        $arrStyles=$objStmtStylesArtiste->fetchAll();
        $strStylesArtiste="";
        //Extraction des informations sur les styles de cet artiste
        foreach($arrStyles as $arrStyle){
            //Si la liste de style n'est pas vide
            if($strStylesArtiste!=""){
                //ajouter une virgule
                $strStylesArtiste=$strStylesArtiste.", ";
            }
            //Ajouter ensuite l'indentifiant de la style
            $strStylesArtiste=$strStylesArtiste  .$arrStyle["nom"];
        }
        return $strStylesArtiste;
    }

    function afficherMois($mois){
        $arrMois=array('janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
        return $arrMois[$mois-1];
    }

    function afficherJour($jour){
        $arrJours=array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi');
        return $arrJours[$jour-1];
    }

    function ajouterZero($temps){
        if($temps<=9){
            return "0".$temps;
        }
        else{
            return $temps;
        }
    }

?>