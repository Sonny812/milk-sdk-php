<?php
require __DIR__ . "/../vendor/autoload.php";

use HiFolks\Milk\Here\Xyz\Space\XyzSpace;

function print_row($item, $key)
{
    echo $key + 1 . " " . $item->id . " " . $item->owner . " " . $item->title . "\n";
}


Dotenv\Dotenv::createImmutable(__DIR__ . "/../")->load();
$xyzToken = $_ENV['XYZ_ACCESS_TOKEN'];


$space = XyzSpace::instance($xyzToken);
echo "GET" . PHP_EOL;
/** @var $s HiFolks\Milk\Here\Xyz\Common\XyzResponse */
$s = $space->get();
if ($s->isError()) {
    echo "Error: " . $s->getErrorMessage();
} else {
    echo $space->getUrl();
    $space->debug();
    $a = $s->getData();
    array_walk($a, 'print_row');
    $string = $s->getDataAsJsonString();
    var_dump($string);
}




echo "GET OWNER ALL" . PHP_EOL;
$space->reset();
$a =  $space->ownerAll()->getLimited(2);

$space->debug();
array_walk($a, 'print_row');


echo "GET OTHERS" . PHP_EOL;
$space->reset();
$s =  $space->ownerOthers()->getLimited(2);
array_walk($s, 'print_row');

echo "GET INCLUDE RIGHTS" . PHP_EOL;
$space->reset();
$s =  $space->ownerOthers()->includeRights()->getLimited(2);
array_walk($s, 'print_row');
$space->debug();

$space->reset();
$time_start = microtime(true);
$space->get();
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
$time_start = microtime(true);
$space->cacheResponse()->get();
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
$time_start = microtime(true);
$space->cacheResponse()->get();
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
