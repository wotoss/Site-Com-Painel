<?php
  
  class Usuario{

  	public function atualizarUsuario($nome,$senha,$imagem){/*Pegando os atributos da pagina editar-usuario*/
  		$sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET nome = ?,password = ?, img = ? WHERE user = ?");
  		if($sql->execute(array($nome,$senha,$imagem,$_SESSION['user']))){
  			return true;
  		}else{
  			return false;
  		}

  	}
    
    /*Para verificar se existir um usuario com este login*/
    public static function userExists($user){
         $sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.usuarios` WHERE user=?"); /*user = ?...é para realizar uma consulta segura*/
         $sql->execute(array($user));
         if($sql->rowCount() == 1)
          return true; /*Se tiver um usuario já com este login ele cancela */
        else
          return false; /*Se for false podemos proseguir*/
    }

    /*Criar a função conectar cadastraUsuario ao bd*/
    public static function cadastrarUsuario($user,$senha,$imagem,$nome,$cargo){
      $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuarios` VALUES (null,?,?,?,?,?)");
      $sql->execute(array($user,$senha,$imagem,$nome,$cargo));

    }

  }

?>