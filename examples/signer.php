<?php

require __DIR__ . '/../tests/bootstrap.php';

// ----------------------------------
// A simple signing-unsigning process
// ----------------------------------
$str = 'example';
$s = new \Hale\Signer('secretkey');
$expected = $s->sign($str);
$actual = $s->unsign($expected);

echo "BASIC\n";
echo "=====\n";
echo "value: {$str}\n";
echo "signed: {$expected}\n";
echo "unsigned: {$actual}\n\n";

// ---------------
// Using timestamp
// ---------------
$str = 'timestamp';
$t = new \Hale\TimestampSigner('secretkey');
$expected = $t->sign($str);
$actual = $t->unsign($expected);

echo "TIMESTAMP\n";
echo "=========\n";
echo "value: {$str}\n";
echo "signed: {$expected}\n";
echo "unsigned: {$actual}\n\n";

// ---------------------------
// Using timestamp and max age
// ---------------------------
$str = 'limited';
$t = new \Hale\TimestampSigner('secretkey');
$expected = $t->sign($str);

$sleep = 2;
echo "[going to sleep {$sleep} seconds]\n";
sleep($sleep);

echo "value: {$str}\n";
echo "signed: {$expected}\n";
try {
    $actual = $t->unsign($expected, $sleep - 1);
} catch (\Hale\SignatureExpiredException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
