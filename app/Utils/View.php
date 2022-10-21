<?php

namespace App\Utils;

class View 
{
    /**
     * Variáveis padrões da view
     * @var array
     */
    private static $variables = [];

    /**
     * Responsável por definir os dados iniciais da classe
     * @param array $variables
     */
    public static function init($variables)
    {
        self::$variables = $variables;
    }

    /**
     * Retorna o conteúdo de uma view
     * @param string $view
     * @param array $variables
     * @return string
     */
    public static function getDataView($view)
    {   
        $file = __DIR__ . '/../../public/Views/'.$view.'.php';

        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Retorna o conteúdo renderizado de uma view
     * @param string $view
     * @return string
     */
    public static function render($view, $variables = [])
    {
        // View Data
        $viewData = self::getDataView($view);

        // Merge de variáveis da view
        $variables = array_merge(self::$variables, $variables);

        $arrayKeys = array_keys($variables); # Pega as chaves(key) do array
        
        // Mapeia as chaves do array para formatar as variáveis, exemplo: {{name}}
        $arrayKeys = array_map(function($item) {
            return '{{'.$item.'}}';
        }, $arrayKeys);

        // Return render content
        return str_replace($arrayKeys, array_values($variables), $viewData);
    }

}