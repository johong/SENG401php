<?php
$string = file_get_contents('CalgarySchools.geojson');

$json = json_decode($string, true);

echo "School information accessed as array elements:<br><br>";
foreach($json['features'] as $key){
echo $key['properties']['BOARD'];
echo "<br>";

echo $key['properties']['TYPE'];
echo "<br>";

echo $key['properties']['NAME'];
echo "<br>";

echo $key['properties']['ADDRESS'];
echo "<br>";

echo $key['properties']['CITY']." ".$key['properties']['PROVINCE']." ".$key['properties']['POSTAL_COD']."<br>";

echo "Coordinates: ";
echo $key['geometry']['coordinates'][0].",".$key['geometry']['coordinates'][0]."<br>";

echo "<br>";
}

?>