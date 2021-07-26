

<div class="box-content"><!--Painel branco-->
	<h2><i class="fa fa-pencil"></i> Editar Usuário</h2>

	<!--Fazer o formulário do tipo post-->
	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

       <!--Vou fazer a atualização do formulário abaixo no bd-->
       <?php 
         if(isset($_POST['acao'])){
         	//Enviei o meu formulário
         	//Painel::alert('sucesso','Atualizado com sucesso!'); /*Vindo do Painel*/

            /*Estou criando uma nova instancia da classe Usuario da pg Usuario.php*/
            
            $nome = $_POST['nome'];
            $senha = $_POST['password'];
            $imagem = $_FILES['imagem'];
            $imagem_atual = $_POST['imagem_atual'];
            $img = $_FILES['imagem'];
            /*instanciando a classe Usuario encontrda na pagina Usuario.php..*/
             $usuario = new Usuario();
             
            
            if($imagem['name'] != ''){  
                //Existe o upload de imagem.
                if (Painel::imagemValida($imagem)){
                    Painel::deleteFile($imagem_atual);
                    $imagem = Painel::uploadFile($imagem);
                    if ($usuario->atualizarUsuario($nome,$senha,$imagem)){

                       /*  $_SESSION['nome'] = $nome;
                         $_SESSION['password'] = $senha;
                         $_SESSION['img'] = $imagem; /*Esta SESSION que troca a imagem*/
                        /* $_SESSION['img'] = $imagem;*/
                        
                Painel::alert('sucesso','Atualizado com sucesso junto com a imagem!');
                  /*$imagem = $_FILES['imagem'];*/
                  /*$_SESSION['img'] = $imagem;*/
                $_SESSION['img'] = $imagem;
                $img = '';
                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? ");
                 $sql->execute(array($img));

                
                /* Recuperando os valores bd na tela atraves do SESSION ao atualizar a tela */
                       
                 }else{
                Painel::alert('erro','Ocorreu um erro ao atualizar junto com a imagem...');/*Vindo do Painel*/

                    }
                }else{
                    Painel::alert('erro','O formato não é valido');
                }

            }else{
                $imagem = $imagem_atual;
                
            /*Estou resgatando os atributos*/
            if($usuario->atualizarUsuario($nome,$senha,$imagem)){ /* este metodo atualizarUsuario...veêm da pagina Usuario.php*/
               /* $_SESSION['nome'] = $nome;
                $_SESSION['password'] = $senha;
                $_SESSION['img'] = $imagem;*/

                 $_SESSION['img'] = $imagem;
                Painel::alert('sucesso','Atualizado com sucesso!');/*Vindo do Painel*/
                /* Recuperando os valores bd na tela atraves do SESSION ao atualizar a tela */
                
                
            }else{
                Painel::alert('erro','Ocorreu um erro ao atualizar...');/*Vindo do Painel*/
              }
            }
         }
       ?>

 



		<div class="form-group">
			<label>Nome: </label>
<input type="text" name="nome" required value="<?php echo $_SESSION['nome']; ?>">
		</div><!--form-group-->
        
        <div class="form-group">
        	<label>Senha: </label>
        	<input type="password" name="password" required value="<?php echo $_SESSION['password']; ?>">
        </div><!--form-group-->
    
        <div class="form-group">
        	<label>Imagem: </label>
        	<input type="file" name="imagem"/>
<input type="hidden" name="imagem_atual" value="<?php echo $_SESSION['img']; ?>"> 
        </div><!--form-group-->


        <div class="form-group">
        	<input type="submit" name="acao" value="Atualizar!">
        </div><!--form-group-->


	</form>

    
</div>