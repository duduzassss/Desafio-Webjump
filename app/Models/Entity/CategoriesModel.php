<?php

namespace App\Models\Entity;
use App\Utils\Database;


class CategoriesModel
{
    /**
     * ID da Categoria
     * @var integer
     */
    public $id;

    /**
     * Nome do Categoria
     * @var string
     */
    public $name;

    /**
     * Code da Categoria
     * @var string
     */
    public $code;


    /**
     * Responsável por cadastrar a instância atual no database
     * @return boolean
     */
    public function create()
    {
        // Insere a categoria no banco
        $this->id = (new Database('categories'))->insert([
            'name' => $this->name,
            'code' => $this->code,
        ]);

        if(isset($this->id) && !empty($this->id))
            return true;
    }



    /**
     * Responsável por atualizar os dados no banco com a instância atual
     * @return boolean
     */
    public function update()
    {
        // Atualiza a categoria no banco
        return (new Database('categories'))->update('id = '.$this->id,[
            'name' => $this->name,
            'code' => $this->code,
        ]);
    }


    /**
     * Responsável por deletar os dados do banco com a instância atual
     * @return boolean
     */
    public function delete()
    {
        // Deleta a categoria do banco
        return (new Database('categories'))->delete('id = '.$this->id);
    }





    /**
     * Responsável por retornar categorias
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getCategories($where = null, $orderBy = null, $limit = null, $join = null,$fields = '*')
    {
        return (new Database('categories'))->select($where, $orderBy, $limit, $join,$fields);
    }


    /**
     * Responsável por obter uma categoria pelo seu ID
     * @param integer $id
     * @return CategoriesModel
     */
    public static function getCategoryById($id)
    {
        return self::getCategories('id = '.$id)->fetchObject(self::class);
    }

    /**
     * Responsável por obter todos os id's de categorias cadastradas em um produto
     * @return array
     */
    public static function getCategoriesByProductId($id_product)
    {
        return (new Database('product_has_categories'))->select('id_product = '.$id_product,null,null,null,'id_categories');
    }
}