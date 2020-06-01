<?php

include_once 'vendor/autoload.php';

$res = fopen('php://stdin', 'r');
$fields = [
    "title", 
    "brand", 
    "link", 
    "image_link",
    "price", 
    "description", 
    "gender", 
    "id", 
    "availability", 
    "google_product_category", 
    "age_group", 
    "size", 
    "color", 
    "adult", 
    "sale_price", 
    "gtin", 
    "mpn"
];
$reader = League\Csv\Reader::createFromStream(STDIN);
$reader->skipInputBOM();
$reader->setDelimiter("\t");
foreach ($reader->getRecords($fields) as $item) {
    var_dump($item);
}


echo 'Memory usage: ' . (memory_get_usage (true) / 1024.0 / 1024.0) . ' MB' . "\n";
