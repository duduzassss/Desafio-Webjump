<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

use \App\Utils\View;
use \App\Utils\Environment;
use \App\Utils\Database;


// Carrega variáveis de ambiente
Environment::load(__DIR__.'/../');

// Define as configs do database
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

// Define a constante de URL do projeto
define('URL', getenv('URL'));

// Define o valor padrão das variáveis
View::init([
    'URL' => URL
]);