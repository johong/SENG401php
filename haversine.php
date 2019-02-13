<html>
<body>

<script>
// Converts from degrees to radians.
function toRadians(degrees) {
  return degrees * Math.PI / 180;
};
 
// Converts from radians to degrees.
function toDegrees(radians) {
  return radians * 180 / Math.PI;
}

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

<?php 
$p1 = $_POST["Point1"]; 
$p2 = $_POST["Point2"];
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

<p id="demo"></p>

<script type="text/javascript">
var validCoords = "<?php echo $valid ?>";

if(validCoords == 1){
var lt1 = "<?php echo $lat1 ?>";
var ln1 = "<?php echo $lon1 ?>";
var lt2 = "<?php echo $lat2 ?>";
var ln2 = "<?php echo $lon2 ?>";

var lat1 = parseFloat(lt1);
var lon1 = parseFloat(ln1);
var lat2 = parseFloat(lt2);
var lon2 = parseFloat(ln2);
}
document.getElementById("demo").innerHTML = bearing(lat1,lon1,lat2,lon2);
</script>



<h2>Geodesic distance: </h2>
<p id="demo2"></p>

<script>
var lt1 = "<?php echo $lat1 ?>";
var ln1 = "<?php echo $lon1 ?>";
var lt2 = "<?php echo $lat2 ?>";
var ln2 = "<?php echo $lon2 ?>";

var lat1 = parseFloat(lt1);
var lon1 = parseFloat(ln1);
var lat2 = parseFloat(lt2);
var lon2 = parseFloat(ln2);

document.getElementById("demo2").innerHTML = haversine(lat1,lon1,lat2,lon2)+" km";
</script>

</body>
</html>