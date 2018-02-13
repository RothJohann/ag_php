<?php

 try
 {
	 $bdd = new PDO('mysql:host=localhost;dbname=meteo;charset=utf8', 'root', '');
 }
 catch(Exception $e)
 {
		 die('Erreur : '.$e->getMessage());
 }
 
 // On ajoute une entrée dans la table jeux_video
 $bdd->exec('INSERT INTO rapportsgivre (DateRapport, Givre) VALUES (CURRENT_TIMESTAMP, 1)');
 

    $tab = array();
	
	
	//
	
    $tab[0] = array("msg" => 'le rapport a bien été inséré dans la base de données');

    print(json_encode($tab));

    
?>