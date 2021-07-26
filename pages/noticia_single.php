
<?php
  $url = explode('/',$_GET['url']);
  
  $verifica_categoria = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE slug = ?");
  $verifica_categoria->execute(array($url[1]));
  if($verifica_categoria->rowCount() == 0){
     Painel::redirect(INCLUDE_PATH.'noticias');
  }
  $categoria_info = $verifica_categoria->fetch();

  $post = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE slug = ? AND categoria_id = ?");
  $post->execute(array($url[2],$categoria_info['id']));
  if($post->rowCount( ) == 0){
     Painel::redirect(INCLUDE_PATH.'noticias');
  }

  $post = $post->fetch();
 ?>

<section class="noticia-single">
	<div class="center">
	<article>
		<header>
			<h1><i class="fa fa-calendar"></i> <?php echo $post['data'] ?> - <?php echo $post['titulo'] ?></h1>	
		</header>
			<article>
				<?php echo $post['conteudo']; ?>
			</article>
		</div>
	</article>
</section>