<?php

namespace App\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use \App\Utils\Environment;


class Logs
{
    public function logger($msg, $mode = 'info')
    {
        $logger = new Logger('desafio');
        $logger->pushHandler(new StreamHandler(dirname(__FILE__).'../../../logs/logs.txt'));

        switch ($mode) {
            case 'info':
                $logger->info($msg);
                break;
            case 'warning':
                $logger->warning($msg);
                break;
            case 'error':
                $logger->error($msg);
                break;
            case 'debug':
                $logger->debug($msg);
                break;
            case 'notice':
                $logger->notice($msg);
                break;
            case 'emergency':
                $logger->emergency($msg);
                break;
            case 'alert':
                $logger->alert($msg);
                break;
            default:
                $logger->info($msg);
                break;
        }
    }
}