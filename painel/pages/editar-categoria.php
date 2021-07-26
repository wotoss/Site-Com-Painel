<?php
  if(isset($_GET['id'])){
    $id = (int)$_GET['id']; /*recuperando o id*/
    $categoria = Painel::select('tb_site.categorias','id = ?',array($id));
  }else{
    Painel::alert('erro', 'Você precisa passar o parametro ID.');
    die();
  }

?>

<div class="box-content">
	<h2><i class="fa fa-pencil"></i> Editar Categoria</h2>

	<!--Fazer o formulário do tipo post-->
	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

       <!--Vou fazer a atualização do formulário abaixo no bd-->
       <?php
         if(isset($_POST['acao'])){ 
          $slug = Painel::generateSlug($_POST['nome']);
          $arr = array_merge($_POST,array('slug'=>$slug));/*array_marge une dois arrays no caso aqui o $_post e o slug*/
           /*VOU VERIFICAR SE JÁ TEM O MESMO NOME CADASTRADO*/
          $verificar = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE nome = ? AND id != ?");
          $verificar->execute(array($_POST['nome'],$id));
          $info = $verificar->fetch();

          if($verificar->rowCount() == 1 ){
            Painel::alert("erro",'Já existe uma categoria com este  nome !');
          }else{

          /*Fim da verificação. Observe que estou verificando se nome repetidos pelos indice do formulario banco ['nome'] e $id*/
         	if(Painel::update($arr)){/*Passando todos os campos $_POST*/
          Painel::alert('sucesso','A categoria foi editada com sucesso !');
          $categoria = Painel::select('tb_site.categorias','id = ?',array($id));
          
            }else{
              Painel::alert('erro','Campos vázios não são permitidos.');
            }
            }
          }

        ?>

<!--Não vou realizar a validação no front end exemplo o login com required...vou fazer em php..para treinar -->
        
        <div class="form-group">
          <label>Categoria: </label>
          <input type="text" name="nome" value="<?php echo $categoria['nome']; ?>">
        </div><!--form-group-->

         

        <div class="form-group">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
        	<input type="hidden" name="nome_tabela" value="tb_site.categorias" />
        	<input type="submit" name="acao" value="Atualizar!">
        </div><!--form-group-->


	</form>
    
</div>
