<?php

require '../vendor/autoload.php';

use App\File;

$file = new File([
    'src' => '../public/test.txt',
    'mod' => 'r',
]);
$dstFile = new File([
    'src' => '../public/new_test.txt',
    'mod' => 'c+',
]);
$counter = $file->replaceFile(['Go'], ['Php'], $dstFile);
var_dump($counter);
$file->closeFile();