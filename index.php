<?php 

require __DIR__ .'/includes/app.php';

use \App\Http\Router;

$router = new Router(URL);

// Inclue as rotas de páginas
include __DIR__ . '/routes/pages.php';

//Imprime o response da rota
$router->run()->sendResponse();