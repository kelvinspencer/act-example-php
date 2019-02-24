<?php
print "hi";
print $_REQUEST['code'];

print "Starting ...\n";
print "ENV vars:\n";

print $_ENV[APIFY_CONTAINER_URL];
print "...\n";

//print_r($_ENV);

//Fetch universe client id and client secret from keystore
//$universe_cred_url = 'https://api.apify.com/v2/key-value-stores?token='+$_ENV[APIFY_TOKEN]+'&name=my-store-name';
$url = 'https://api.apify.com/v2/key-value-stores/storeId/records/recordKey?disableRedirect=&token='.$_ENV[APIFY_TOKEN];
$data = getUrl($url);
print_r( $data );

//Save to keystore
//https://api.apify.com/v2/key-value-stores?token=eqMr5hwRGiyFuhZgiRwTyppos&name=my-store-name


function getUrl($url){
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);

  $response = curl_exec($ch);
  curl_close($ch);

  //var_dump($response);
  return $response;
}

// print "Fetching http://example.com ...\n";
// $exampleComHtml = file_get_contents('http://example.com');
// print "Searching for <h1> tag contents ...\n";
// preg_match_all('/<h1>(.*?)<\/h1>/', $exampleComHtml, $matches);
// print "Found: " . $matches[1][0] . "\n";
// print "I am done!\n";



