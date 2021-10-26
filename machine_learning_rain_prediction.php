<?php

include __DIR__ . '/vendor/autoload.php';

use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Kernels\Distance\Manhattan;
use Rubix\ML\Loggers\Screen;
use Rubix\ML\Datasets\Unlabeled;

ini_set('memory_limit', '-1');

$logger = new Screen();

$logger->info('Loading data into memory');

// load known samples
// samples built from:
// https://www.wunderground.com/history
// for Portland, Oregon, 1st of every month for 2020
$extractor = new ColumnPicker(new CSV('weather.csv', true), [
  "HighTemp","LowTemp","AverageTemp","DewPoint","DewPointHigh","DewPointLow",
  "DewPointAverage","SeaLevelPressure","Rain"
]);

// extract data from known samples
$logger->info('Extracting data');
$extracted = Labeled::fromIterator($extractor);

// build labels and samples
$logger->info('Building labels and samples');
$labels = [];
$samples = [];
foreach($extracted->labels() as $label){
  $labels[] = (string)$label;
}
foreach($extracted->samples() as $sample){
  $entry = [];
  foreach($sample as $value){
    $entry[] = (float)$value;
  }
  $samples[] = $entry;
}

// create the data set
$dataset = new Labeled($samples, $labels);

// assign an ml estimator
$estimator = new KNearestNeighbors(5, true, new Manhattan());

// train the estimator with known data
$logger->info('Training estimator');
$estimator->train($dataset);

// unkown samples. This can be loaded in as a CSV as well.
$unKnownSamples = [
    [56,47,51.9,45.68,50,41,45.68,30.15], // Test 2020/01/01 Rain
    [64,38,50.28,38.92,42,35,38.92,30.21], // Test 2020/11/01 No Rain
    [60,40,50,38.92,42,35,38.92,30], // No Rain
    [50,40,45,45.68,50,41,45.68,30.15], // Rain
];

$datasetUnknown = new Unlabeled($unKnownSamples);

// make predictions against unknown samples with the trained estimator
$predictions = $estimator->predict($datasetUnknown);

$logger->info('Rainfall prediction for unknown samples');

$labeled = ["HighTemp","LowTemp","AverageTemp","DewPoint","DewPointHigh","DewPointLow","DewPointAverage","SeaLevelPressure"];
for($i=0; $i<count($predictions); $i++){
  $index = $i + 1;
  $sample = http_build_query(array_combine($labeled, $unKnownSamples[$i]),'',', ');
  print_r("\nUnknown Sample #$index\nForecasted Values:\n");
  print_r($sample);
  print_r("\nPrecipitation Result Expected: " . $predictions[$i]);
  print_r("\n");
}

print_r("\nRain rain go away, come again another day :-)\n\n");
