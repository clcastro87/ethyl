<?php

include_once(__DIR__ . '/../vendor/autoload.php');

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
    //->pipe(new \Ethyl\Output\DebugOutput());
    //->pipe(new \Ethyl\Output\CsvFileOutput($temp));
    ->pipe(new \Ethyl\Output\PdoTableOutput($db, 'products'));

$pipeline->process(__DIR__ . '/../test/Zulily_Criteo.txt');