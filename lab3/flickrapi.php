<?php
  $x1 = $_GET["x1"];
  $y1 = $_GET["y1"];
  $x2 = $_GET["x2"];
  $y2 = $_GET["y2"];
  $type = $_GET["type"];

  function getFlickr($bbox) {
    $params = array(
      'api_key' => 'e00bb859fc3cfc5f6a7bc7382e04ddd1',
      'method' => 'flickr.photos.search',
      'bbox' => $bbox,
      'extras' => 'geo',
      'has_geo' => '1',
      'per_page' => '20',
      'page' => '1',
      'format' => 'json',
      'nojsoncallback' => '1',
    );

    $encoded_params = array();

    foreach ($params as $k => $v) {
      $encoded_params[] = urlencode($k).'='.urlencode($v);
    }

    $url = "https://api.flickr.com/services/rest/?".implode('&', $encoded_params);
    $rsp = file_get_contents($url);
    $rsp = str_replace('jsonFlickrApi(', '', $rsp);
    $rsp = substr($rsp, 0, strlen($rsp));
    $rsp2 = json_decode($rsp, true);
    $photos = $rsp2['photos']['photo'];

    for ($i = 0; $i < 20; $i++) {
      if ($GLOBALS['type'] === "image") {
        $imgsrc = 'https://farm'.$photos[$i]["farm"].'.staticflickr.com/'.
        $photos[$i]["server"] . '/'.$photos[$i]["id"].'_'.$photos[$i]["secret"].'.jpg';
        echo '<img src="'.$imgsrc.'">';

      } elseif ($GLOBALS['type'] === "json") {
        echo '<pre>';
        echo json_encode($photos[$i]);
        echo '</pre>';

      } else {
        echo "Incorrect value found";
      }
    }
  }

  getFlickr("$x1, $y1, $x2, $y2");

?>
