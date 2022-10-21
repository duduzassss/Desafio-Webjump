<?php

namespace App\Models\Entity;
use App\Utils\Database;

use App\Models\Entity\ProductHasCategoriesModel;



class ProductsModel
{
    /**
     * ID do Produto
     * @var integer
     */
    public $id;

    /**
     * Nome do Produto
     * @var string
     */
    public $name;
    
    /**
     * SKU [Código] do Produto
     * @var string
     */
    public $sku;

    /**
     * Descrição do Produto
     * @var string
     */
    public $description;

    /**
     * Quantidade do Produto
     * @var integer
     */
    public $quantity;

    /**
     * Preço do produto
     * @var float
     */
    public $price;

    /**
     * Categorias do produto
     * @var array
     */
    public $categories;


    /**
     * Imagem do produto
     * @var string
     */
    public $image;


    /**
     * Insere no banco de dados as categorias do produto
     */
    private function insertCategoriesProduct($product_id,$categories)
    {

        foreach($categories as $key=>$category)
        {   
            $insertCategories = (new Database('product_has_categories'))->insert([
                'id_product'    => $product_id,
                'id_categories' => $category
            ]);

        }
    }

    /**
     * Atualiza no banco de dados as categorias do produto
     */
    private function updateCategoriesProduct($product_id,$categories)
    {

        foreach($categories as $key=>$category)
        {   
            $updateCategories = (new Database('product_has_categories'))->update('id_product = '.$this->id,[
                'id_product'    => $product_id,
                'id_categories' => $category
            ]);

        }
    }









    /**
     * Responsável por fazer o upload da imagem no diretório e retornar o path da mesma, criando o arquivo com um valor único.
     * @return string
     */
    private function setImageProduct($dir, $file)
    {

        $extension = explode(".", $_FILES[$file]['name']);
        $extension = $extension[count($extension)-1];

        $path = $dir.uniqid(rand()).'.'.$extension;


        if(in_array($extension, array('jpg','jpeg','png','gif')))
        {
            if(is_uploaded_file($_FILES[$file]['tmp_name']))
            {
                if(move_uploaded_file($_FILES[$file]['tmp_name'], $path))
                {
                    return $path;
                }
            }
        } else{
            die('<h1 style="color: red;">This file type is not supported</h1>
                <a href="'.URL.'/products" class="action back">Back</a>');
        }
    }


    /**
     * Responsável por cadastrar a instância atual no database
     * @return boolean
     */
    public function create()
    {
        // Insere o produto no banco
        $this->id = (new Database('products'))->insert([
            'id'          => $this->id,
            'sku'         => $this->sku,
            'name'        => $this->name,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'price'       => $this->price,
            'image'       => self::setImageProduct('public/assets/images/product/', 'image')
        ]);

        if(isset($this->id) && !empty($this->id))
            $insertCategories = self::insertCategoriesProduct($this->id, $this->categories);

            return true;
    }



    /**
     * Responsável por atualizar os dados no banco com a instância atual
     * @return boolean
     */
    public function update()
    {
        $instance = new ProductHasCategoriesModel;

        // Se estiver vazio o input de imagem (sem upload), mantém o que já havia em $this->image, caso contrário cadastra
        $image = (empty($_FILES['image']['name'])) ? $this->image : self::setImageProduct('public/assets/images/product/', 'image');

        // Insere o produto no banco
        $update_product = (new Database('products'))->update('id = '.$this->id,[
            'sku'         => $this->sku,
            'name'        => $this->name,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'price'       => $this->price,
            'image'       => $image
        ]);

        if(isset($update_product) && !empty($update_product))
        {
            // Deleta os registros antigos do produto atual
            $delete_old_records = $instance->delete($this->id);
          
            $insertCategories = self::insertCategoriesProduct($this->id, $this->categories);

            return true;
        }
    }


    /**
     * Responsável por deletar os dados do banco com a instância atual
     * @return boolean
     */
    public function delete()
    {
        // Insere o produto no banco
        return (new Database('products'))->delete('id = '.$this->id);
    }




    /**
     * Responsável por retornar produtos
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getProducts($where = null, $orderBy = null, $limit = null, $join = null,$fields = '*')
    {
        return (new Database('products'))->select($where, $orderBy, $limit, $join,$fields);
    }


    /**
     * Responsável por obter um produto pelo seu ID
     * @param integer $id
     * @return ProductsModel
     */
    public static function getProductById($id)
    {
        return self::getProducts('id = '.$id)->fetchObject(self::class);
    }


    public static function countProducts()
    {
        return self::getProducts()->rowCount();
    }
}