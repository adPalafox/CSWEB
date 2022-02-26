<?php

$str = "kenneth";

echo "String: {$str} <br>";

$encoded = base64_encode($str);

echo "Encoded: {$encoded} <br>";

$decoded = base64_decode($encoded);

echo "\nDecoded: {$decoded} <br>";
?>