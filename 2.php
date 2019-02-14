<!DOCTYPE html>
<html>
    <body>
        <button id="JSONButton" type="button" onclick="loadJSON()">Show JSON</button>
        <button id="XMLButton" type="button" onclick="loadXML()">Show XML</button>
        <div id="getJSON"></div>

        <script>
        function loadJSON() {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // document.getElementById("JSONButton").innerHTML = "Show XML";
                    document.getElementById("getJSON").innerHTML = this.response;
                }
            };

            xhttp.open("GET", "1.php", true);
            xhttp.send();
        }

        function loadXML() {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("getJSON").innerHTML = this.response;
                }
            };
            xhttp.open("GET", "3.php", true);
            xhttp.send();
        }
        

        </script>

    </body>
</html>
