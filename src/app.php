<?php
require_once '../vendor/autoload.php';

use CLI\Test\handlers\ShowArgs;
use GSP\CLI\classes\App;

// init new App
$app = new App();

// register command
$app->bindCommand('show','testing description', new ShowArgs());

// executions with input parameters
$app->execute($argv);
