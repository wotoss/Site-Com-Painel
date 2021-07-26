<!--Aqui neste momento eu vou pegar todos os depoimentos inseridos na lista do bd-->
<?php
    if(isset($_GET['excluir'])){
      $idExcluir = intval($_GET['excluir']);
      Painel::deletar('tb_site.servicos',$idExcluir);
      Painel::redirect(INCLUDE_PATH_PAINEL.'listar-servicos');
    }else if(isset($_GET['order']) && isset($_GET['id'])){
      Painel::orderItem('tb_site.servicos',$_GET['order'], $_GET['id']);
    }



   $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
   $porPagina = 4;

   $servicos = Painel::selectAll('tb_site.servicos',($paginaAtual - 1) * $porPagina,$porPagina);
?>


<div class="box-content"> 
<h2><i class="fa fa-id-card-o" arial-hidden="true"></i> Listagem de Serviços</h2>
<div class="wraper-table">
<table>
	<tr>
    
		<td><i class="fa fa-id-card-o" arial-hidden="true"> Serviços</td>
		<td><i class="fa fa-id-card-o" arial-hidden="true"> #</td>
		<td>#</td>
		<td>#</td>
    <td>#</td>
    
	</tr>

     <?php
        foreach ($servicos as $key => $value) {

     ?>


	<tr>
		<td class="texto"><?php echo substr($value['servico'],0,400); ?></td><!--nome da coluna do bd (nome, data) de lá que vem as informações e vai para tela-->
		
		<td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-servicos?id=<?php echo $value['id']; ?>"><i class="fa fa-pencil"></i>Editar</a></td>
		<td><a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos?excluir=<?php echo $value['id']; ?>"><i class="fa fa-times"> Excluir</i></a></td>
    <!--ordenamento-->
    <td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos?order=up&id=<?php echo $value['id'] ?>"><i class="fa fa-angle-up"></i></a></td>

    <td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos?order=down&id=<?php echo $value['id'] ?>"><i class="fa fa-angle-down"></i></a></td>
	</tr>
      
      <?php } ?>

</table>
</div>
</div>
<div class="paginacao">

	<?php
       /*para realizar a paginação*/
	  $totalPaginas = ceil(count(Painel::selectAll('tb_site.servicos')) / $porPagina);

       /*agora vou realizar o loop*/
       for($i = 1; $i <= $totalPaginas; $i++){
       	if($i == $paginaAtual)
       		echo '<a class="page-selected" href="'.INCLUDE_PATH_PAINEL.'listar-servicos?pagina='.$i.'">'.$i.'</a>';
       	else
       		echo '<a href="'.INCLUDE_PATH_PAINEL.'listar-servicos?pagina='.$i.'">'.$i.'</a>';
       	
       }
	?>

</div><!--paginação-->

</div><!--box-content--> <!--1º container da tela-->	