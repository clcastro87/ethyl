<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once(__DIR__ . '/../vendor/autoload.php');

$input = new \Ethyl\Pipeline\Input\StreamInput(
    __DIR__ . '/../test/Zulily_Criteo.csv',
    new \Ethyl\Input\CsvFileInput(\Ethyl\Input\CsvFileInput::CSV_DELIMITER_TAB)
);
$output = new \Ethyl\Pipeline\Output(new \Ethyl\Output\DebugOutput());

$mapper  = new \Ethyl\Mapping\ArrayFieldsMapper([
    'id'                      => 'id',
    'title'                   => 'title',
    'description'             => 'description',
    'brand'                   => 'brand',
    'link'                    => 'link',
    'image_link'              => 'image_link',
    'price'                   => 'price',
    'gender'                  => 'gender',
    'availability'            => 'availability',
    'google_product_category' => 'google_product_category',
]);
$closure = function ($item) use ($mapper) {
    return $mapper($item);
};

(new \Ethyl\Pipeline\Pipeline())
    ->setInput($input)
    ->setOutput($output)
    ->pipe(new \Ethyl\Flow\ForEachRun($closure))
    ->run();

exit(0);

$temp    = '/tmp/Output.csv';
$db      = (new \Ethyl\Data\DbFactory())->create('sqlite:' . __DIR__ . '/../test/Zulily.db');
$mapper  = new \Ethyl\Mapping\ArrayFieldsMapper([
                                                    'id'                      => 'id',
                                                    'title'                   => 'title',
                                                    'description'             => 'description',
                                                    'brand'                   => 'brand',
                                                    'link'                    => 'link',
                                                    'image_link'              => 'image_link',
                                                    'price'                   => 'price',
                                                    'gender'                  => 'gender',
                                                    'availability'            => 'availability',
                                                    'google_product_category' => 'google_product_category',
                                                ]);
$closure = function ($item) use ($mapper) {
    return $mapper($item);
};

$pipeline = (new \League\Pipeline\Pipeline())
    ->pipe(new \Ethyl\Input\CsvFileInput(\Ethyl\Input\CsvFileInput::CSV_DELIMITER_TAB))
    ->pipe(new \Ethyl\Flow\ForEachRun($closure))
    ->pipe(new \Ethyl\Output\DebugOutput());
    //->pipe(new \Ethyl\Output\CsvFileOutput($temp));
    //->pipe(new \Ethyl\Output\PdoTableOutput($db, 'products'));

$pipeline->process(__DIR__ . '/../test/Zulily_Criteo.csv');