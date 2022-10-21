<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;


class Router
{
    /**
     * URL raiz do projeto
     * @var string 
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Indice de rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instância de Request
     * @var Request
     */
    private $request;

    /**
     * Responsável por iniciar a classe
     * @param string $url
     */
    public function __construct($url)
    {
        $this->request = new Request($this);
        $this->url     = $url;
        $this->setPrefix();
    }

    /**
     * Responsável por definir o prefixo das nossas rotas
     */
    private function setPrefix()
    {
        // Informações da url atual
        $parseUrl =  parse_url($this->url);
        
        
        // Define o prefixo
        $this->prefix = $parseUrl['path'] ?? '';
    }


    /**
     * Responsável por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route, $params = [])
    {
        // Validação dos parametros
        foreach($params as $key=>$val)
        {
            if($val instanceof Closure)
            {
                // Altera o valor da chave ($key), para o indice se chamar 'controller'
                $params['controller'] = $val;
                unset($params[$key]);
                continue;
            }
        }

        // Variáveis da rota
        $params['variables'] = [];
        
        // Padrão de validação das variáveis das rotas
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches))
        {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }


        // Padrão de validação da URL, utilizando expressão regular.
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';


        // Adiciona a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;

    }


    /**
     * Responsável por definir uma rota do tipo GET
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = [])
    {
        $this->addRoute('GET', $route, $params);
    }

    /**
     * Responsável por definir uma rota do tipo POST
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = [])
    {
        $this->addRoute('POST', $route, $params);
    }


    /**
     * Responsável por definir uma rota do tipo PUT
     * @param string $route
     * @param array $params
     */
    public function PUT($route, $params = [])
    {
        $this->addRoute('PUT', $route, $params);
    }

    /**
     * Responsável por definir uma rota do tipo DELETE
     * @param string $route
     * @param array $params
     */
    public function delete($route, $params = [])
    {
        $this->addRoute('DELETE', $route, $params);
    }



    /**
     * Responsável por retornar a URI desconsiderando o prefixo
     * @return string
     */
    private function getUri()
    {
        // URI do request
        $uri = $this->request->getUri();
        
        
        // Divide (fatia) a URI com o prefixo
        $explodeUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        // Retorna o último indice do array, URI sem prefixo
        return end($explodeUri);
    }

    /**
     * Responsável por retornar os dados da rota atual
     * @return array
     */
    private function getRoute()
    {
        // URI
        $uri = $this->getUri();

        // Method
        $httpMethod = $this->request->getHttpMethod();
        
        // Valida as rotas
        foreach($this->routes as $patternRoute=>$methods)
        {
            // Verifica se a rota bate com o padrão
            if(preg_match($patternRoute, $uri, $matches))
            {
                // Verifica o method
                if(isset($methods[$httpMethod]))
                {
                    // Remove a primeira posição. (URL completa)
                    unset($matches[0]);

                    // Variáveis processadas
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;


                    // Retorna os parâmetros das rotas.
                    return $methods[$httpMethod];
                }

                // Método não permitido
                throw new Exception("Método não permitido", 405);
                
            }            
        }

        // Url não encontrada
        throw new Exception("URL não encontrada", 404);

    }

    /**
     * Responsável por executar a rota atual
     * @return Response
     */
    public function run()
    {
        try {
           
            // Recebe a rota atual
            $route = $this->getRoute();

            // Verifica o controlador
            if(!isset($route['controller']))
            {
                throw new Exception("URL não pode ser processada", 500);
            } 

            // Argumentos da função
            $args= [];

            // Reflection
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter)
            {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }


            // Retorna a execução da função
            return call_user_func_array($route['controller'], $args);
            
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Responsável por retornar a url atual
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url.$this->getUri();
    }

    /**
     * Responsável por redirecionar a URL
     * @param string $route
     */
    public function redirect($route)
    {
        // URL
        $url = $this->url.$route;

        // Executa o redirect
        header('location: '.$url);
        exit;
    }   
}