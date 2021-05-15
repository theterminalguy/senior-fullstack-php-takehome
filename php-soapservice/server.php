<?php

require_once 'vendor/autoload.php';
require_once 'config/DotEnv.php';

use Application\config\DotEnv;

(new DotEnv())->load();

$options = [
    'uri' => getenv('SOAP_SERVICE_HOST')
];

$server = new SoapServer(null, $options);
$server->setClass('\Application\SecureSoapServer');
$server->handle();

