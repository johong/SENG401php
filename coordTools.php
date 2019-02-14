<html>
<body>

<?php 
$p1 = $_GET["p1"]; 
$p2 = $_GET["p2"];
$valid = true;

list($lat1, $lon1) = array_pad(explode(",",$p1,2),2,null);
list($lat2, $lon2) = array_pad(explode(",",$p2,2),2,null);
?>

Point 1: <?php echo $p1;?> <br>
Latitude:
<?php 
if(is_numeric($lat1) && $lat1 > -90 && $lat1 <= 90)
	echo $lat1;
else{
	echo "<span style='color: red;' />Latitude must be between -90 and 90 degrees. Go back to re-enter coordinates.</span>";
	$valid = false;
	}
?> 
<br>

Longitude:
<?php 
if(is_numeric($lat1) && $lon1 > -180 && $lon1 <= 180)
	echo $lon1;
else{
	echo "<span style='color: red;' />Longitude must be between -180 and 180 degrees. Go back to re-enter coordinates.</span>";
	$valid = false;
	}
?> 
<br>

Point 2: <?php echo $p2;?> <br>
Latitude:
<?php 
if(is_numeric($lat1) && $lat2 > -90 && $lat2 <= 90)
	echo $lat2;
else{
	echo "<span style='color: red;' />Latitude must be between -90 and 90 degrees.</span>";
	$valid = false;
	}
?> 
<br>

Longitude:
<?php 
if(is_numeric($lat1) && $lon2 > -180 && $lon2 <= 180)
	echo $lon2;
else{
	echo "<span style='color: red;' />Longitude must be between -180 and 180 degrees.</span>";
	$valid = false;
	}
?> 
<br>

<h2>Bearing between points: </h2>
<?php
if($valid){
	$startLat = toRadians($lat1); //$lat1 * pi() /180;
	$startLng = toRadians($lon1);
	$destLat = toRadians($lat2);
	$destLng = toRadians($lon2);
	
	$y = sin($destLng - $startLng) * cos($destLat);
	$x = cos($startLat) * sin($destLat) - sin($startLat) * cos($destLat) * cos($destLng - $startLng);
	$brng = atan2($y, $x);
	$brng = $brng * 180 / pi();
	echo ($brng + 360) % 360;
	echo " degrees";
	echo "<br>";
}
?>

<h2>Geodesic distance: </h2>

<?php 
	$geodist = haversine($lat1,$lon1,$lat2,$lon2);
	echo round($geodist,2);
	echo "<br>";
?>

<?php
// Converts from degrees to radians.
function toRadians($degrees) {
  return $degrees * pi() / 180;
}

// Converts from radians to degrees.
function toDegrees($radians) {
  return $radians * 180 / pi();
}

function haversine($startLat, $startLng, $destLat, $destLng){
	$lat1 = toRadians($startLat);
	$lon1 = toRadians($startLng);
	$lat2 = toRadians($destLat);
	$lon2 = toRadians($destLng);
	$R = 6371; // km 

	$dLat = $lat2 - $lat1;  
	$dLon = $lon2 - $lon1;
	$dLatSin = sin($dLat / 2);
	$dLonSin = sin($dLon / 2);

	$a = ($dLatSin * $dLatSin) + (cos($lon1) * cos($lon2) * $dLonSin * $dLonSin);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$distance = $R * $c;
	return $distance;
}
?>

<script>
function haversine(startLat, startLng, destLat, destLng) {
	lat1 = toRadians(startLat);
	lon1 = toRadians(startLng);
	lat2 = toRadians(destLat);
	lon2 = toRadians(destLng);
  var R = 6371; // km 

var dLat = lat2-lat1;  
var dLon = lon2-lon1;
const dLatSin = Math.sin(dLat / 2);
const dLonSin = Math.sin(dLon / 2);

const a = (dLatSin * dLatSin) +
            (Math.cos(lon1) * Math.cos(lon2) * dLonSin * dLonSin);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  let distance = R * c;
  return distance.toFixed(2);
}

function bearing(startLat, startLng, destLat, destLng){
  startLat = toRadians(startLat);
  startLng = toRadians(startLng);
  destLat = toRadians(destLat);
  destLng = toRadians(destLng);

  y = Math.sin(destLng - startLng) * Math.cos(destLat);
  x = Math.cos(startLat) * Math.sin(destLat) -
        Math.sin(startLat) * Math.cos(destLat) * Math.cos(destLng - startLng);
  brng = Math.atan2(y, x);
  brng = toDegrees(brng);
  return (brng + 360) % 360;
}
</script>





</body>
</html>