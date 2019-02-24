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
//$url = 'https://api.apify.com/v2/key-value-stores/storeId/records/recordKey?disableRedirect=&token='.$_ENV[APIFY_TOKEN];
//$url ='https://api.apify.com/v2/key-value-stores?token='.$_ENV[APIFY_TOKEN].'&offset=10&limit=99&desc=true&unnamed=true';
//$data = getUrl($url);
//print_r( $data );

//Save to keystore
//https://api.apify.com/v2/key-value-stores?token=eqMr5hwRGiyFuhZgiRwTyppos&name=my-store-name
$data['$storeID'] = '';
$data['recordKey'] = '';
$data['token'] = $_ENV[APIFY_TOKEN];
saveKey($data);

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


function createStore($keyname){
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "https://api.apify.com/v2/key-value-stores?name=".$keyname);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);

  $response = curl_exec($ch);
  curl_close($ch);

  //var_dump($response);
}


function saveKey($data){
  $ch = curl_init();
  $storeID = $data['$storeID'];
  $recordKey = $data['recordKey'];
  $token = $data['token'];
  
  $keyname = 'foo';
  $keyvalue = 'bar';
  
  curl_setopt($ch, CURLOPT_URL, "https://api.apify.com/v2/key-value-stores/".$storeID."/records/".$recordKey."?token=".$token);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

  curl_setopt($ch, CURLOPT_POSTFIELDS, "{
    \"".$keyname."\": \"".$keyvalue."\"
  }");

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json"
  ));

  $response = curl_exec($ch);
  curl_close($ch);
}

// print "Fetching http://example.com ...\n";
// $exampleComHtml = file_get_contents('http://example.com');
// print "Searching for <h1> tag contents ...\n";
// preg_match_all('/<h1>(.*?)<\/h1>/', $exampleComHtml, $matches);
// print "Found: " . $matches[1][0] . "\n";
// print "I am done!\n";



