<?php

namespace App\Utils;

class Environment{

  /**
   * Responsável por carregar as variáveis de ambiente do projeto
   * @param  string $dir
   */
  public static function load($dir){
    // var_dump($dir); exit;
    if(!file_exists($dir.'/.env')){
      return false;
    }

    // DEFINE AS VARIÁVEIS DE AMBIENTE
    $lines = file($dir.'/.env');
    // echo '<pre>';
    // var_dump($lines); exit;

    foreach($lines as $line){
      putenv(trim($line));
    }
  }

}