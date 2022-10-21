<?php 

namespace App\Controllers\Pages;

use App\Utils\View;

class Template
{

    /**
     * Renderiza o topo da página genérica
     * @return string
     */
    public static function getHeaderTemplate()
    {
        return View::render('Partials/header');
    }

    /**
     * Renderiza o rodapé da página genérica
     * @return string
     */
    public static function getFooterTemplate()
    {
        return View::render('Partials/footer');
    }

    /**
     * Método para retornar o conteúdo [view] para a página genérica
     * @return string
     */
    public static function getTemplate($title, $content)
    {
        return View::render('Pages/template', [
            'title'     => $title,
            'header'    => self::getHeaderTemplate(),
            'content'   => $content,
            'footer'    => self::getFooterTemplate()
        ]);
    }


}
