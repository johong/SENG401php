<html>
    <body>
        <?php
        $json_file = file_get_contents("CalgarySchools.geojson");
        $calgaryschools = json_decode($json_file, $assoc = TRUE);

        function iterateArray($array) {
            foreach($array as $key=>$value) {
                if (!is_array($value)) {
                    echo "<p>Key=" . $key . " | Value=" . $value . "</p>";
                    // echo "<p>$value</p>";
                } else {
                    echo "<p><em><strong>Key=" . $key . "</em></strong> </p>";
                    iterateArray($value);
                }
            }
        }

        iterateArray($calgaryschools);
        ?>
    </body>
</html>