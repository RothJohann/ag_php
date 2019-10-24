<?php
 
    //Récupération des données  19/09/2019    9/09/19
    $tab = array();
	
	$date = date("d/m/Y");
		
	if(substr($date,0,1)=="0")
	
	$date = substr($date,1,5) . substr($date,8,2);
	
	else
	
	$date = substr($date,0,5) . substr($date,8,2);
	
	
	$heure = date("H:i");
	//Print("Nous sommes le $date et il est $heure");
	
	
	$fichiermeteo = fopen('C:\WeatherLink\ADRETS\Downld08.txt', 'r');
	
	do  //recherche de la 1ère ligne avec la date du jour
	{
	$ligne = fgets($fichiermeteo);
	//print (substr($ligne,0,10) . " " . substr($ligne,11,1));
	//print '<br>';
	}	
	while (trim(substr($ligne,0,10)) != $date and $ligne != null);
	
	//print ("on a trouvé la bonne date");
	
	do //recherche de la 1ère ligne à partir de 5h 
	{
	$ligne = fgets($fichiermeteo);
	//print (substr($ligne,0,10) . " " . substr($ligne,11,1));
	//print '<br>';
	}
	while (substr($ligne,11,1) != "5" and $ligne != null);	
	
	//print ("la temperature du $date à " . substr($ligne,11,5) . " est " . substr($ligne,18,7)."°C"); 
	
    $tab[0] = array("temp5h" => substr($ligne,18,4),"hum6h" => substr($ligne,40,2));

    print(json_encode($tab));
	
	fclose($fichiermeteo);
    
?>