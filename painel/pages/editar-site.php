<?php
   $site = Painel::select('tb_site.config',false);
 ?>

<div class="box-content">
	<h2><i class="fa fa-pencil"></i> Editar Configurações do Site</h2>

	<!--Fazer o formulário do tipo post-->
	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

       <!--Vou fazer a atualização do formulário abaixo no bd-->
       <?php
         if(isset($_POST['acao'])){ 
         	if(Painel::update($_POST,true)){/*quando eu passo o falso e não tenho o id ele atualiza tudo de uma vez*/
          Painel::alert('sucesso','O site foi editado com sucesso !');
          $site = Painel::select('tb_site.config',false);
          
            }else{
              Painel::alert('erro','Campos vázios não são permitidos.');
            }
          }

        ?>

<!--Não vou realizar a validação no front end exemplo o login com required...vou fazer em php..para treinar -->
        
        <div class="form-group">
          <label>Titulo do site: </label>
          <input type="text" name="titulo" value="<?php echo $site['titulo']; ?>" />
        </div><!--form-group-->

    
        <div class="form-group">
          <label>Nome do autor do site: </label>
          <input type="text" name="nome_autor" value="<?php echo $site['nome_autor']; ?>" />
        </div><!--form-group-->

        <div class="form-group">
          <label>Descrição do autor do site: </label>
          <textarea name="descricao"><?php echo $site['descricao']; ?></textarea>
        </div><!--form-group-->

        <!--Fazendo o loop e replicando -->
        <?php 
          for($i = 1; $i <= 3; $i++){
        ?>

        <div class="form-group">
          <label>Icone <?php echo $i; ?>:</label>
          <input type="text" name="icone<?php echo $i; ?>" value="<?php echo $site['icone'.$i] ?>" />
        </div><!--form-group-->

        <div class="form-group">
          <label>Descrição do icone <?php echo $i; ?>:</label>
<textarea name="descricao<?php echo $i; ?>"><?php echo $site['descricao'.$i]; ?></textarea>
        </div><!--form-group-->

         <?php } ?>

        <div class="form-group">
        	<input type="hidden" name="nome_tabela" value="tb_site.config" />
        	<input type="submit" name="acao" value="Atualizar!">
        </div><!--form-group-->


	</form>
    
</div>
