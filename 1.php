<?php
$json_file = file_get_contents("CalgarySchools.geojson");
$calgaryschools = json_decode($json_file, $assoc = TRUE);

function iterateArray($array) {
    $new_array = array();

    foreach($array as $key => $value) {
        if (!is_array($value)) {
            echo "$key => $value<br/>";
            $new_array[$key] = $value;
        } else {
            echo "<br/>";
            $new_array[$key] = iterateArray($value);
        }
    }

    return $new_array;
}

$calgaryschools_array = array();

foreach($calgaryschools as $key => $value) {
    if (!is_array($value)) {
        echo "$key => $value<br/>";
        $calgaryschools_array[$key] = $value;
    } else {
        echo "<br/>";
        $calgaryschools_array[$key] = iterateArray($value);
    }
}

// return $calgaryschools_array;

// file_put_contents("CalgarySchoolsRemade.geojson", json_encode($calgaryschools_array));
// var_dump($calgaryschools_array);

?>
