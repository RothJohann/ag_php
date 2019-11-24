<?php
date_default_timezone_set('Europe/Paris');

$interval = new DateInterval('P5i');
$date = new DateTime();
date_sub($date, $interval);
$date = date_format($date, 'd/m/Y');

 print "date=".$date." ";

if(substr($date,0,1)=="0")
	
	$date = substr($date,1,5) . substr($date,8,2);
	
	
else
	
	$date = substr($date,0,5) . substr($date,8,2);
	

$time = new DateTime();
date_sub($time, $interval);
$time = date_format($time, 'H:i');

print "time diminue de 5 min=".$time." ";

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