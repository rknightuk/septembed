<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Phpfastcache\Helper\Psr16Adapter;

$Psr16Adapter = new Psr16Adapter('Files');

$Psr16Adapter->clear();