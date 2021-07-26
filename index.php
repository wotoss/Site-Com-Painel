<?php include('config.php'); ?>
<?php Site::updateUsuarioOnline(); ?><!--Estou chamando do meu arquivo Site.php-->
<?php Site::contador(); ?><!--método contador está sendo feito arqivo Site.php-->
<!--Criando o Php no index pois consigo usar em todas as paginas estou na ultima
aula de configuração do sistema-->
<?php
  $infoSite = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
  $infoSite->execute();
  $infoSite = $infoSite->fetch();
 ?>




<!DOCTYPE html>
<html>
<head>

	<title><?php echo $infoSite['titulo']; ?></title>
	<link href="<?php echo INCLUDE_PATH; ?>estilo/style.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>estilo/font-awesome.min.css">
	
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--Parao disgner reponsivo, adaptar a qualquer tipo de tela-->
	<meta name="Keywords" content="palavras-chaves,do,meu,site">
	<meta name= "description" content="Descrição do meu website"> <!--Mecanismo de buscaPara encontrar o site mais rapido no google-->
	<link rel="icon" href="<?php echo INCLUDE_PATH; ?>favicon.ico" type="imagens/x-icon"/>
	<meta charset="utf-8"/> <!--É para questões de açentuação-->
</head>
<body>

    <!--Esta validação póderia estar no email-->
<base base="<?php echo INCLUDE_PATH; ?>"/>	

	<?php 
	 $url = isset($_GET['url']) ? $_GET['url'] : 'home';
      switch ($url) {
        case 'sobrevictor':
      		echo '<target target="sobrevictor"/>';
      		break;

      	
      	
      	case 'servicos':
      		echo '<target target="servicos"/>';
      		break;

      	case 'especialidade':
      		echo '<target target="especialidade"/>';
      		break;	

       }

	?>




   <div class="sucesso" >Formulário enviado com sucesso!</div>
   <!--Esta sendo feito o carregamento da imgen load-->
   <div class="overlay-loading">
   	 <img src="<?php echo INCLUDE_PATH ?>imagens/ajax-loader.gif" />
   </div><!--overlay-loading-->


	<!--type="text/css -->
	<header>
		<div class="center"> <!--Encapsulamento da div center para trabalhar com responsivo-->
		<div class="logo left"><a href="/">Cozinhas !</a></div><!--logo-->
		<nav class="desktop right">
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>sobrevictor">Sobre Victor</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>especialidade">Especialidade</a></li>
			    <li><a href="<?php echo INCLUDE_PATH; ?>servicos">Serviços</a></li>
			    <li><a href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
				<li><a realtime="contato" href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
				<!--<li><a realtime="outro-menu" href="<?php echo INCLUDE_PATH; ?>outro-menu">Outro menu</a></li>-->
				<li><a href="<?php echo INCLUDE_PATH; ?>painel">Painel</a></li>
			</ul>
		</nav>

		<nav class="mobile right">
			<div class="botao-menu-mobile">
			 <!--<i class="fas fa-bars"></i>-->
			 
			 <i class="fa fa-bars" aria-hidden="true"></i>
			</div>
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>sobrevictor">Sobre Victor</a></li>

				<li><a href="<?php echo INCLUDE_PATH; ?>especialidade">Especialidade</a></li>
			    <li><a href="<?php echo INCLUDE_PATH; ?>servicos">Serviços</a></li>
			    <li><a href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
				<li><a realtime = "contato" href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
		       <!-- <li><a realtime="outro-menu" href="<?php echo INCLUDE_PATH; ?>outro-menu">Outro menu</a></li>--><!--Carregar sem atualizar usando realtime-->
		        <li><a href="<?php echo INCLUDE_PATH; ?>painel">Painel</a></li>
			</ul>		
		</nav>
		<div class="clear"></div><!--clear-->
	    </div><!--center-->
	</header>


    <!--Esta é a logica em php para pagina sobre e serviço mostrar a home ou mostrar erro-->
<div class="container-principal">
	<?php
	  if(file_exists('pages/'.$url.'.php')){
	  	include('pages/'.$url.'.php');
	  }else{
	  	//Podemos fazer o que quiser, pois a página não existe.
	  	if ($url != 'depoimentos' && $url != 'sobrevictor' && $url != 'servicos' && $url != 'especialidade') {
	  		$urlPar = explode('/', $url)[0];
	  		if($urlPar != 'noticias'){
	  	     $pagina404 = true;
	  	     include('pages/404.php');
	  	}else{
	  	     include('pages/noticias.php');
	  	 }
	  		}else{
	  		include('pages/home.php');
	  	}
	  }
	?>
		
	</div><!--container-principal-->

	

	<footer <?php if(isset($pagina404) && $pagina404 == true) echo 'class="fixed"'; ?>><!--Rodapé-->
		<div class="center">
		<p>Todos os direitos reservados </p>
		</div><!--center-->
	</footer>

	<script src="<?php echo INCLUDE_PATH; ?>js/jquery.js"></script>
	<script src="<?php echo INCLUDE_PATH; ?>js/constants.js"></script>
	<!--
	<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDHPNQxozOzQSZ-djvWGOBUsHkBUoT_qH4'></script>-->
	<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDHPNQxozOzQSZ-djvWGOBUsHkBUoT_qH4'></script>
	<script src="<?php echo INCLUDE_PATH; ?>js/scripts.js"></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/map.js"></script>
	
	
	
<!--Iniciando a validação em javascript da pagina de noticias-->
    <?php
       if(is_array($url) && strstr($url[0],'noticias') !== false){
     ?>
     <script>
     	$(function(){
     		$('select').change(function(){
     			location.href=include_path+"noticias/"+$(this).val();
     		})
     	})
     </script>

 <?php
  }

  ?>
<!--Terminando a validação da pagina de noticias-->

	<?php
		if($url == 'contato'){
	?>

	<?php } ?>

	 
     <script src="<?php echo INCLUDE_PATH; ?>js/slider.js"></script>
     <script src="<?php echo INCLUDE_PATH; ?>js/exemplo.js"></script>  

      

	<script src="<?php echo INCLUDE_PATH; ?>js/formularios.js"></script>


</body>
</html>