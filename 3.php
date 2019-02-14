<?php

$json_file = file_get_contents("CalgarySchools.geojson");
$calgaryschools = json_decode($json_file, $assoc = TRUE);


function iterateArray($array) {
    $new_array = array();

    foreach($array as $key => $value) {
        if (!is_array($value)) {
            $new_array[$key] = $value;
        } else {
            $new_array[$key] = iterateArray($value);
        }
    }

    return $new_array;
}

//function defination to convert array to xml
function array_to_xml($array, &$xml_user_info) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            if (!is_numeric($key)) {
                $subnode = $xml_user_info -> addChild("$key");
                array_to_xml($value, $subnode);
            } else {
                $subnode = $xml_user_info -> addChild("item$key");
                array_to_xml($value, $subnode);
            }

        } else {
            $xml_user_info -> addChild("$key", htmlspecialchars("$value"));
        }
    }
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

//creating object of SimpleXMLElement
$xml_user_info = new SimpleXMLElement("<?xml version=\"1.0\"?><user_info></user_info>");

//function call to convert array to xml
array_to_xml($calgaryschools_array, $xml_user_info);

//saving generated xml file
$xml_file = $xml_user_info -> asXML('CalgarySchools.xml');

// $xmlDoc = new DOMDocument();
// $xmlDoc->load("CalgarySchools.xml");
// $xmlElement = $xmlDoc->getElementsBy

//success and error message based on xml creation
// if ($xml_file) {
//     echo 'XML file have been generated successfully.';
// } else {
//     echo 'XML file generation error.';
// }
?>
