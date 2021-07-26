
<!--Aqui neste momento eu vou pegar todos os depoimentos inseridos na lista do bd-->
<?php
    if(isset($_GET['excluir'])){
      $idExcluir = intval($_GET['excluir']);
      Painel::deletar('tb_site.categorias',$idExcluir);
      $noticias = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? ");
      $noticias->execute(array($idExcluir));
      $noticias = $noticias->fetchAll();
      foreach ($noticias as $key => $value) {
        $imgDelete = $value['capa'];
        Painel::deleteFile($imgDelete);
      }
      $noticias = MySql::conectar()->prepare("DELETE  FROM `tb_site.noticias` WHERE categoria_id = ?");
      $noticias->execute(array($idExcluir));
      Painel::redirect(INCLUDE_PATH_PAINEL.'gerenciar-categorias');/*depois que deleta em cima redirecional para pagina categorias*/
    }else if(isset($_GET['order']) && isset($_GET['id'])){
      Painel::orderItem('tb_site.categorias',$_GET['order'], $_GET['id']);
    }



   $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
   $porPagina = 4;

   $categorias = Painel::selectAll('tb_site.categorias',($paginaAtual - 1) * $porPagina,$porPagina);
?>


<div class="box-content"> 
<h2><i class="fa fa-id-card-o" arial-hidden="true"></i> Categorias Cadastradas</h2>
<div class="wraper-table">
<table>
  <tr>
    <td><i class="fa fa-id-card-o" arial-hidden="true"> Nome</td>
    <td><i class="fa fa-id-card-o" arial-hidden="true"> #</td>
    <td>#</td>
    <td>#</td>
    <td>#</td>
  </tr>

     <?php
        foreach ($categorias as $key => $value) {

     ?>


  <tr>
    <td><?php echo $value['nome']; ?></td><!--nome da coluna do bd (nome, data) de lá que vem as informações e vai para tela-->

    <td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-categoria?id=<?php echo $value['id']; ?>"><i class="fa fa-pencil"></i>Editar</a></td>
    <td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categorias?excluir=<?php echo $value['id']; ?>"><i class="fa fa-times"> Excluir</i></a></td>
    <!--ordenamento-->
    <td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categorias?order=up&id=<?php echo $value['id'] ?>"><i class="fa fa-angle-up"></i></a></td>

    <td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categorias?order=down&id=<?php echo $value['id'] ?>"><i class="fa fa-angle-down"></i></a></td>
  </tr>
      
      <?php } ?>

</table>

</div>
<div class="paginacao">

  <?php
       /*para realizar a paginação*/
    $totalPaginas = ceil(count(Painel::selectAll('tb_site.categorias')) / $porPagina);

       /*agora vou realizar o loop*/
       for($i = 1; $i <= $totalPaginas; $i++){
        if($i == $paginaAtual)
          echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'gerenciar-categorias?pagina='.$i.'">'.$i.'</a>';
        else
          echo '<a href="'.INCLUDE_PATH_PAINEL.'gerenciar-categorias?pagina='.$i.'">'.$i.'</a>';
        
       }
  ?>

</div><!--paginação-->

</div><!--box-content--> <!--1º container da tela-->  