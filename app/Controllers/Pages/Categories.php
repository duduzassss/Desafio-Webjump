<?php 

namespace App\Controllers\Pages;


use App\Utils\View;
use App\Models\Entity\CategoriesModel;
use App\Models\Entity\ProductHasCategoriesModel;
use App\Utils\Logs;

class Categories extends Template
{


    /**
     * Responsável pela rendereização dos itens de categorias
     * @return string
     */
    private static function getCategoryItems()
    {
        $itens = '';

        // Resultados
        $results = CategoriesModel::getCategories(null, 'id DESC');

        // Renderiza os itens
        while($categories = $results->fetchObject(CategoriesModel::class))
        {
            $itens .= View::render('Pages/Categories/item', [
                "id"          => $categories->id,
                "name"        => $categories->name,
                "code"        => $categories->code,
            ]);
        }

        return $itens;
    }

    /**
     * Método para retornar o conteúdo [view] da página Categories
     * @return string
     */
    public static function getCategories()
    {
        
        $objectCategories = new CategoriesModel();

        $content = View::render('Pages/Categories/index', [
            'itens' => self::getCategoryItems()
        ]);

        return self::getTemplate('Categories | Webjump', $content);
    }



    /**
     * Responsável por renderizar a página de criação de Categoria
     * @return string
     */
    public static function getNewCategory()
    {
        $content = View::render('Pages/Categories/add', [
            'title' => 'Create new Category'
        ]);

        return self::getTemplate('Categories | Webjump', $content);
    }


    /**
     * Responsável por cadastrar uma Categoria
     * @param Request
     * @return string
     */
    public static function setNewCategory($request)
    {
        $logger = new Logs;

        try {
            // Dados do post
            $postVariables = $request->getPostVariables();

            // Nova instância de Categorias
            $newCategory = new CategoriesModel;
            
            if(isset($postVariables['name']) && !empty($postVariables['name']))
                $newCategory->name = $postVariables['name'];

            if(isset($postVariables['code']) && !empty($postVariables['name']))
                $newCategory->code = $postVariables['code'];


            if($newCategory->create())
            {
                
                $logger->logger('Category ['.$postVariables['name'].'] registered with in the database.');
            }

            return $request->getRouter()->redirect('/categories/'.$newCategory->id.'/edit');
        } catch (\Exception $e) {
            $logger->logger($e->getMessage(), 'error');
            return $request->getRouter()->redirect('/categories');
        }
        
    }




    /**
     * Responsável por renderizar a página de edição de categoria
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditCategory($request, $id)
    {
        // Obtem o produto do banco de dados
        $category = CategoriesModel::getCategoryById($id);

        // Validação da instância
        if(!$category instanceof CategoriesModel)
        {
            $request->getRouter()->redirect('/categories');
        }

        // Conteúdo do formulário
        $content = View::render('Pages/Categories/edit', [
            'name' => $category->name,
            'code' => $category->code,
        ]);

        return self::getTemplate('Edit Category | Webjump', $content);
    }

    /**
     * Responsável por gravar a edição de uma categoria
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditCategory($request, $id)
    {
        $logger = new Logs;

        try {
            // Obtem o produto do banco de dados
            $category = CategoriesModel::getCategoryById($id);
    
            // Validação da instância
            if(!$category instanceof CategoriesModel)
            {
                $request->getRouter()->redirect('/categories');
            }
    
            // Post variables
            $postVariables = $request->getPostVariables();
    
            // Atualiza dados
            // Se existir nas variáveis post enviadas, atualiza. Senão continua com a atual
            $category->name = $postVariables['name'] ?? $category->name;
            $category->code = $postVariables['code'] ?? $category->code;
            
            if($category->update())
            {
                $logger->logger('Category ['.$category->name.'] updated in the database.');
            }
    
            return $request->getRouter()->redirect('/categories/'.$category->id.'/edit');

        } catch (\Exception $e) {
            $logger->logger($e->getMessage(), 'error');
            return $request->getRouter()->redirect('/categories');
        }
    }



    /**
     * Responsável por renderizar a página de delete de uma categoria
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteCategory($request, $id)
    {
        // Obtem a categoria do banco de dados
        $category = CategoriesModel::getCategoryById($id);

        // Validação da instância
        if(!$category instanceof CategoriesModel)
        {
            $request->getRouter()->redirect('/categories');
        }

        // Conteúdo do formulário
        $content = View::render('Pages/Categories/delete', [
            'name' => $category->name,
            'code' => $category->code,
        ]);

        return self::getTemplate('Delete Category | Webjump', $content, 'categories');
    }


    /**
     * Responsável por deletar uma categoria
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteCategory($request, $id)
    {
        $logger = new Logs;

        try {
            // Obtem a categoria do banco de dados
            $category = CategoriesModel::getCategoryById($id);
    
            // Validação da instância
            if(!$category instanceof CategoriesModel)
            {
                $request->getRouter()->redirect('/categories');
            }
            
            // Verifica se a categoria não está relacionada com um produto
            $isRelated = ProductHasCategoriesModel::checkCategoriesRelation('id_categories = '.$id);
            $results = $isRelated->fetchObject(ProductHasCategoriesModel::class);

            // Permite excluir somente se a categoria não conter relacionamento.
            if(empty($results))
            {
                // Exclui a categoria
                if($category->delete())
                {
                    $logger->logger('Category ['.$category->name.'] updated in the database.');
                    return $request->getRouter()->redirect('/categories');
                }
            } else {
                $logger->logger('The category ['.$category->name.'] cannot be deleted because it is being used in one or more products.', 'warning');

                // Redirect
                return $request->getRouter()->redirect('/categories');

            }

        } catch (\Exception $e) {
            $logger->logger($e->getMessage(), 'error');
            return $request->getRouter()->redirect('/categories');
        }
    }
}
