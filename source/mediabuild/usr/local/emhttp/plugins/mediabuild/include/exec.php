<?php

$mediaPaths['tempFiles']  = "/tmp/mediabuild";
$mediaPaths['sourcesURL'] = "https://raw.githubusercontent.com/Squidly271/mediabuild-sources/master/sources";
$mediaPaths['sources'] = $mediaPaths['tempFiles']."/sources.json";


switch ($_POST['action']) {

case 'show_description':
  $build = isset($_POST['build']) ? urldecode(($_POST['build'])) : false;

  $sources = json_decode(file_get_contents($mediaPaths['sources']),true);

  echo "<font size='2' color='red'>".$sources[$build]['imageDescription']."</font>";;
  break;

}
  

?>
