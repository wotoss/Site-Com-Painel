


<div class="box-content"> 
<h2><i class="fa fa-id-card-o" arial-hidden="true"></i> Empreendimentos</h2>

<!--inicio - nesta ultima aula vamos para implementação da busca ou pesquisa-->
<div class="busca">
  <h4><i class="fa fa-search"></i> Realizar uma busca</h4>
  <form method="post">
    <input style="font-size: 15px;" type="text" placeholder="Procure pelo nome do empreendimento" name="busca">
    <input type="submit" name="acao" value="Buscar!">   
  </form><!--form-->
</div><!--busca-->

<?php
    /*inicio - deletar*/
    if(isset($_GET['deletar'])){
      //queremos deletar algum produto.
      $id = (int)$_GET['deletar'];
      $imagens = MySql::conectar()->prepare("SELECT `imagem` FROM `tb_admin.empreendimentos` WHERE id = $id");
      $imagens->execute();
      $imagens = $imagens->fetch();

      /*como é só uma imgens não faço foreach. Faço apenas @unlink*/
      @unlink(BASE_DIR_PAINEL.'/uploads/'.$imagens['imagem']);
     
      MySql::conectar()->exec("DELETE FROM `tb_admin.empreendimentos` WHERE id = $id");
      Painel::alert('sucesso','O empreendimento foi deletado com sucesso!');
    }

 ?>

<div class="boxes">
  <!--poderia ter usado o INNERJOI mas preferi fazer duas conexões. Assim tenho mais controle-->
   <?php
      $query = "";/*inicializar a query, devido ter colocado ela na linha 40 MySql:: */
      if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar!'){
        $nome = $_POST['busca'];
        /*TODO -> trocar nome por descricao*/
        $query = "WHERE (nome LIKE '%$nome%')";
        /*WHERE->ONDE nome vindo do bd GOSTAR...'%$nome%'formulario OR -> OU descricao bd */
      }
      if ($query == '') {
        $query2 = "";
      }else{
        $query2 = "";
      }
   
      $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` $query ORDER BY order_id ASC");
      $sql->execute();
      $produtos = $sql->fetchAll();

      if($query !=''){
        /*TODO<p>Foram encontrado(s) ...dica para o futuro*/
        echo '<div style="width:100%;" class="busca-result"><p>Foram encontrados <b>'.count($produtos).'</b> resultado(s) </p></div>';
      }

      foreach ($produtos as $key => $value) {

    ?>
  <div id="item-<?php echo $value['id']; ?>" class="box-single-wraper" style="padding:10px 30px;"><!--altera direto o quadradoda foto-->

    <div style="border: 1px solid #ccc;padding: 8px 15px;height: 100%;"><!--inicio - faz o contor em toda box-->
    <div style="width: 100%;float: left;" class="box-imgs">

      <img class="img-square" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem'] ?>" />

    </div><!--box-imgs-->

    <div style="width: 70%;float: left;border:0;" class="box-single">
  <div class="body-box">
    <p><b><i class="fa fa-pencil"></i> Nome: </b><?php echo $value['nome'] ?></p>
  <p><b><i class="fa fa-pencil"></i> Tipo:</b><?php echo ucfirst($value['tipo'])?></p>
        

    <div class="group-btn">
        <!--botão delete-->
         <a class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-empreendimentos?deletar=<?php echo $value['id']; ?>"><i class="fa fa-times"></i> Excluir</a>

         <!--botão visualizar empreendimento-->
         <a style="background: #0091ea" class="btn" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-empreendimentos?id=<?php echo $value['id']; ?>"><i class="fa fa-eye"></i> Visualizar</a>

    </div><!--group-btn-->

  </div><!--body-box--> 
    </div><!--box-single--> 
    <div class="clear"></div><!--limpar a flutuação por causa do layaout -->
    </div><!--fim- faz o contor em toda box-->
  </div><!--box-single-wraper--> 
  
  <?php } ?>

</div><!--boxes-->
</div><!--box-content-->  

