#!/usr/bin/php
<?
$mediaPaths['tempFiles']  = "/tmp/mediabuild";
$mediaPaths['sourcesURL'] = "https://raw.githubusercontent.com/Squidly271/mediabuild-sources/master/sources";
$mediaPaths['sources'] = $mediaPaths['tempFiles']."/sources.json";

# set to true for separate menus, or false for all in one

$separate = true;



function download_url($url, $path = "", $bg = false){
  exec("curl --max-time 60 --silent --insecure --location --fail ".($path ? " -o '$path' " : "")." $url ".($bg ? ">/dev/null 2>&1 &" : "2>/dev/null"), $out, $exit_code );
  return ($exit_code === 0 ) ? implode("\n", $out) : false;
}

exec('mkdir -p "'.$mediaPaths['tempFiles'].'"');

download_url($mediaPaths['sourcesURL'],$mediaPaths['sources']);

$sources = json_decode(file_get_contents($mediaPaths['sources']),true);
print_r($sources);
$i = 0;
foreach ($sources as $source)
{
  $source['id'] = $i;
  if ( $source['imageType'] == "unRaid" )
  {
    $buttons['unRaid']['name'] = "unRaid";
    $buttons['unRaid']['builds'][] = $source;
  } else {
    if ( $separate )
    {
      $buttons[$source['imageType']]['name'] = $source['imageType'];
      $buttons[$source['imageType']]['builds'][] = $source;
    } else {
      $buttons['MediaBuilds']['name'] = "Media Builds";
      $buttons['MediaBuilds']['builds'][] = $source;
    }
  }
  $i = ++$i;
}

foreach ( $buttons as $button )
{
  if ( $button['name'] == "unRaid" )
  {
    $buttonName = "Stock UnRaid Builds";
  } else {
    $buttonName = $button['name']." Media Build";
  }

  $o .= $buttonName.": ";
  $o .= "<select>";

  foreach ($button['builds'] as $option)
  {
    $o .= "<option value='".$option['id']."'>".$option['imageType']." ".$option['imageVersion']."</option>";
  }
  $o .= "</select>";
}
echo $o;
















?>
