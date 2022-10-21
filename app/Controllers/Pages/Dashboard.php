<?php 

namespace App\Controllers\Pages;

use App\Utils\View;
use App\Models\Entity\ProductsModel;

use App\Utils\Logs;


class Dashboard extends Template
{

    /**
     * Responsável pela rendereização dos itens no Dashboard
     * @return string
     */
    private static function getDashboardItems()
    {
        $itens = '';

        // Resultados
        $results = ProductsModel::getProducts(null, 'id DESC');
        

        // Renderiza os itens
        while($products = $results->fetchObject(ProductsModel::class))
        {
            $itens .= View::render('Pages/Dashboard/item', [
                "id"          => $products->id,
                "name"        => $products->name,
                "price"       => $products->price,
                
                "image"       => !empty($products->image) ? $products->image : URL.'/public/assets/images/product/default-product.png'

            ]);
        }

        return $itens;
    }



    /**
     * Método para retornar o conteúdo [view] da página Dashboard
     * @return string
     */
    public static function getDashboard()
    {
        $itens = '';
        $objectProducts = new ProductsModel();
        $results = ProductsModel::getProducts(null, 'id DESC');

        $total_products = ProductsModel::countProducts();
       
        $itens .= View::render('Pages/Dashboard/dashboard', [
            'list_products' => self::getDashboardItems(),
            'total_products'       => $total_products
        ]);
    

        return self::getTemplate('Webjump | Backend Test | Dashboard', $itens);
    }


}
