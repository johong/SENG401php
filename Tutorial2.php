<!DOCTYPE html>
<html>
<body>

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

echo "Back to JSON: <br>";
echo json_encode($json);

/*
switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }

    echo PHP_EOL;
*/
?>

</body>
</html>