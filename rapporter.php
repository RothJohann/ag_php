<?php
$date = date("d/m/Y");
$time = date("H:i");
$fichiermeteo = fopen('C:\WeatherLink\ADRETS\Downld08.txt', 'r');

    $ligne = fgets($fichiermeteo);
    do  //recherche de la 1ère ligne avec la date du jour
	{
	$ligne = fgets($fichiermeteo);
	}	
	while (trim(substr($ligne,0,10)) != $date and $ligne != null);
	
	do  //recherche de la 1ère ligne avec l'heure actuelle
	{
	$ligne = fgets($fichiermeteo);
	}	
	while (trim(substr($ligne,8,7)) != $time and $ligne != null);
	
	
$temp = substr($ligne,18,4);
$hum = substr($ligne,40,2);
	

 try
 {
	 $bdd = new PDO('mysql:host=localhost;dbname=meteo;charset=utf8', 'root', '');
 }
 catch(Exception $e)
 {
		 die('Erreur : '.$e->getMessage());
 }
 
 // On ajoute une entrée dans la table rapportsgivre
 $resultat = $bdd->exec('INSERT INTO rapportsgivre (DateRapport, Givre, Temperature, Humidity) VALUES (CURRENT_TIMESTAMP, 1, $temp, $hum)');
 

    $tab = array();	
	
	
    $tab[0] = array("msg" => utf8_encode('Le rapport a bien été inseré dans la base de données!'));
	$temp = 3;
	print ($temp);	
?>