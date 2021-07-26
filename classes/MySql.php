<?php

   class MySql{
       
     private static $pdo;/*Por ela ser private conseguiremos acessar ela mas só estará disponivel dentro da classe...vou acessesa-la atraves do self || this*/

    public static function conectar(){
        if(self::$pdo == null){
      	  try{   /*Lembrando que..USER,PASSWORD...criado aqui não são as mesmas do BD..e sim constantes que serão usadas no config.php*/
          self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      	  	self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);/*Para mostrar o erro em tela*/
      	  }catch(Exception $e){
             echo '<h2>Erro ao conectar</h2>';
      	  }
        }
        return self::$pdo;
     	}

   }

?>