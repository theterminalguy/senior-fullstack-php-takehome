<?php

namespace Application;

use Application\Service\ResponseCode;

final class Logger
{
    public static function log($args): void
    {
        error_log(print_r($args, true));
    }
}
class SecureSoapServer
{
    const NOT_FOUND = 'Service Not Found';
    const ACTION_NOT_FOUND = 'Action Not Found on Service';

    private $service;
    private $action;
    private $args;

    public function handle($request)
    {
        if ($_SERVER['HTTP_AUTHORIZATION'] != getenv('SOAP_SERVICE_TOKEN')) {
            http_response_code(ResponseCode::UN_AUTHORIZED);
            die(ResponseCode::UN_AUTHORIZED);
        }

        // Log request to help with debugging
        Logger::log($request);

        $request = json_decode($request, true);
        $this->service = "\\Application\Service\\" . $request['service'];
        $this->action = $request['action'];
        $this->args = $request['args'];

        if (!class_exists($this->service)) {
            http_response_code(ResponseCode::NOT_FOUND);
            die(self::NOT_FOUND);
        }

        if (!method_exists($this->service, $this->action)) {
            http_response_code(ResponseCode::NOT_FOUND);
            die(self::ACTION_NOT_FOUND);
        }

        $response = call_user_func_array(
            [
                new $this->service($this->args),
                $this->action
            ],
            []
        );

        return json_encode($response);
    }
}
