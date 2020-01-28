<?php   
if(isset($_GET['city']) )
{

$getcity = $_GET['city'];
$getcountry = $_GET['country'];
//$getcountry = GR;
//$getcity = 'nafplio';
//$getcountry = 'Greece';
//$location = "'". $getcity ."', '". $getcountry ."'";
  
$urlforcast="http://api.openweathermap.org/data/2.5/forecast/daily?q=".$getcity.",".$getcountry."&units=metric&cnt=5&appid=65c0fec8b0b1235118ad30848d74bd1d";
$json=file_get_contents($urlforcast);
$data=json_decode($json,true);
    
 echo "Progronsi Kairoy gia Cityname: " . $getcity ."<br>";   
 echo "<hr>";   
foreach($data['list'] as $day => $value) { 
  $desc = $value['weather'][0]['description'];
  $max_temp = $value['temp']['max'];
  $min_temp = $value['temp']['min'];
  $pressure = $value['pressure'];
  $humidity = $value['humidity'];
  //$wind = $value['wind'];
    
 echo "Hmera: " .$day ."<br>";   
 echo "description: " . $desc ."<br>";    
 //echo "Temperature: " . $temp ."&deg;C<br>";
 echo "Temperature MAX: " . $max_temp ."&deg;C<br>";
 echo "Temperature MIN: " . $min_temp ."&deg;C<br>"; 
    
echo "Huminity: " . $humidity ."&deg;%<br>";
echo "Pressure: " . $pressure ."<br>";
//echo "Windspeed: " . $wind ."Komboi<br>";   
    echo "<hr>";
}
}
?>                   