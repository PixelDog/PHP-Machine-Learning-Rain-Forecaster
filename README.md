PHP Machine Learning Rain Forecaster is a simple machine learning experiment in
predicting rain based on a few forecast indicators.: forecasted "HighTemp",
"LowTemp", "AverageTemp", "DewPoint", "DewPointHigh", "DewPointLow", "DewPointAverage",
and forecasted "SeaLevelPressure".

It's just an experiment in Machine Learning. DewPoint seems critical and a great indicator.

I am using the excellent PHP machine learning library for PHP, Rubix ML:
https://rubixml.com/

Just when you thought it was only OK to do machine learning in Python or Java :-)

Samples in weather.csv were built from
https://www.wunderground.com/history
for Portland, Oregon, 1st of every month for 2020

-------------------------------------------------------------------
REQUIREMENTS
-------------------------------------------------------------------
PHP ^7.4

Composer

-------------------------------------------------------------------
INSTALLATION
-------------------------------------------------------------------
1) Clone the repo
2) Run "composer install"

-------------------------------------------------------------------
TESTING / USAGE: machine_learning_rain_prediction.php command line script
-------------------------------------------------------------------

Test:

See the predictions from the weather.csv samples and the unknown
samples in machine_learning_rain_prediction.php. From the command line, run:
php machine_learning_rain_prediction.php

Suggestions for your learning:
1) Play with the data in weather.csv to create your own samples.
Head to https://www.wunderground.com/history and build a sample set
for your city.
2) Build an unknown.csv and load that instead of the hard coded
unknown samples in machine_learning_rain_prediction.php.

Have fun!
