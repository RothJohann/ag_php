<?php
date_default_timezone_set('Europe/Paris');
$compteur = 0;
$interval = new DateInterval('PT5M');
$date = new DateTime();
date_sub($date, $interval);
$date = date_format($date, 'd/m/Y');

 print "date=".$date." ";

if(substr($date,0,1)=="0")
	
	$date = substr($date,1,5) . substr($date,8,2);
	
	
else
	
	$date = substr($date,0,6) . substr($date,8,2);
	

$time = new DateTime();
date_sub($time, $interval);
$time = date_format($time, 'H:i');

print "time diminue de 5 min=".$time." ";

$fichiermeteo = fopen('C:\WeatherLink\ADRETS\Downld08.txt', 'r');

$ligne = fgets($fichiermeteo);


do  //recherche de la 1ère ligne avec la date du jour
{
	$compteur++;
	//print("string avec laquelle on cherche à comparer la date:".trim(substr($ligne,0,10)));
	//print("et ca cest la date:".$date); 
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



 try
 {
	 $bdd = new PDO('mysql:host=localhost;dbname=meteo;charset=utf8', 'root', '');
	 print ("on a bien ouvert la connexion a la database");
 }
 catch(Exception $e)
 {
		 die('Erreur : '.$e->getMessage());
 }
 
 print "temp actu=".$TAct." ";
 print "hum actu=".$HAct;
 // On récupère dans la table rapportsgivre : 1/le nombre d'enregistrements qui ont la température = TAct et l'hu:idité = HAct et ou il a fallu gratter
 //2/le nombre d'enregistrements qui ont la température = TAct et l'hu:idité = HAct et ou il n'a PAS fallu gratter

$query = 'SELECT count(*) AS NombreGivre FROM `rapportsgivre` WHERE Temperature =' . $TAct . ' and Humidity =' . $HAct . ' and Givre = 1';
 
print "\n"."query=".$query."\n";

//$resultat = $bdd->exec($query);

foreach ($bdd->query($query) as $row)
{
	$NbJoursGivre = $row[0];
}
	
$query2 = 'SELECT count(*) AS NombreGivre FROM `rapportsgivre` WHERE Temperature =' . $TAct . ' and Humidity =' . $HAct . ' and Givre = 0';
 
print "\n"."query2=".$query2."\n";

//$resultat = $bdd->exec($query2);

foreach ($bdd->query($query2) as $row)
{
	$NbJoursSansGivre = $row[0];
}
//Calcul du pourcentage de grattage
echo "Denominateur de la division" . eval($NbJoursGivre + $NbJoursSansGivre);

If ($NbJoursGivre + $NbJoursSansGivre > 0) 
{
	$PourcentageChancesGratter = $NbJoursGivre/($NbJoursGivre + $NbJoursSansGivre);
}

echo "\n" . "Pourcentage de chance de gratter : " . $PourcentageChancesGratter;
	
fclose($fichiermeteo);

//tests sql


?>