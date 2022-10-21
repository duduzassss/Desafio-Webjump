<?php

namespace App\Utils;

use \PDO;
use \PDOException;

class Database{

  /**
   * Host da conexão
   * @var string
   */
  private static $db_host;

  /**
   * Nome da database
   * @var string
   */
  private static $db_name;

  /**
   * Username para conexão à database
   * @var string
   */
  private static $db_username;

  /**
   * Password de acesso à database
   * @var string
   */
  private static $db_password;

  /**
   * Porta de acesso à database
   * @var integer
   */
  private static $db_port;

  /**
   * Nome da tabela a ser manipulada
   * @var string
   */
  private $db_table;

  /**
   * Instancia de conexão com o banco de dados
   * @var PDO
   */
  private $db_connection;

  /**
   * Método responsável pela configuração
   * @param  string  $db_host
   * @param  string  $db_name
   * @param  string  $db_username
   * @param  string  $db_password
   * @param  integer $db_port
   */
  public static function config($host,$name,$user,$pass,$port = 3306){
    self::$db_host = $host;
    self::$db_name = $name;
    self::$db_username = $user;
    self::$db_password = $pass;
    self::$db_port = $port;
  }

  /**
   * Define a tabela e instancia a conexão
   * @param string $table
   */
  public function __construct($table = null){
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection(){
    try{
      $this->db_connection = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name.';port='.self::$db_port,self::$db_username,self::$db_password);
      $this->db_connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por executar queries dentro do database
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function execute($query,$params = []){
    try{
      $statement = $this->db_connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por inserir dados no database
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert($values){
    // DADOS DA QUERY
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');

    // MONTA A QUERY
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

    // EXECUTA O INSERT
    $this->execute($query,array_values($values));

    // RETORNA O ID INSERIDO
    return $this->db_connection->lastInsertId();
  }

  /**
   * Método responsável por executar uma consulta no database
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */
  public function select($where = null, $order = null, $limit = null, $join = null, $fields = '*'){
    // DADOS DA QUERY
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';

    $join = strlen($join) ? $join : '';

    // MONTA A QUERY
    // $query =  'SELECT ' $join ? 'DISTINCT ' : ' ' .$fields.' FROM '.$this->table.' '.$join.' '.$where.' '.$order.' '.$limit;
    $query =  'SELECT ';
    $query .= !empty($join) ? 'DISTINCT ' : ' '; 
    $query .= $fields.' FROM '.$this->table.' '.$join.' '.$where.' '.$order.' '.$limit;

    // EXECUTA A QUERY
    return $this->execute($query);
  }

  /**
   * Método responsável por executar atualizações no database
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values){
    // DADOS DA QUERY
    $fields = array_keys($values);

    // MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    // EXECUTAR A QUERY
    $this->execute($query,array_values($values));

    // RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsável por excluir dados do database
   * @param  string $where
   * @return boolean
   */
  public function delete($where){
    // MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    // EXECUTA A QUERY
    $this->execute($query);

    // RETORNA SUCESSO
    return true;
  }

}