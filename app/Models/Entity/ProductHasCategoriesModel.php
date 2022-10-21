<?php

namespace App\Models\Entity;
use App\Utils\Database;


class ProductHasCategoriesModel
{
    /**
     * ID da tabela
     * @var integer
     */
    public $id;

    /**
     * ID do Produto
     * @var string
     */
    public $id_product;

    /**
     * ID da Categoria
     * @var string
     */
    public $id_categories;


    /**
     * Responsável por cadastrar a instância atual no database
     * @return boolean
     */
    public function create()
    {
        // Insere o relacionamento no banco
        $this->id = (new Database('product_has_categories'))->insert([
            'id_product' => $this->id_product,
            'id_categories' => $this->id_categories,
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
        // Atualiza os ids de relacionamento no banco
        return (new Database('product_has_categories'))->update('id = '.$this->id,[
            'id_product' => $this->id_product,
            'id_categories' => $this->id_categories,
        ]);
    }











    /**
     * Responsável por retornar produtos
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @param string $fields
     * @return boolean
     */
    public static function checkCategoriesRelation($where = null, $orderBy = null, $limit = null, $join = null,$fields = '*')
    {
        // Deleta o as categorias e produtos da tabela
        return (new Database('product_has_categories'))->select($where, $orderBy, $limit, $join,$fields);
    }

    /**
     * Responsável por deletar o registro de produto da tabela de relacionamento
     * @return boolean
     */
    public static function deleteProductCategories($id_product)
    {
        return (new Database('product_has_categories'))->delete('id_product = '.$id_product);
    }





    /**
     * Responsável por retornar categorias
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @param string $join
     * @param string $fields
     * @return PDOStatement
     */
    public static function getDataRelationships($where = null, $orderBy = null, $limit = null, $join = null,$fields = '*')
    {
        return (new Database('product_has_categories'))->select($where, $orderBy, $limit, $join, $fields);
    }


    /**
     * 
     * @param integer $id
     * @return ProductHasCategoriesModel
     */
    public static function getCategoriesByProductId($where = null)
    {
        return (new Database('product_has_categories'))->select($where);
    }
}