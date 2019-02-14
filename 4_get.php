<!DOCTYPE html>
<html>
    <body>
        <?php
            $x1 = $_GET["x1"];
            $y1 = $_GET["y1"];
            $x2 = $_GET["x2"];
            $y2 = $_GET["y2"];

            function getQuadrant($x, $y) {
                if ($x > 0 && $y > 0) {
                    echo "The point ($x, $y) is in the first quadrant";
                } elseif ($x > 0 && $y < 0) {
                    echo "The point ($x, $y) is in the second quadrant";
                } elseif ($x < 0 && $y < 0) {
                    echo "The point ($x, $y) is in the third quadrant";
                } elseif ($x < 0 && $y > 0) {
                    echo "The point ($x, $y) is in the fourth quadrant";
                } elseif ($x > 0 && $y === 0) {
                    echo "The point ($x, $y) is bewteen the first and second quadrants";
                } elseif ($x === 0 && $y < 0) {
                    echo "The point ($x, $y) is bewteen the second and third quadrants";
                } elseif ($x < 0 && $y === 0) {
                    echo "The point ($x, $y) is bewteen the third and fourth quadrants";
                } elseif ($x === 0 && $y > 0) {
                    echo "The point ($x, $y) is bewteen the fourth and first quadrants";
                } elseif ($x === 0 && $y === 0) {
                    echo "The point ($x, $y) is bewteen all four quadrants";
                } else {
                    echo "Your point could not be assigned to a quadrant";
                }
                echo "<br/>";
            }

            function changeToInt(&$coordinate) {
                if ($coordinate === "0") {
                    $coordinate = 0;
                }
            }

            function getBearing($x1, $x2, $y1, $y2) {
                $dx = $x2 - $x1;
                $dy = $y2 - $y1;
                $radian = atan2($dx, $dy);
                $degree = rad2deg($radian);
                if ($degree >= 0) {
                    return $degree;
                } else {
                    return 360.0 + $degree;
                }
            }

            function getCircleDistance($x1, $x2, $y1, $y2) {
                $dx = $x2 - $x1;
                $dy = $y2 - $y1;
                $sin1 = pow(sin($dy/2), 2);
                $sin2 = pow(sin($dx/2), 2);
                $cos1 = cos($y1);
                $cos2 = cos($y2);
                $a = $sin1 + $cos1 * $cos2 * $sin2;

                $c = 2*asin(min(1, pow($a, (1/2))));
                return $c*6367;
            }

            if (empty($x1) && $x1 !== "0") {
                echo "Please enter a first x coordinate";
            } elseif (empty($x2) && $x1 !== "0") {
                echo "Please enter a second x coordinate";
            } elseif (empty($y1) && $x1 !== "0") {
                echo "Please enter a first y coordinate";
            } elseif (empty($y2) && $x1 !== "0") {
                echo "Please enter a second y coordinate";
            }

            changeToInt($x1);
            changeToInt($x2);
            changeToInt($y1);
            changeToInt($y2);

            if ($x1 < -90 || $x1 > 90) {
                echo "The first x coordinate is not within the range '-90' and '90'";
            } elseif ($x2 < -90 || $x2 > 90) {
                echo "The second x coordinate is not within the range '-90' and '90'";
            } elseif ($y1 < -180 || $y1 > 180) {
                echo "The first y coordinate is not within the range '-180' and '180'";
            } elseif ($y2 < -180 || $y2 > 180) {
                echo "The second y coordinate is not within the range '-180' and '180'";
            } else {
                getQuadrant($x1, $y1);
                getQuadrant($x2, $y2);
            }

            $bearingDegrees = getBearing($x1, $x2, $y1, $y2);
            echo "The bearing between points ($x1, $y1) and ($x2, $y2) is $bearingDegrees<br/>";

            $haverSineDistance = getCircleDistance($x1, $x2, $y1, $y2);
            echo "The gerat circle distance between ($x1, $y1) and ($x2, $y2) is $haverSineDistance<br/>";
        ?>
    </body>
</html>
