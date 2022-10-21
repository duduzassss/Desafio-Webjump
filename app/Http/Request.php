<?php

namespace App\Http;

class Request
{

    /**
     * Instância do Router
     * @var Router
     */
    private $router;

    /**
     * Método HTTP da requisição
     * @var string
     */
    private $httpMethod;

    /**
     * URI da página
     * @var string
     */
    private $uri;

    /**
     * Parâmetros GET da URL
     * @var array
     */
    private $params = [];

    /**
     * Variáveis recebidas pelo método POST
     * @var array
     */
    private $postVariables = [];

    /**
     * Headers da requisição
     * @var array
     */
    private $headers = [];


    /**
     * Construtor da classe
     */
    public function __construct($router)
    {
        $this->router        = $router;
        $this->httpMethod    = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->headers       = getallheaders();
        $this->params        = $_GET ?? [];
        $this->postVariables = $_POST ?? [];
        $this->setUri();
    }


    /**
     * Responsável por definir a URI
     */
    private function setUri()
    {
        // URI completa (com parâmetros get)
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        // Remove parâmetros get da URI
        $explodeUri = explode('?', $this->uri);
        $this->uri = $explodeUri[0];
    }



    /**
     * Retorna o método HTTP da requisição
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Retorna a URI da requisição
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Retorna os parâmetros GET da requisição
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Retorna as variáveis POST da requisição
     * @return array
     */
    public function getPostVariables()
    {
        return $this->postVariables;
    }
    
    /**
     * Retorna os headers da requisição
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    /**
     * Responsável por retornar  a instância de router
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

}