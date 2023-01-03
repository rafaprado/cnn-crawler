<?php

require 'vendor/autoload.php';

use CnnExplorer\NewsSearcher\Searcher;
$searcher = new Searcher();

$news = $searcher->getFromField('tecnologia');
print_r($news);