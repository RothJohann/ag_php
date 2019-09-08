<?php

 try
 {
	 $bdd = new PDO('mysql:host=localhost;dbname=meteo;charset=utf8', 'root', '');
 }
 catch(Exception $e)
 {
		 die('Erreur : '.$e->getMessage());
 }
 
 // On ajoute une entrée dans la table rapportsgivre
 $bdd->exec('INSERT INTO rapportsgivre (DateRapport, Givre) VALUES (CURRENT_TIMESTAMP, 0)');
 

    $tab = array();
	$test;
	
	
	
	
    $tab[0] = array("msg" => 'le rapport a bien ete insere dans la base de donnees');

    print(json_encode($tab));
	
	

    
?>