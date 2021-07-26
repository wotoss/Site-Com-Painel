<?php
   if(isset($_GET['id'])){
       $id = (int)$_GET['id'];
       $slide = Painel::select('tb_site.slides','id = ?',array($id));
   }else{
       Painel::alert('erro','Você precisa passar o parametro ID.');
       die(); /* die() Mata o script */
   }

 ?>

<div class="box-content">
	<h2><i class="fa fa-pencil"></i> Editar Slide</h2>

	<!--Fazer o formulário do tipo post-->
	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

       <!--Vou fazer a atualização do formulário abaixo no bd-->
       <?php
         if(isset($_POST['acao'])){
         	//Enviei o meu formulário
         	//Painel::alert('sucesso','Atualizado com sucesso!'); /*Vindo do Painel*/

            /*Estou criando uma nova instancia da classe Usuario da pg Usuario.php*/
            
            $nome = $_POST['nome'];
            $imagem = $_FILES['imagem'];
            $imagem_atual = $_POST['imagem_atual'];
            
            

            if($imagem['name'] != ''){
               
                //Existe o upload de imagem.
                if (Painel::imagemValida($imagem)) {
                    Painel::deleteFile($imagem_atual);
                    $imagem = Painel::uploadFile($imagem);
                    $arr = ['nome'=>$nome,'slide'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_site.slides'];
                    Painel::update($arr);
                   $slide = Painel::select('tb_site.slides','id = ?',array($id));
                    Painel::alert('sucesso','O Slide foi editado junto com a imagem !');/*Vindo do Painel*/
                 }else{
                Painel::alert('erro','O formato da imagem não é valido !');/*Vindo do Painel*/

                    }

            }else{
                $imagem = $imagem_atual;
                $arr = ['nome'=>$nome,'slide'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_site.slides'];
                Painel::update($arr);
                $slide = Painel::select('tb_site.slides','id = ?',array($id));
                Painel::alert('sucesso','O Slide foi editado com sucesso !');/*Vindo do Painel*/
              
            }
         }
       ?>



		<div class="form-group">
			<label>Nome: </label>
<input type="text" name="nome" required value="<?php echo $slide['nome']; ?>">
		</div><!--form-group-->
        
        
        <div class="form-group">
        	<label>Imagem: </label>
        	<input type="file" name="imagem"/>
<input type="hidden" name="imagem_atual" value="<?php echo $slide['slide']; ?>">
        </div><!--form-group-->


        <div class="form-group">
        	<input type="submit" name="acao" value="Atualizar!">
        </div><!--form-group-->


	</form>
    
</div>