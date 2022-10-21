<?php 

namespace App\Controllers\Pages;

use App\Utils\View;
use App\Models\Entity\ProductsModel;
use App\Models\Entity\ProductHasCategoriesModel;
use App\Models\Entity\CategoriesModel;

use App\Utils\FlashMessage;
use App\Utils\Logs;

use Respect\Validation\Validator as v;



class Products extends Template
{

    /**
     * Responsável pela rendereização dos itens_categories de produtos
     * @return string
     */
    private static function getProductCategoriesItems($id)
    {
        $itens = '';

        // Resultados do relacionamento
        $results = ProductHasCategoriesModel::getDataRelationships('products.id ='.$id,null,null,
            'JOIN products ON product_has_categories.id_product = products.id
            JOIN categories ON product_has_categories.id_categories = categories.id',
            'categories.name as category_name'
        );


        // Renderiza os itens
        while($categories = $results->fetchObject(ProductHasCategoriesModel::class))
        {
            
            $itens .= View::render('Pages/Products/itemCategories', [
                "id"            => $categories->id ?? '',
                "category_name" => $categories->category_name ?? '',
                "id_product"    => $categories->id_product ?? '',
                "id_categories" => $categories->id_categories ?? ''
            ]);
        }

        return $itens;
    }












    /**
     * Responsável pela rendereização dos itens de produtos
     * @return string
     */
    private static function getProductItems()
    {
        $itens = '';

        // Resultados
        $results = ProductsModel::getProducts(null, 'id DESC');
    

        // Renderiza os itens
        while($products = $results->fetchObject(ProductsModel::class))
        {
            $itens .= View::render('Pages/Products/item', [
                "id"          => $products->id,
                "sku"         => $products->sku,
                "name"        => $products->name,
                "description" => $products->description,
                "quantity"    => $products->quantity,
                "price"       => $products->price,

                "categories" => self::getProductCategoriesItems($products->id),
            ]);
        }

        return $itens;
    }

    /**
     * Método para retornar o conteúdo [view] da página Products
     * @return string
     */
    public static function getProducts()
    {

        $objectProducts = new ProductsModel();

        $content = View::render('Pages/Products/index', [
            'itens' => self::getProductItems(),
        ]);

        return self::getTemplate('Products | Webjump', $content);
    }





    /**
     * Responsável pela renderização dos itens do select de categorias.
     * @return string
     */

    public static function getItemsSelectCategories($id_product = null)
    {
        $itens = '';

        // Resultados
        $results = CategoriesModel::getCategories(null, 'id DESC');


        // Renderiza os itens
        while($categories = $results->fetchObject(CategoriesModel::class))
        {
            
            $itens .= View::render('Pages/Products/itemSelectCategories', [
                "category_id"          => $categories->id,
                "category_name"        => $categories->name,
                "selected" => self::getSelectedsItemsProduct($id_product, $categories->id)
            ]);
        }

        return $itens;
    }


    /**
     * Responsável por renderizar a página de criação de produto
     * @return string
     */
    public static function getNewProduct()
    {
        $content = View::render('Pages/Products/add', [
            'title' => 'Create new product',
            'select_categories' => self::getItemsSelectCategories(),

        ]);

        return self::getTemplate('Products | Webjump', $content);
    }


    /**
     * Responsável por cadastrar um produto
     * @param Request
     * @return string
     */
    public static function setNewProduct($request)
    {
        $logger = new Logs;

        try {
            // Dados do post
            $postVariables = $request->getPostVariables();

            // Nova instância de Produtos
            $newProduct = new ProductsModel;

            if(isset($postVariables['sku']) && !empty($postVariables['sku']))
                $newProduct->sku = $postVariables['sku'];
            
            if(isset($postVariables['name']) && !empty($postVariables['name']))
                $newProduct->name = $postVariables['name'];

            if(isset($postVariables['description']) && !empty($postVariables['description']))
                $newProduct->description = $postVariables['description'];

            if(isset($postVariables['quantity']) && !empty($postVariables['quantity']))
                $newProduct->quantity = $postVariables['quantity'];

            if(isset($postVariables['price']) && !empty($postVariables['price']))
                $newProduct->price = $postVariables['price'];

            if(isset($postVariables['categories']) && !empty($postVariables['categories']))
                $newProduct->categories = $postVariables['categories'];


            if(isset($postVariables['image']) && !empty($postVariables['image']))
                $newProduct->image = $postVariables['image'];
            


            if($newProduct->create())
            {
                $logger->logger('Product ['.$newProduct->name.'] created in the database.');
            }

            return $request->getRouter()->redirect('/products/'.$newProduct->id.'/edit');

        } catch (\Exception $e) {
            $logger->logger($e->getMessage(), 'error');
            return $request->getRouter()->redirect('/products');
        }
        

    }






    /**
     * Responsável por retornar à instância, se uma categoria pertence ou não ao produto atual.
     * @return string
     */
    private static function getSelectedsItemsProduct($id_product, $id_category)
    {
        if($id_product)
        {
            // Resultados
            $categories = ProductHasCategoriesModel::getCategoriesByProductId('id_product = '.$id_product);
            $results_categories = $categories->fetchAll(\PDO::FETCH_OBJ);
    
            $arrayCategoriesProduct = [];
            foreach($results_categories as $key=>$category)
            {
                array_push($arrayCategoriesProduct, $category->id_categories);
            }
    
            if(in_array($id_category, $arrayCategoriesProduct))
            {
                return 'selected = "selected"';
            } else{
                return '';
            }
        }
    }


    /**
     * Responsável por renderizar a página de edição de produto
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditProduct($request, $id)
    {
        // Obtem o produto do banco de dados
        $product = ProductsModel::getProductById($id);

        // Validação da instância
        if(!$product instanceof ProductsModel)
        {
            $request->getRouter()->redirect('/products');
        }

        // Conteúdo do formulário
        $content = View::render('Pages/Products/edit', [
            'sku'         => $product->sku,
            'name'        => $product->name,
            'description' => $product->description,
            'quantity'    => $product->quantity,
            'price'       => $product->price,

            'image'       => URL.'/'.$product->image,
            'select_categories' => self::getItemsSelectCategories($id),
        ]);

        return self::getTemplate('Edit Product | Webjump', $content);
    }

    /**
     * Responsável por gravar a edição de um produto
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditProduct($request, $id)
    {
        $logger = new Logs;

        try {
            // Obtem o produto do banco de dados
            $product = ProductsModel::getProductById($id);
    
            // Validação da instância
            if(!$product instanceof ProductsModel)
            {
                $request->getRouter()->redirect('/products');
            }
    
            // Post variables
            $postVariables = $request->getPostVariables();
    
            // Atualiza dados
            // Se existir nas variáveis post enviadas, atualiza. Senão continua com a atual
            $product->sku = $postVariables['sku'] ?? $product->sku;
            $product->name = $postVariables['name'] ?? $product->name;
            $product->description = $postVariables['description'] ?? $product->description;
            $product->quantity = $postVariables['quantity'] ?? $product->quantity;
            $product->price = $postVariables['price'] ?? $product->price;
            
            $product->categories = $postVariables['categories'] ?? $product->categories;
    
            $product->image = $postVariables['image'] ?? $product->image;
            
            
            if($product->update())
            {
                $logger->logger('Product ['.$product->name.'] updated in the database.');
            }
    
            return $request->getRouter()->redirect('/products/'.$product->id.'/edit');

        } catch (\Exception $e) {
            $logger->logger($e->getMessage(), 'error');
            return $request->getRouter()->redirect('/products');
        }
    }



    /**
     * Responsável por renderizar a página de delete de um produto
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteProduct($request, $id)
    {
        // Obtem o produto do banco de dados
        $product = ProductsModel::getProductById($id);

        // Validação da instância
        if(!$product instanceof ProductsModel)
        {
            $request->getRouter()->redirect('/products');
        }

        // Conteúdo do formulário
        $content = View::render('Pages/Products/delete', [
            'sku' => $product->sku,
            'name' => $product->name,
            'description' => $product->description,
            'quantity' => $product->quantity,
            'price' => $product->price,
        ]);

        return self::getTemplate('Delete Product | Webjump', $content, 'products');
    }


    /**
     * Responsável por deletar um produto
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteProduct($request, $id)
    {
        $logger = new Logs;

        try {
            // Obtem o produto do banco de dados
            $product = ProductsModel::getProductById($id);
    
            // Validação da instância
            if(!$product instanceof ProductsModel)
            {
                $request->getRouter()->redirect('/products');
            }
    
            // Exclui o produto da tabela de relacionamentos
            if(ProductHasCategoriesModel::deleteProductCategories($id))
            { 
                // Exclui o produto
                if($product->delete())
                {
                    $logger->logger('Product ['.$product->name.'] deleted from database.');
                }
            }
            
            // Redirect
            $request->getRouter()->redirect('/products');

        } catch (\Exception $e) {
            $logger->logger($e->getMessage(), 'error');
            return $request->getRouter()->redirect('/products');
        }
    }
}
