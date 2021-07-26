
<?php
 $id = (int)$_GET['id'];
 $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
 $sql->execute(array($id));

 if($sql->rowCount() == 0){ /*rowCount, faz a contagem dos produtos*/
     Painel::alert('erro','O produto que você quer editar não existe!');
     die();/*para fechar o script*/
   }
   /*inicio - pegar as imagens de fato*/
   $infoProduto = $sql->fetch();

   $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
   $pegaImagens->execute();
   $pegaImagens = $pegaImagens->fetchAll();

   /*fim - pegar as imagens de fato*/

   if(isset($_GET['deletarImagem'])){
   	$idImagem = $_GET['deletarImagem'];
   	@unlink(BASE_DIR_PAINEL.'/uploads/'.$idImagem);
   	MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE imagem = '$idImagem' ");
   	Painel::alert('sucesso','A imagem foi deletada com sucesso!');
   	/*como ele está deletando eu repito o codigo para trazer todas as outra imagens.*/
   	$pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
   $pegaImagens->execute();
   $pegaImagens = $pegaImagens->fetchAll();
   }
 ?>




<div class="box-content">
	<h2><i class="fa fa-pencil"></i> Editando Produto: <?php echo $id; ?></h2>   	
<!--com está..box-single-wraper..que eu peguei do visualizarproduto.php eu vou listar todas as imgens -->


<div class="card-title"><i class="fa fa-rocket"></i> Informações do produto:</div>

<!--inicio - formulário de editar ou atualizar os produtos-->
<form method="post" enctype="multipart/form-data">
	<!--VAMOS FAZER A PROGRMAÇÃO REAL PARA EDITAÇÃO OU ATUALIZAÇÃO DO FORMULÁRIO-->
	<?php
	/*Neste momento eu recupero os valores do formulário com $_POST*/
	/*Já no fomulario com value eu recupero o valr do banco de dados*/
       if(isset($_POST['acao'])){
       	$nome = $_POST['nome'];
       	$descricao = $_POST['descricao'];
       	$largura = $_POST['largura'];
       	$altura = $_POST['altura'];
       	$comprimento = $_POST['comprimento'];
       	$peso = $_POST['peso'];
       	$quantidade = $_POST['quantidade'];

       	$imagem = [];

       	$sucesso = true;
        $amountFiles = count($_FILES['imagem']['name']);
        if($_FILES['imagem']['name'][0] != ''){
        	//Nosso usuário quer adicionar mais imagem no produto!
        	for ($i=0; $i < $amountFiles; $i++) { 
             $imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
             'size'=>$_FILES['imagem']['size'][$i]];
        	if(Painel::imagemValida($imagemAtual) == false){
        		$sucesso = false;
        		Painel::alert('erro','Uma das imagem  selecionadas são inválidas!');
        		break;
        	   }
        	}
        }
       	if($sucesso){
       		if($_FILES['imagem']['name'][0] != ''){
       		for ($i=0; $i < $amountFiles; $i++) { 
             $imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
             'name'=>$_FILES['imagem']['name'][$i]];
             $imagens[] = Painel::uploadFile($imagemAtual);
           }
           foreach ($imagens as $key => $value) {
           	 MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$id,'$value')");
             }
           }
           $sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET nome = ?,descricao = ?, altura = ?, largura = ?, comprimento = ?, peso = ?, quantidade = ? WHERE id = $id");
           /*estas informações (?)estão sendo guardada no array a baixo */
           $sql->execute(array($nome,$descricao,$altura,$largura,$comprimento,$peso,$quantidade));
          Painel::alert('sucesso','Você atualizou seu produto com sucesso!');
           $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
          $sql->execute(array($id));
          $infoProduto = $sql->fetch();
          /*inicio atualizar sem dar reflexe*/
          $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
           $pegaImagens->execute();
           $pegaImagens = $pegaImagens->fetchAll();
       	 }

       }
	 ?>
<div class="form-group"><!--value---recupera os valores do bd-->
  	  <label>Nome do produto:</label>
  	  <input type="text" name="nome" value="<?php echo $infoProduto['nome']; ?>">	
  	</div><!--form-group-->

  	<div class="form-group"><!--value---recupera os valores do bd-->
  	  <label>Descrição do produto:</label>
  	  <textarea name="descricao"><?php echo $infoProduto['descricao']; ?></textarea>	
  	</div><!--form-group-->

  	<div class="form-group"><!--value---recupera os valores do bd-->
  	  <label>Largura do produto:</label>
  	  <input type="number" name="largura" min="0" max="900" step="1" value="<?php echo $infoProduto['largura']; ?>">	
  	</div><!--form-group-->
    
    <div class="form-group"><!--value---recupera os valores do bd-->
  	  <label>Altura do produto:</label>
  	  <input type="number" name="altura" min="0" max="900" step="1" value="<?php echo $infoProduto['altura']; ?>">	
  	</div><!--form-group-->

  	<div class="form-group"><!--value---recupera os valores do bd-->
  	  <label>Comprimento do produto:</label>
  	  <input type="number" name="comprimento" min="0" max="900" step="1" value="<?php echo $infoProduto['comprimento']; ?>">	
  	</div><!--form-group-->
    
    <div class="form-group"><!--value---recupera os valores do bd-->
  	  <label>Peso do produto:</label>
  	  <input type="number" name="peso" min="0" max="900" step="1" value="<?php echo $infoProduto['peso']; ?>">	
  	</div><!--form-group-->



  	<div class="form-group">
  	  <label>Quantidade atual do produto:</label>
  	  <input type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $infoProduto['quantidade']; ?>">	
  	</div><!--form-group-->

  	<!--vejá nesta div montei um estrutura onde o meu usuario pode selecionar varias imagens-->
  	<div class="form-group">
  	   <label>Selecione as imagens:</label>
  	   <!--simples atraves do multiple consigo inserir varias imagens-->
  	   <input multiple type="file" name="imagem[]">	
  	</div>
  	<input type="submit" name="acao" value="Atualizar Produto!">
 </form>

 <!--TRANSFERENCIA DE CÓDIGO-->
 <div class="card-title"><i class="fa fa-rocket"></i> Imagens do produto:</div>
<div class="boxes">
	<?php
      foreach ($pegaImagens as $key => $value) {
      
	 ?>
<div class="box-single-wraper">	
    <div style="border: 1px solid #ccc;padding: 8px 15px;"><!--padding é 8px em cima e em baixo e 15px dos lados-->
    <div style="width: 100%;float: left;" class="box-imgs">
      <img class="img-square" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']; ?>" />
    </div><!--box-imgs-->
     <div class="clear"></div><!--limpar a flutuação por causa do layaout --> 
    <div style="text-align: center;" class="group-btn">
        <!--botão delete-->
         <a class="btn delete"  href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $id; ?>&deletarImagem=<?php echo $value['imagem']; ?>"><i class="fa fa-times"> Excluir</i></a>
    </div><!--group-btn-->
      
   
    </div><!--fim- faz o contor em toda box-->
  </div><!--box-single-wraper-->
   
   <?php } ?>


</div><!--boxes flaxes para deixar as imagens na mesma linha-->
</div>