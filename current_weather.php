<?php   
if(isset($_GET['city']) )
{

$getcity = $_GET['city'];
$getcountry = $_GET['country'];
//$getcountry = GR;
//$getcity = 'nafplio';
//$getcountry = 'Greece';
//$location = "'". $getcity ."', '". $getcountry ."'";
  

$jsonfile = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$getcity.",".$getcountry."&units=metric&appid=65c0fec8b0b1235118ad30848d74bd1d");

$jsondata = json_decode($jsonfile);
    
$temp = $jsondata->main->temp;
$pressure = $jsondata->main->pressure;
$mintemp = $jsondata->main->temp_min;
$maxtemp = $jsondata->main->temp_max;
$wind = $jsondata->wind->speed;
$humidity = $jsondata->main->humidity;
$desc = $jsondata->weather[0]->description;
$maind = $jsondata->weather[0]->main;
    
 echo "Trexon kairos gia : " . $getcity ."<br>";   
 echo "<hr>";    
  
 echo "description: " . $desc ."<br>";    
    
echo "Temperature: " . $temp ."&deg;C<br>";
    echo "Temperature MAX: " . $maxtemp ."&deg;C<br>";
    echo "Temperature MIN: " . $mintemp ."&deg;C<br>"; 
    
echo "Huminity: " . $humidity ."&deg;%<br>";
echo "Pressure: " . $pressure ."<br>";
echo "Windspeed: " . $wind ."Komboi<br>";   
  
}
?>