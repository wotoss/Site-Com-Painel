<?php
   class Site{
   	  public static function updateUsuarioOnline(){
   	  	if(isset($_SESSION['online'])){
   	  		$token = $_SESSION['online'];
   	  		$horarioAtual = date('Y-m-d H:i:s');
            $check = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.online` WHERE token = ?");
            $check->execute(array($_SESSION['online']));

            if($check->rowCount() == 1){
               $sql = MySql::conectar()->prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ?");
               $sql->execute(array($horarioAtual,$token));

            }else{
              /* Inicio - Muito bom veja que este if e else tenta buscar o ip do usuario no servidor dele de três forma...para assim nos apresentar na tela online quem esta navegando*/
               if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
               $ip = $_SERVER['HTTP_CLIENT_IP'];
               } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
               $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
               $ip = $_SERVER['REMOTE_ADDR'];
             }
             /*fim - buscar ip de três formas no servidor do usuario*/
               $token = $_SESSION['online'];
               $horarioAtual = date('Y-m-d H:i:s');
               $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
               $sql->execute(array($ip,$horarioAtual,$token));
            }
   	  	}else{
   	  		$_SESSION['online'] = uniqid();
   	  		/* Inicio - Muito bom veja que este if e else tenta buscar o ip do usuario no servidor dele de três forma...para assim nos apresentar na tela online quem esta navegando*/
               if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
               $ip = $_SERVER['HTTP_CLIENT_IP'];
               } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
               $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
               $ip = $_SERVER['REMOTE_ADDR'];
             }
             /*fim - buscar ip de três formas no servidor do usuario*/
   	  		$token = $_SESSION['online'];
   	  		$horarioAtual = date('Y-m-d H:i:s');
   	  		$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
   	  		$sql->execute(array($ip,$horarioAtual,$token));
   	  	 }

   	  }

        /*Vamo realizar o método contador ---esta sendo chamado no index.php*/
        /*Este é um contador de visitas de usuarios diferentes...não é o contador que conta toda vez que o usuario entra.*/
        public static function contador(){
          setcookie('visita','true',time() - 1);
           if(!isset($_COOKIE['visita'])){
            setcookie('visita','true',time() + (60*60*24*7));
            $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.visitas` VALUES (null,?,?)");
            $sql->execute(array($_SERVER['REMOTE_ADDR'],date('Y-m-d')));
           }
        }

   }
?>