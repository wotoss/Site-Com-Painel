<div class="box-content">
  <h2><i class="fa fa-pencil"></i> Cadastrar Produto</h2>

  <!--Este controle de estoque terá uma ***loja virtual***. Mas ainda não é neste momento 08/01/2019, vamos para o modulo de Gestão de Imoveis-->

<!--para conseguir trabalhar com envio de imagem enctype="multipart/form-data"-->
  <form method="post" enctype="multipart/form-data">
    <?php
      if(isset($_POST['acao'])){
      	$nome = $_POST['nome'];
      	$descricao = $_POST['descricao'];
      	$largura = $_POST['largura'];
      	$altura = $_POST['altura'];
      	$comprimento = $_POST['comprimento'];
      	$peso = $_POST['peso'];	
      	$quantidade = $_POST['quantidade'];

        
        $imagens = array();
        $amountFiles = count($_FILES['imagem']['name']);

        /*por padrão este sucesso e true*/
        $sucesso = true;

        /*se entrar nesta condição é por que foi selecionado pelo menos uma imagem*/
        if($_FILES['imagem']['name'][0] != ''){
        for ($i=0; $i < $amountFiles; $i++) { 
           $imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
           'size'=>$_FILES['imagem']['size'][$i]];
           if(Painel::imagemValida($imagemAtual) == false){
               $sucesso = false;
               Painel::alert('erro','Uma das imagens selecionadas são inválidas!');
               break;
           }
        }
    }else{
    	$sucesso = false;
    	Painel::alert('erro','Você precisa selecionar pelo menos uma imagem!');
    }
        
        if($sucesso){
        	for ($i=0; $i < $amountFiles; $i++) { 
            $imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
           'name'=>$_FILES['imagem']['name'][$i]];
           $imagens[] = Painel::uploadFile($imagemAtual);
           }
           /*realizar a conxeção dos meu formulario ao bd*/
           $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque` VALUES (null,?,?,?,?,?,?,?)");
           $sql->execute(array($nome,$descricao,$largura,$altura,$comprimento,$peso,$quantidade));
           $lastId = MySql::conectar()->lastInsertId();/*para pegar id que é inserido automaticamente*/

           foreach ($imagens as $key => $value) {
           	 MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$lastId,'$value')");
           }
      	Painel::alert('sucesso','O produto foi cadastrado com sucesso!');
      	}
      }

     ?>
<!--TODO fazer validação dos campos para ver se estão vazios tanto em php como com html5 requerid-->
  	<div class="form-group">
  	  <label>Nome do produto:</label>
  	  <input type="text" name="nome">	
  	</div><!--form-group-->

  	<div class="form-group">
  	  <label>Descrição do produto:</label>
  	  <textarea name="descricao"></textarea>	
  	</div><!--form-group-->

  	<div class="form-group">
  	  <label>Largura do produto:</label>
  	  <input type="number" name="largura" min="0" max="900" step="5" value="0">	
  	</div><!--form-group-->
    
    <div class="form-group">
  	  <label>Altura do produto:</label>
  	  <input type="number" name="altura" min="0" max="900" step="5" value="0">	
  	</div><!--form-group-->

  	<div class="form-group">
  	  <label>Comprimento do produto:</label>
  	  <input type="number" name="comprimento" min="0" max="900" step="5" value="0">	
  	</div><!--form-group-->
    
    <div class="form-group">
  	  <label>Peso do produto:</label>
  	  <input type="number" name="peso" min="0" max="900" step="5" value="0">	
  	</div><!--form-group-->



  	<div class="form-group">
  	  <label>Quantidade atual do produto:</label>
  	  <input type="number" name="quantidade" min="0" max="900" step="5" value="0">	
  	</div><!--form-group-->

  	<!--vejá nesta div montei um estrutura onde o meu usuario pode selecionar varias imagens-->
  	<div class="form-group">
  	   <label>Selecione as imagens:</label>
  	   <!--simples atraves do multiple consigo inserir varias imagens-->
  	   <input multiple type="file" name="imagem[]">	
  	</div>
  	<input type="submit" name="acao" value="Cadastrar Produto!">

  </form>	

	
</div><!--box-content-->