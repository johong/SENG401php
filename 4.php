<!DOCTYPE html>
<html>
    <body>
        <h1 class="coordinates">Please enter coordinates:</h1>
        <form id="getCoordinates" class="coordinates" action="4_get.php" method="GET">

            <div class="coordinates">
                first x: <input type="number" name="x1">
                first y: <input type="number" name="y1">
            </div>

            <br/>

            <div class="coordinates">
                second x: <input type="number" name="x2">
                second y: <input type="number" name="y2">
            </div>

            <br/>

            <div id="submit-coordinates">
                <input type="submit">
            </div>
        </form>
    </body>
</html>
