

<!--formulário é repetitivo mas é uma pratica agil de se fazer-->
<div class="box-content">

	<h2><i class="fa fa-pencil"></i> Cadastrar Empreendimento</h2>
    
    <!--colocamos enctype="multipart/form-data" porque trabalharemos com imagem -->
	<form method="post" enctype="multipart/form-data">

       <!--Via php-->
       <?php
        if (isset($_POST['acao'])) {
            /*recuperar os campos com $_POST*/
            $nome = $_POST['nome'];
            $tipo = $_POST['tipo'];
            $preco = $_POST['preco'];
            $imagem = $_FILES['imagem'];/*a imagem não foi feita po array por ser apenas uma imagem*/
            /*Se o campo [name] [imagem] for '' vazio..dará o alerta erro*/
            if($_FILES['imagem']['name'] == ''){
                Painel::alert('erro','Você precisa selecionar uma imagem.');

            }else{
                 //Imagem é válida
                   if(!(Painel::imagemValida($imagem))){ //Muito bom...Se !NÂO for IMAGEM VALIDA..Já me coloca o erro...se for valida entra no else....ADOREI esta expressão...tambem poderia ser assim Painel::imagemValida($imagem)== false)
                    Painel::alert('erro','Ops. Imagem inválida :(');
                   }else{
                    //Realizar cadastro e upload
                    $idImagem = Painel::uploadFile($imagem);
                    $sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.empreendimentos` VALUES /*proteção contra sql injection*/(null,?,?,?,?,?)");
                    $sql->execute(array($nome,$tipo,$preco,$idImagem,0));
                    $lastId = Mysql::conectar()->lastInsertId(); /*função do Painel para cadstrar o ultimo id*/
                    Mysql::conectar()->exec("UPDATE `tb_admin.empreendimentos` SET order_id = $lastId WHERE id = $lastId");
                    Painel::alert('sucesso','Cadastro do empreendimento foi feito com sucesso!');
                   }
               }

        }

        ?>


        
        <!--Um label com uma caixa de dialogo que só terá o nome-->
		<div class="form-group">
			<label>Nome:</label>
			<input required="" type="text" name="nome">		
		</div><!--form-group-->
        
        <!--Temos aqui uma div com label fonecendo o nome, e um seletor com opções residencial e comercial-->
        <div class="form-group">
        	<label>Tipo:</label>
        	<select name="tipo">
        		<option value="residencial">Residêncial</option>
        		<option value="comercial">Comercial</option>
        	</select>  	
        </div><!--form-group-->

        <!--A mascara deste name="preco" está /js/helperMask.js -->
        <div class="form-group">
        	<label>Preço:</label>
        	<input type="text" name="preco">
        </div><!--form-group-->
       

       <!--Esta div tem um label imagem o input é do tipo arquivo, name="imagem" serve para puxar no banco de dados. * Curiosidade se eu colocar o required="" ele aceita em imagem a obrigatoriedade--> 
        <div class="form-group">
        	<label>Imagem:</label>
        	<input type="file" name="imagem" required="">
        </div><!--form-group-->

        <div class="form-group">
            <input type="submit" name="acao" value="Cadastrar">
        </div><!--form-group-->
		
	</form>

</div><!--box-content-->