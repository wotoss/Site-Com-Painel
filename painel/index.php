<?php
/*<?php include('config.php'); ?>*/
ob_start();

  include('../config.php'); 
    
    if(Painel::logado() == false){
    	include('login.php');
    }else{
    	include('main.php');
    }

   ob_end_flush();
  
    /*Alguns servidores host gator entre outros podem dar conflito no carregamento da pagina.*/
  /*Quando eu coloco ob_start e ob_end_flush ele primeiro armazena toda a pagina ob_start e depois descarrega toda a pagina com a função ob_end_flush() */

?>