<?php

  // DB Info
  $host='localhost';
  $db = 'SENG401';
  $username = 'postgres';
  $password = 'SENG_401';
  $port = 5432;
  $dsn = "pgsql:host=$host; port=$port; dbname=$db; user=$username;
  password=$password";


  // needed function(s)
  // converts array to xml
  function array_to_xml( $data, &$xml_data ) {
      foreach( $data as $key => $value ) {
          if( is_numeric($key) ){
              $key = 'item'.$key; //dealing with <0/>..<n/> issues
          }
          if( is_array($value) ) {
              $subnode = $xml_data->addChild($key);
              array_to_xml($value, $subnode);
          } else {
              $xml_data->addChild("$key",htmlspecialchars("$value"));
          }
       }
  }




  // Start of AJAX request
  $sector = $_REQUEST["Sector"]; // NW, NE, SW or SE
  $format = $_REQUEST["Format"]; // JSON, XML or CSV
  $tableAttr = $_REQUEST["TableAttr"]; // Or-ed combination of attributes
  $tableAttr = (int)$tableAttr;

  try{
        // create a PostgreSQL database connection
        $conn = new PDO($dsn);
        // 1) SELECT * FROM CalgarySchools WHERE sector='___' ORDER BY type;
        $queryStatement = "SELECT * FROM CalgarySchools WHERE sector ='" . $sector
                          . "' ORDER BY type;";

        $query = $conn->query($queryStatement);
        $results = $query->fetchAll();

        // 2) SELECT calgaryschools.type,
           // COUNT(calgaryschools.type)
           // FROM CalgarySchools
           // WHERE calgaryschools.sector='NW'
           // GROUP BY calgaryschools.type
           // ORDER BY calgaryschools.type;
        $queryStatement2 = "SELECT calgaryschools.type, COUNT(calgaryschools.type) "
                           . "FROM CalgarySchools WHERE calgaryschools.sector='"
                           . $sector . "' GROUP BY calgaryschools.type "
                           . "ORDER BY calgaryschools.type;";
        $query2 = $conn->query($queryStatement2);
        $results_count = $query2->fetchAll(); // for the count results

        // echo query
        if($format == "JSON"){
          echo "<h3>School Type Count:</h3><br>" . json_encode($results_count) . "<br>";
          echo "<h3>Sector Summary:</h3><br>" . json_encode($results);
        }
        else if($format == "XML"){
          //header('Content-Type: text/plain',true); // to see XML Tags
          header('Content-Type: text/plain',true); // to see XML Tags
          echo "School Type Count:\n\n";
          // same as below, but for count
          $xml_data2 = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
          // function call to convert array to xml
          array_to_xml($results_count,$xml_data2);
          echo $xml_data2->asXML();

          echo "\n\nSector Summary:\n\n";
          // creating object of SimpleXMLElement
          $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
          // function call to convert array to xml
          array_to_xml($results,$xml_data);
          echo $xml_data->asXML();
        }
        else if($format == "CSV"){
          echo "<h3>School Type Count:</h3><br>";
          foreach($results_count as $result)
          {
          echo $result['type'] . ", " . $result['count'] . "<br>";
          }

          echo "<h3>Sector Summary:</h3><br>";
          foreach($results as $result)
          {
          echo $result['name'] . ", " . $result['address'] . ", " . $result['postalcode']
          . "<br>";
          }
        }
        else if($format == "Table"){
          echo "<h3>School Type Count:</h3><br>";
          echo '<table style="width:100%"><tr>';
          echo "<th>Type</th>";
          echo "<th>Count</th>";
          echo "</tr>";
          foreach($results_count as $result)
          {
            echo "<tr>";
            echo "<td>" . $result['type'] . "</td>";
            echo "<td>" . $result['count'] . "</td>";
            echo "</tr>";
          }
          echo "</table>"; // end of count results table


          echo "<h3>Sector Summary:</h3><br>";
          // Start of table
          echo '<table style="width:100%"><tr>';
          // head column of table
          if(($tableAttr & 256) != 0){
            echo "<th>Name</th>";
          }
          if(($tableAttr & 128) != 0){
            echo "<th>Type</th>";
          }
          if(($tableAttr & 64) != 0){
            echo "<th>Sector</th>";
          }
          if(($tableAttr & 32) != 0){
            echo "<th>Address</th>";
          }
          if(($tableAttr & 16) != 0){
            echo "<th>City</th>";
          }
          if(($tableAttr & 8) != 0){
            echo "<th>Province</th>";
          }
          if(($tableAttr & 4) != 0){
            echo "<th>Postal Code</th>";
          }
          if(($tableAttr & 2) != 0){
            echo "<th>Longitude</th>";
          }
          if(($tableAttr & 1) != 0){
            echo "<th>Latitude</th>";
          }
          echo "</tr>";

          foreach($results as $result)
          {
            echo "<tr>";
            if(($tableAttr & 256) != 0){
              echo "<td>" . $result['name'] . "</td>";
            }
            if(($tableAttr & 128) != 0){
              echo "<td>" . $result['type'] . "</td>";
            }
            if(($tableAttr & 64) != 0){
              echo "<td>" . $result['sector'] . "</td>";
            }
            if(($tableAttr & 32) != 0){
              echo "<td>" . $result['address'] . "</td>";
            }
            if(($tableAttr & 16) != 0){
              echo "<td>" . $result['city'] . "</td>";
            }
            if(($tableAttr & 8) != 0){
              echo "<td>" . $result['province'] . "</td>";
            }
            if(($tableAttr & 4) != 0){
              echo "<td>" . $result['postalcode'] . "</td>";
            }
            if(($tableAttr & 2) != 0){
              echo "<td>" . $result['longitude'] . "</td>";
            }
            if(($tableAttr & 1) != 0){
              echo "<td>" . $result['latitude'] . "</td>";
            }

            echo "</tr>";
          }
          echo "</table>";
        }
        else{
          echo "improper/no format given";
        }


  } catch (Exception $e){echo $e->getMessage();}

?>
