

<div class="box-content"> 
<h2><i class="fa fa-id-card-o" arial-hidden="true"></i> Clientes Cadastrados</h2>

<!--inicio - nesta ultima aula vamos para implementação da busca ou pesquisa-->
<div class="busca">
  <h4><i class="fa fa-search"></i> Realizar uma busca</h4>
  <form method="post">
    <input type="text" placeholder="Procure por: nome, email, cpf ou cnpj" name="busca">
    <input type="submit" name="acao" value="Buscar">
    
  </form><!--form-->
</div><!--busca-->
<!--inicio - nesta ultima aula vamos para implementação da busca ou pesquisa-->

<div class="boxes">
<?php
/*veja que estou usando o formulario acima de pesquisa,atraves do POST acao*/
  $query = "";/*declaro a query vazia mas logo uso em baixo*/
  if(isset($_POST['acao'])){ 
    $busca = $_POST['busca'];
    $query = " WHERE nome LIKE '%$busca%' OR email LIKE '%$busca%' OR cpf_cnpj LIKE '%$busca%' ";
  }
  /*veja na linha $clientes depois da conexão tb_admin.clientes já resolvida. Indepentemente quando eu termino a implementação acima para efetuar a busca eu acrescento $query nesta linha...Muito facil */
  $clientes = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` $query"); 
  $clientes->execute();
  $clientes = $clientes->fetchAll();
  /*para contar quantos itens foram encontrados*/
  if(isset($_POST['acao'])){
  echo '<div style="width:100%;" class="busca-result"><p>Foram encontrados <b>'.count($clientes).'</b> resultados(s)</p></div>';
  }
  foreach ($clientes as  $value) { /*neste eu não precisei usar o $key =>*/  
 ?>
  <div class="box-single-wraper">
    <div class="box-single">
    <div class="topo-box">
      <?php
        if($value['imagem'] == ''){
      ?>  
          <h2><i class="fa fa-user"></i></h2>
      <?php }else{ ?>
          <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']; ?>" />  
      <?php } ?>
    </div><!--topo-box-->
  <div class="body-box">
        <p><b><i class="fa fa-pencil"></i> Nome do cliente:</b> <?php echo $value['nome']; ?></p>
        <p><b><i class="fa fa-pencil"></i> E-mail:</b> <?php echo $value['email']; ?></p>
        <!--ucfirst para a 1º letra ficar maiuscula Fisico ou Juridico-->
        <p><b><i class="fa fa-pencil"></i> Tipo:</b> <?php echo ucfirst($value['tipo']); ?></p>
        <p><b><i class="fa fa-pencil"></i> <?php
           if($value['tipo'] == 'fisico')
              echo 'CPF: ';
            else
              echo 'CNPJ: ';
         ?>:</b> <?php echo $value['cpf_cnpj']; ?></p>

    <div class="group-btn">
        <!--botão delete-->
         <a class="btn delete" item_id="<?php echo $value['id']; ?>" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fa fa-times"> Excluir</i></a>
         <!--botão editar-->
         <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-cliente?id=<?php echo $value['id']; ?>"><i class="fa fa-pencil"></i>Editar</a>
    </div><!--group-btn-->
  </div><!--body-box--> 
    </div><!--box-single--> 
  </div><!--box-single-wraper--> 

<?php } ?>

  <div class="clear"></div><!--limpar a flutuação por causa do layaout -->
</div><!--boxes-->
</div><!--box-content-->  