<?php

use Ethyl\Flow\ForEachRun;
use Ethyl\Input\CsvFileInput;
use Ethyl\Input\CsvStreamInput;
use Ethyl\IO\FilesystemBuilder;
use Ethyl\Mapping\ArrayFieldsMapper;
use Ethyl\Output\DebugOutput;
use Ethyl\Pipeline\Input\StreamInput;
use Ethyl\Pipeline\Output;
use Ethyl\Pipeline\Pipeline;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once(__DIR__ . '/../vendor/autoload.php');

$filesystem = FilesystemBuilder::build('local', 'local', '/');
$stream = $filesystem->readStream(__DIR__ . '/../test/Zulily_Criteo.csv');

$input = new StreamInput(
    $stream,
    new CsvStreamInput(CsvFileInput::CSV_DELIMITER_TAB)
);
$output = new Output(new DebugOutput());

$mapper  = new ArrayFieldsMapper([
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

(new Pipeline())
    ->setInput($input)
    ->setOutput($output)
    ->pipe(new ForEachRun($closure))
    ->run();

exit(0);
