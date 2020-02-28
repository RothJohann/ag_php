<?php
date_default_timezone_set('Europe/Paris');
$compteur = 0;
$interval = new DateInterval('PT5M');
$date = new DateTime();
date_sub($date, $interval);
$date = date_format($date, 'd/m/Y');
 print "date=" . $date."<br>";
 //$action =
 print "givre=" . $_GET['givre']."<br>";

if(substr($date,0,1)=="0")
	
	$date = substr($date,1,5) . substr($date,8,2);
	
	
else
	
	$date = substr($date,0,6) . substr($date,8,2);
	

$time = new DateTime();
date_sub($time, $interval);
$time = date_format($time, 'H:i');

print "time diminue de 5 min=".$time." "."<br>";

$fichiermeteo = fopen('C:\WeatherLink\ADRETS\Downld08.txt', 'r');

$ligne = fgets($fichiermeteo);


do  //recherche de la 1ère ligne avec la date du jour
{
	$compteur++;
	print("string avec laquelle on cherche à comparer la date:".trim(substr($ligne,0,10))."<br>");
	print("et ca cest la date:".$date."<br>"); 
	$ligne = fgets($fichiermeteo);
}	
while (trim(substr($ligne,0,10)) != $date and $ligne != null);


do  //recherche de la 1ère ligne avec l'heure actuelle
{
	$compteur++;
	//print("string avec laquelle on cherche à comparer lheure:".trim(substr($ligne,8,7)));
	//print("et ca cest lheure:".$time); 
	$ligne = fgets($fichiermeteo);
}	
while (trim(substr($ligne,8,7)) != $time and $ligne != null);
	
	
$TAct = substr($ligne,18,4);
$HAct = substr($ligne,40,2);

if($TAct != "" and $Hact != "")
{
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=meteo;charset=utf8', 'root', '');
		print ("on a bien ouvert la connexion a la database"."<br>");
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	 
	print "temp actu=".$TAct." ";
	print "hum actu=".$HAct;
	// On ajoute une entrée dans la table rapportsgivre + toutes les entrées plus froides et plus humides
	 
	for($h = 100; $h >= $HAct; $h--) 
	{
		for($t = -20; $t <= $TAct; $t = $t + 0.1 )
		{
			$query = 'INSERT INTO rapportsgivre (DateRapport, Givre, Temperature, Humidity) VALUES (CURRENT_TIMESTAMP, 1,'.$t.','.$h.')';
	 
			print "\n"."query=".$query."\n";
	 
			$resultat = $bdd->exec($query);
	 
			//print "resultat de l'insertion = " . $resultat;
		}
		
	}

	
}
else
{
	echo("Problème dans la récupération de la température et ou l'humidité"."<br>");
}

 fclose($fichiermeteo);


?>