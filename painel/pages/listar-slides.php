
<!--Aqui neste momento eu vou pegar todos os depoimentos inseridos na lista do bd-->
<?php
    if(isset($_GET['excluir'])){
      $idExcluir = intval($_GET['excluir']);
      $selectImagem = MySql::conectar()->prepare("SELECT slide FROM `tb_site.slides` WHERE id = ?");
      $selectImagem->execute(array($_GET['excluir']));

      $imagem = $selectImagem->fetch()['slide'];
      Painel::deleteFile($imagem);

      Painel::deletar('tb_site.slides',$idExcluir);
      Painel::redirect(INCLUDE_PATH_PAINEL.'listar-slides');
    }else if(isset($_GET['order']) && isset($_GET['id'])){
      Painel::orderItem('tb_site.slides',$_GET['order'], $_GET['id']);
    }



   $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
   $porPagina = 4;

   $slides = Painel::selectAll('tb_site.slides',($paginaAtual - 1) * $porPagina,$porPagina);
?>


<div class="box-content"> 
<h2><i class="fa fa-id-card-o" arial-hidden="true"></i> Slides Cadastrados</h2>

<table>
  <tr>
    <td><i class="fa fa-id-card-o" arial-hidden="true"> Nome</td>
    <td><i class="fa fa-id-card-o" arial-hidden="true"> Imagem</td>
    <td>Editar</td>
    <td>Deletar</td>
    <td>#</td>
    <td>#</td>
  </tr>

     <?php
        foreach ($slides as $key => $value) {

     ?>


  <tr>
    <td><?php echo $value['nome']; ?></td><!--nome da coluna do bd (nome, data) de lá que vem as informações e vai para tela-->
    <td><img style="width: 50px;height: 50px;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['slide']; ?>"/></td>

    <td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-slides?id=<?php echo $value['id']; ?>"><i class="fa fa-pencil"></i>Editar</a></td>
    <td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides?excluir=<?php echo $value['id']; ?>"><i class="fa fa-times"> Excluir</i></a></td>
    <!--ordenamento-->
    <td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides?order=up&id=<?php echo $value['id'] ?>"><i class="fa fa-angle-up"></i></a></td>

    <td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides?order=down&id=<?php echo $value['id'] ?>"><i class="fa fa-angle-down"></i></a></td>
  </tr>
      
      <?php } ?>

</table>

</div>
<div class="paginacao">

  <?php
       /*para realizar a paginação*/
    $totalPaginas = ceil(count(Painel::selectAll('tb_site.slides')) / $porPagina);

       /*agora vou realizar o loop*/
       for($i = 1; $i <= $totalPaginas; $i++){
        if($i == $paginaAtual)
          echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'listar-slides?pagina='.$i.'">'.$i.'</a>';
        else
          echo '<a href="'.INCLUDE_PATH_PAINEL.'listar-slides?pagina='.$i.'">'.$i.'</a>';
        
       }
  ?>

</div><!--paginação-->

</div><!--box-content--> <!--1º container da tela-->  