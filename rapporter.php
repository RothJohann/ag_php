<?php
date_default_timezone_set('Europe/Paris');

$interval = new DateInterval('P5M');
$date = new DateTime("d/m/Y");
date_sub($date, $interval);

if(substr($date,0,1)=="0")
	
	$date = substr($date,1,5) . substr($date,8,2);
	
	
else
	
	$date = substr($date,0,5) . substr($date,8,2);
	


$time = date("H:i");

$fichiermeteo = fopen('C:\WeatherLink\ADRETS\Downld08.txt', 'r');

$ligne = fgets($fichiermeteo);


do  //recherche de la 1ère ligne avec la date du jour
{
	//print(trim(substr($ligne,0,10)));
	//print($date); 
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
	 print ("on a bien ouvert la connexion a la database");
 }
 catch(Exception $e)
 {
		 die('Erreur : '.$e->getMessage());
 }
 
 print "temp=".$temp." ";
 print "hum=".$hum;
 // On ajoute une entrée dans la table rapportsgivre
 
 $query = 'INSERT INTO rapportsgivre (DateRapport, Givre, Temperature, Humidity) VALUES (CURRENT_TIMESTAMP, 1,'.$temp.','.$hum.')';
 print "\n"."query=".$query."\n";
 $resultat = $bdd->exec($query);
 print "resultat de l'insertion = " . $resultat;


	
fclose($fichiermeteo);

//tests sql


?>