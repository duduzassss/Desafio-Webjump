<?php

namespace App\Http;

class Response
{
    /**
     * Status code do response da requisição
     * @var integer
     */
    private $httpStatusCode = 200;

    /**
     * Header do response
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo retornado
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do response
     * @var mixed
     */
    private $content;

    /**
     * Construtor, responsável pela inicialização  da classe e definição dos valores
     * @param integer $httpStatusCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpStatusCode, $content, $contentType = 'text/html')
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->content        = $content;
        $this->setContentType($contentType);
    }

    /**
     * Altera o tipo de conteúdo do response
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType    = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Adiciona um registro ao headers do response
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }


    /**
     * Responsável por enviar os headers ao browser
     */
    private function sendHeaders()
    {
        // Status code
        http_response_code($this->httpStatusCode);

        // Envia os Headers
        foreach($this->headers as $key=>$val)
        {
            header($key. ':' .$val);
        }
    }


    /**
     * Responsável por enviar a resposta ao usuário
     */
    public function sendResponse()
    {
        // Envia os headers
        $this->sendHeaders();

        // Imprime o conteúdo
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }

}