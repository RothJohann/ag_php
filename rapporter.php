<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
 $bdd->exec('INSERT INTO rapportsgivre (DateRapport, Givre) VALUES (CURRENT_TIMESTAMP, 1)');
 

    $tab = array();
	
	
	
	
    $tab[0] = array("msg" => utf8_encode('Le rapport a bien été inseré dans la base de données!'));

    print(json_encode($tab));

    
?>