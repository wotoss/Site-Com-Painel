


<div class="box-content">
	<h2><i class="fa fa-pencil"></i> Adicionar Depoimentos</h2>

	<!--Fazer o formulário do tipo post-->
	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

       <!--Vou fazer a atualização do formulário abaixo no bd-->
       <?php
         if(isset($_POST['acao'])){
         	if(Painel::insert($_POST)){
          Painel::alert('sucesso','O cadastro depoimentos foi feito com sucesso!');
            }else{
            	Painel::alert('erro','Campos vazios não são permitidos!');
            }
          }

          

        ?>

<!--Não vou realizar a validação no front end exemplo o login com required...vou fazer em php..para treinar -->
        <div class="form-group">
          <label>Nome da pessoa: </label>
          <input type="text" name="nome">
          <!--<input type="text" name="login" required>-->
        </div><!--form-group-->

        <div class="form-group">
          <label>Depoimento: </label>
          <textarea name="depoimento"></textarea>
          <!--<input type="text" name="login" required>-->
        </div><!--form-group-->

         <div class="form-group">
          <label>Data: </label>
          <input formato="data" type="text" name="data">
          <!--<input type="text" name="login" required>-->
        </div><!--form-group-->

        <div class="form-group">
          <input type="hidden" name="order_id" value="0">
        	<input type="hidden" name="nome_tabela" value="tb_site.depoimentos" />
        	<input type="submit" name="acao" value="Cadastrar!">
        </div><!--form-group-->


	</form>
    
</div>
