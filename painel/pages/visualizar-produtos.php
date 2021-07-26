
<!--SISTEMA DE ALERTA VERIFICAR SE TEM PRODUTOS-->
<?php
  if(isset($_GET['pendentes']) == false){

 ?>


<div class="box-content"> 
<h2><i class="fa fa-id-card-o" arial-hidden="true"></i>  Produtos no Estoque</h2>

<!--inicio - nesta ultima aula vamos para implementação da busca ou pesquisa-->
<div class="busca">
  <h4><i class="fa fa-search"></i> Realizar uma busca</h4>
  <form method="post">
    <input style="font-size: 15px;" type="text" placeholder="Procure pelo nome do produto" name="busca">
    <input type="submit" name="acao" value="Buscar!">   
  </form><!--form-->
</div><!--busca-->

<?php
    /*inicio - deletar*/
    if(isset($_GET['deletar'])){
      //queremos deletar algum produto.
      $id = (int)$_GET['deletar'];
      $imagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
      $imagens->execute();
      $imagens = $imagens->fetchAll();

      foreach ($imagens as $key => $value) {
        @unlink(BASE_DIR_PAINEL.'/uploads/'.$value['imagem']);
      }
      MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
      MySql::conectar()->exec("DELETE FROM `tb_admin.estoque` WHERE id = $id");
      Painel::alert('sucesso','O produto foi deletado do estoque com sucesso!');
    }

    /*fim - deletar produtos*/

   if(isset($_POST['atualizar'])){
     $quantidade = $_POST['quantidade'];
     $produto_id = $_POST['produto_id'];
     if($quantidade < 0){
         Painel::alert('erro','Você não pode atualizar a quantidade para igual ou menor a 0!');
     }else{
      MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
      Painel::alert('sucesso','Você atualizou a quantidade do produto com ID: <b>'.$_POST['produto_id'].'</b>');

     }
   }
   $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
   $sql->execute();
   if($sql->rowCount() > 0){
   Painel::alert('atencao','Você está com produtos em falta! Clique <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos?pendentes">aqui</a> para visualiza-los!');
   }
 ?>

<div class="boxes">
  <!--poderia ter usado o INNERJOI mas preferi fazer duas conexões. Assim tenho mais controle-->
   <?php
      $query = "";/*inicializar a query, devido ter colocado ela na linha 40 MySql:: */
      $query2 = "";
      if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar!'){
        $nome = $_POST['busca'];
        /*TODO -> trocar nome por descricao*/
        $query = "WHERE (nome LIKE '%$nome%' OR descricao LIKE '%$nome%')";
        /*WHERE->ONDE nome vindo do bd GOSTAR...'%$nome%'formulario OR -> OU descricao bd */
      }
      if ($query == '') {
        $query = "WHERE quantidade > 0";
      }else{
        $query2 = "AND quantidade > 0";
      }
   
      $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query $query2");
      $sql->execute();
      $produtos = $sql->fetchAll();

      if($query !=''){
        /*TODO<p>Foram encontrado(s) ...dica para o futuro*/
        echo '<div style="width:100%;" class="busca-result"><p>Foram encontrados <b>'.count($produtos).'</b> resultado(s) </p></div>';
      }

      foreach ($produtos as $key => $value) {

      $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
      $imagemSingle->execute();
      $imagemSingle = $imagemSingle->fetch()['imagem'];
        
    ?>
  <div class="box-single-wraper">

    <div style="border: 1px solid #ccc;padding: 8px 15px;height: 100%;"><!--inicio - faz o contor em toda box-->
    <div style="width: 100%;float: left;" class="box-imgs">
       <!--para quando estiver vazio sem imagem-->
       <?php
          if ($imagemSingle == '') {   
        ?>

        <h1><i class="fa fa-pencil-square-o"></i></h1>

      <?php }else{ ?>

      <img class="img-square" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle ?>" />

      <?php }  ?>
    </div><!--box-imgs-->

    <div style="width: 70%;float: left;border:0;" class="box-single">
  <div class="body-box">
    <p><b><i class="fa fa-pencil"></i> Nome do produto:</b><?php echo $value['nome']; ?></p>
    <p><b><i class="fa fa-pencil"></i> Descrição:</b><?php echo $value['descricao'] ?></p>
    <p><b><i class="fa fa-pencil"></i> Largura:</b><?php echo $value['largura'] ?>cm</p>
    <p><b><i class="fa fa-pencil"></i> Altura:</b><?php echo $value['altura'] ?>cm</p>
    <p><b><i class="fa fa-pencil"></i> Comprimento:</b><?php echo $value['comprimento'] ?></p>
    <p><b><i class="fa fa-pencil"></i> peso:</b><?php echo $value['peso'] ?>cm</p>
    
    
    <div style="padding:8px 0; border-bottom:1px solid #ccc;" class="group-btn">
      <form method="post" style="margin: 0;">
        <label>Quantidade atual:</label>
        <input type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $value['quantidade']; ?>">
        <input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
        <input style="background: #0091ea;" type="submit" name="atualizar" value="Atualizar" >
      </form>
    </div><!--group-btn-->    

    <div class="group-btn">
        <!--botão delete-->
         <a class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?deletar=<?php echo $value['id']; ?>"><i class="fa fa-times"> Excluir</i></a>
         <!--botão editar-->
         <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php  echo $value['id']; ?>"><i class="fa fa-pencil"></i>Editar</a>
    </div><!--group-btn-->
  </div><!--body-box--> 
    </div><!--box-single--> 
    <div class="clear"></div><!--limpar a flutuação por causa do layaout -->
    </div><!--fim- faz o contor em toda box-->
  </div><!--box-single-wraper--> 

  <?php } ?>

  
</div><!--boxes-->
</div><!--box-content-->  

<?php  }else{ ?>


  <!--LOGICA DE PROGRAMAÇÃO VOLTADA AOS PRODUTOS DO ESTOQUE-->

  <div class="box-content"> 
    <h2><i class="fa fa-id-card-o" arial-hidden="true"></i> <a href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Produtos no estoque</a> > Produtos em falta</h2>
    <!--inicio - transferencia-->
    <?php
   if(isset($_POST['atualizar'])){
     $quantidade = $_POST['quantidade'];
     $produto_id = $_POST['produto_id'];
     if($quantidade < 0){
         Painel::alert('erro','Você não pode atualizar a quantidade para igual ou menor a 0!');
     }else{
      MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
      Painel::alert('sucesso','Você atualizou a quantidade do produto com ID: <b>'.$_POST['produto_id'].'</b>');
       }
     }
     echo '<br />';
     $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
      $sql->execute();
      $produtos = $sql->fetchAll();
      if(count($produtos) > 0)
     Painel::alert('atencao','Todos os produtos listados abaixo estão em falta no seu estoque!');
   else
    Painel::alert('sucesso','Tudo okay, você não tem nenhum produto em falta!');

?>
<div class="boxes">
  <!--poderia ter usado o INNERJOI mas preferi fazer duas conexões. Assim tenho mais controle-->

   <?php
      foreach ($produtos as $key => $value) {
      
      $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
      $imagemSingle->execute();
      $imagemSingle = $imagemSingle->fetch()['imagem'];
        
    ?>
  <div class="box-single-wraper">

    <div style="border: 1px solid #ccc;padding: 8px 15px;height: 100%;"><!--inicio - faz o contor em toda box-->
    <div style="width: 100%;float: left;" class="box-imgs">
      <!--para quando estiver vazio sem imagem-->
       <?php
          if($imagemSingle == ''){   
        ?>

        <h1><i class="fa fa-pencil-square-o"></i></h1>

      <?php }else{ ?>

      <img class="img-square" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle ?>" />

      <?php }  ?>
    </div><!--box-imgs-->

    <div style="width: 70%;float: left;border:0;" class="box-single">
  <div class="body-box">
    <p><b><i class="fa fa-pencil"></i> Nome do produto:</b><?php echo $value['nome']; ?></p>
    <p><b><i class="fa fa-pencil"></i> Descrição:</b><?php echo $value['descricao'] ?></p>
    <p><b><i class="fa fa-pencil"></i> Largura:</b><?php echo $value['largura'] ?>cm</p>
    <p><b><i class="fa fa-pencil"></i> Altura:</b><?php echo $value['altura'] ?>cm</p>
    <p><b><i class="fa fa-pencil"></i> Comprimento:</b><?php echo $value['comprimento'] ?></p>
    <p><b><i class="fa fa-pencil"></i> peso:</b><?php echo $value['peso'] ?>cm</p>
    
    
    <div style="padding:8px 0; border-bottom:1px solid #ccc;" class="group-btn">
      <form method="post" style="margin: 0;">
        <label>Quantidade atual:</label>
        <input type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $value['quantidade']; ?>">
        <input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
        <input style="background: #0091ea;" type="submit" name="atualizar" value="Atualizar" >
      </form>
    </div><!--group-btn-->    

    <div class="group-btn">
        <!--botão delete-->
         <a class="btn delete" item_id="<?php echo $value['id']; ?>" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fa fa-times"> Excluir</i></a>
         <!--botão editar-->
         <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php  echo $value['id']; ?>"><i class="fa fa-pencil"></i>Editar</a>
    </div><!--group-btn-->
  </div><!--body-box--> 
    </div><!--box-single--> 
    <div class="clear"></div><!--limpar a flutuação por causa do layaout -->
    </div><!--fim- faz o contor em toda box-->
  </div><!--box-single-wraper--> 

  <?php } ?>

  
</div><!--boxes-->
    <!--fim - transferencia-->
  </div>

<?php }  ?>