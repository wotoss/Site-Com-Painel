
    <div class="box-content">
    	<h2><i class="fa fa-pencil"></i> Cadastrar Categoria</h2>

    	<!--Fazer o formulário do tipo post-->
    	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

       
       <?php
       if(isset($_POST['acao'])){
        /*Neste momento estou recuperando o nome e a imgem*/
        $nome = $_POST['nome'];
        
        
        /*Veja que interressante estou fazendo a validação pelo php ao invés de realizar pelo front end em html com required*/

        if($nome == ''){
          Painel::alert('erro','O campo nome não pode ficar vázio !');
        }else{

          $verifica = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE nome = ?");
          $verifica->execute(array($_POST['nome']));
          if($verifica->rowCount() == 0){
                  //Podemos cadastrar!
           $slug = Painel::generateSlug($nome);/*Criar a função generateSlug--gerar slug*/
           $arr = ['nome'=>$nome,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_site.categorias'];
           Painel::insert($arr);
           Painel::alert('sucesso','O cadastro da categoria foi realizado com sucesso!');
         }else{
          Painel::alert('erro','Já existe uma categoria com este nome!');
        }
      }

    }      


    ?>



    <div class="form-group">
     <label>Nome da categoria: </label>
     <input type="text" name="nome">
    </div><!--form-group-->




    <div class="form-group">
     <input type="submit" name="acao" value="Cadastrar!">
    </div><!--form-group-->


    </form>

    </div>