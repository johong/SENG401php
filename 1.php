<?php
$json_file = file_get_contents("CalgarySchools.geojson");
$calgaryschools = json_decode($json_file, $assoc = TRUE);

function iterateArray($array) {
    $new_array = array();

    foreach($array as $key => $value)
    {
        if (!is_array($value))
        {
            $new_array[$key] = $value;
        } else {
            $new_array[$key] = iterateArray($value);
        }
    }

    return $new_array;
}

$calgaryschools_array = array();

foreach($calgaryschools as $key => $value)
{
    if (!is_array($value))
    {
        $calgaryschools_array[$key] = $value;
    } else {
        $calgaryschools_array[$key] = iterateArray($value);
    }
}

file_put_contents("CalgarySchoolsRemade.geojson", json_encode($calgaryschools_array));

?>