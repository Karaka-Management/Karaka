<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$fh = fopen('GeoIPCountryWhois.csv', 'r');
$fo = fopen('output.csv', 'w');

function ip2int(string $ip) : float {
    $split = explode('.', $ip);
    return $split[0] * (256 ** 3) + $split[1] * (256 ** 2) + $split[2] * (256 ** 1) + $split[3]; 
}

while (($data = fgetcsv($fh, 150, ",")) !== FALSE) {
    fputcsv($fo, [ip2int($data[0]), ip2int($data[1]), $data[4]]);
}

fclose($fo);
fclose($fh);