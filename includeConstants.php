<?php
   /*inicio - teste*/

   session_start();
   date_default_timezone_get('America/Sao_Paulo'); /*Este é para pegar o horario e data correta...no arquivo Site.php*/
   require('vendor/autoload.php');
   $autoload = function($class){
       if($class == 'Email') {
         require_once('classes/phpmailer/PHPMailerAutoload.php'); /*incluindo o arquivo PHPMailerAutoload*/
         //require_once tem praticamente a mesma função include.Mas o require_once só deixa inclui uma vez e é mais profissional. 
       }
         include('classes/'.$class.'.php');
       //include deixa incluir varias vezes.
   };

   spl_autoload_register($autoload);

   /*fim - teste*/
   //define('INCLUDE_PATH','http://www.php.programadorjavawoto.com/');
   //define('INCLUDE_PATH','http://localhost:8090/Projeto_01_01/');
   //define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');

    /*incio - somente para manutenção*/

   define('INCLUDE_PATH','http://localhost:8090/Projeto_01_01_servidor/');
   define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');


   define('BASE_DIR_PAINEL',__DIR__.'/painel');

   //Conectar com banco de dados!
   setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
   date_default_timezone_set('America/Sao_Paulo');
   define('HOST','localhost'); /*O HOST--> É localhost*/
   define('USER','root');/*O Usuario(USER)--> É root*/
   define('PASSWORD','');/*A senha(PASSWORD)--> É vazio*/  
   define('DATABASE','sistema_dev_web');/*O nome do Banco de Dados(DATABASE)--> É 

   /*fim - somente para manutenção*/

   /*hospedagem */
   
   //define('BASE_DIR_PAINEL',__DIR__.'/painel');
   //Conectar com banco de dados!
   /*header('Content-Type: text/html; charset=UTF-8');*/
  /* init_set('default_charset', 'UTF-8');*/
   //setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
   //date_default_timezone_set('America/Bahia');
   //define('HOST','mysql3000.mochahost.com'); /*O HOST--> É localhost*/
   //define('USER','wotoss_root');/*O Usuario(USER)--> É root*/
   //define('PASSWORD','022896wa');/*A senha(PASSWORD)--> É vazio*/  
   //define('DATABASE','wotoss_php');/*O nome do Banco de Dados(DATABASE)--> É wotoss_php*/  

   //Constante para o painel de controle. A solicitação desta Constante vem da home 
   //Esta na segunda linha da home //h2
   define('NOME_EMPRESA','Danki Code');

 ?>