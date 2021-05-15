<?php

namespace Application;

require_once 'vendor/autoload.php';

use SoapServer;

use Application\config\DotEnv;

(new DotEnv())->load();

final class Logger
{
    public static function log($args): void
    {
        error_log(print_r($args, true));
    }
}

$options = [
    'uri' => getenv('SOAP_SERVICE_HOST')
];

$server = new SoapServer(null, $options);
$server->setClass('SecureSoapServer');
$server->handle();
