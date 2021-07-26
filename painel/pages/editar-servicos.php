<?php
  if(isset($_GET['id'])){
    $id = (int)$_GET['id']; /*recuperando o id*/
    $servicos = Painel::select('tb_site.servicos','id = ?',array($id));
  }else{
    Painel::alert('erro', 'Você precisa passar o parametro ID.');
    die();
  }

?>

<div class="box-content">
	<h2><i class="fa fa-pencil"></i> Editar Serviço</h2>

	<!--Fazer o formulário do tipo post-->
	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

       <!--Vou fazer a atualização do formulário abaixo no bd-->
       <?php
         if(isset($_POST['acao'])){ 
         	if(Painel::update($_POST)){/*Passando todos os campos $_POST*/
          Painel::alert('sucesso','O serviço foi editado com sucesso !');
          $servicos = Painel::select('tb_site.servicos','id = ?',array($id));
          
            }else{
              Painel::alert('erro','Campos vázios não são permitidos.');
            }
          }

        ?>

<!--Não vou realizar a validação no front end exemplo o login com required...vou fazer em php..para treinar -->
        
        <div class="form-group">
          <label>Serviços: </label>
          <textarea name="servico"><?php echo $servicos['servico']; ?></textarea>
          <!--<input type="text" name="login" required>-->
        </div><!--form-group-->

         

        <div class="form-group">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
        	<input type="hidden" name="nome_tabela" value="tb_site.servicos" />
        	<input type="submit" name="acao" value="Atualizar!">
        </div><!--form-group-->


	</form>
    
</div>
