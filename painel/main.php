<?php
  if(isset($_GET['loggout'])){
  	   Painel::loggout();
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Painel de Controle</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!--Deixar meu site responsivo-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>estilo/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>css/jquery-ui.min.css">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>estilo/font-awesome.css">


	<!--<link rel="stylesheet" href="<?php //echo INCLUDE_PATH_PAINEL?>css/style.css"/>--><!--Para funcionar(chamar o css em meu html) o css-->

  <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH_PAINEL; ?>css/style.css"/>
 
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/default/zebra_datepicker.min.css">
 
	
</head>
<body>

  <!--inicio para fazer valer o  aquivo delete.php da tela cadastrar-clientes que é em ajax-->
  <base base="<?php echo INCLUDE_PATH_PAINEL; ?>" /> <!--clientes.js tambem usando ajax-->
  <!--fim -Isto foi colocado por causa da pagina cadastrar-cliente e delete..57% do curso-->

<div class="menu">
  <div class="menu-wraper">
   <div class="box-usuario">
   	<!--Usar o php para deixar a minha foto dinamica-->
   	<?php
   	   if($_SESSION['img'] == ''){
   	?>
   	  <div class="avatar-usuario">
   	  	 <i class="fa fa-user"></i>
   	  </div><!--avatar-usuario-->
      <?php }else{ ?>
          <div class="imagem-usuario">
          	 <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $_SESSION['img']; ?>" />
          </div>
      <?php } ?><!--imagem-usuario-->

   	  <div class="nome-usuario">
   	  	  <p><?php echo $_SESSION['nome']; ?></p>
   	  	  <p><?php echo pegaCargo($_SESSION['cargo']); ?></p>
   	  </div><!--nome-usuario-->
   </div><!--box-usuario-->

   <div class="items-menu">
    <h2>Cadastro</h2><!--Cadastro esta é uma sessão-->
    

    <a <?php selecionadoMenu('cadastrar-depoimento'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-depoimento">Cadastrar Depoimento</a>

    <a <?php selecionadoMenu('cadastrar-servico'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-servico">Cadastrar Serviço</a>

    <a <?php selecionadoMenu('cadastrar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-slides">Cadastrar Slides</a>

    <h2>Gestão</h2><!--Gestão esta é outra sessão-->
    <a <?php selecionadoMenu('listar-depoimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos">Listar Depoimentos</a>

    <a <?php selecionadoMenu('listar-servicos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos">Listar Serviços</a>

    <a <?php selecionadoMenu('listar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides">Listar Slides</a>

    <h2>Administração do painel</h2><!--Está é outra sessão-->

    <a <?php selecionadoMenu('editar-usuario'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-usuario">Editar Usuário</a>

    <a <?php selecionadoMenu('adicionar-usuario') ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>adicionar-usuario">Adicionar Usuários</a> 

    <h2>Configuração Geral</h2><!--Configuração geral outra sessão-->

    <a <?php selecionadoMenu('editar-site');?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-site">Editar Site</a>
    
    <!--NESTE MOMENTO COMEÇA GESTÃO DE NOTICIAS -->
    <h2>Gestão de Notícias</h2>
    <a <?php selecionadoMenu('cadastrar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-categorias">Cadastrar Categorias</a>

    <a <?php selecionadoMenu('gerenciar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categorias">Gerenciar Categorias</a>

    
    <a <?php selecionadoMenu('cadastrar-noticia'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-noticia">Cadastrar Notícias</a>

    <a <?php selecionadoMenu('gerenciar-noticias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticias">Gerenciar Notícias</a>

    <!--dando continuidade ao projeto 26/11/19-->
    <h2>Gestão de Clientes</h2>
    <a <?php selecionadoMenu('cadastrar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-clientes">Cadastrar Clientes</a>

    <a <?php selecionadoMenu('gerenciar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-clientes">Gerenciar Clientes</a>

    <!--inicio - menu controle financeiro-->
    <h2>Controle Financeiro</h2>
    <a <?php selecionadoMenu('visualizar-pagamentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos">Visualizar Pagamentos</a>
    <!--fim - menu controle financeiro-->

    <!--inicio - controle de estoque ou loja virtual-->
    <h2>Controle Estoque</h2> <!--SERÁ CONSTRUIDO NESTE MODULO LOJA VIRTUAL--> 
    <!-- função para deixar o link selecionado-->
    <!--este é o proprio link ..href="<?php //echo INCLUDE_PATH_PAINEL ?>cadastrar-produtos">Cadastrar Produtos<-->
    <a <?php selecionadoMenu('cadastrar-produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-produtos">Cadastrar Produtos</a>

    <a <?php selecionadoMenu('visualizar-produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Visualizar Produtos</a>
    <!--fim - controle de estoque TEREMOS TAMBEM UMA EM BREVE loja virtual-->

    <h2>Gestão Imóveis</h2>
    <!--inicio - para cadastrar-->
    <a <?php selecionadoMenu('cadastrar-empreendimento'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-empreendimento">Cadastrar Empreendimento</a>
    <!--fim - para cadastrar-->

    <!--inicio - para listar-->
    <a <?php selecionadoMenu('listar-empreendimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-empreendimentos">Listar Empreendimentos</a>
    <!--fim - para listar-->

   </div><!--items-menu-->
 </div><!--menu-wraper-->
</div><!--menu-->	
<header>
  <div class="center">
    <div class="menu-btn">
    	<i class="fa fa-bars"></i>
    	
    </div><!--menu-btn-->	
	<div class="loggout">
    <a <?php if(@$_GET['url'] == ''){ ?> style="background: #60727a; padding: 15px;" <?php } ?> href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fa fa-home"></i> <span>Página Inicial</span></a> <!--fazendo o icone home-->
	 <a href="<?php echo INCLUDE_PATH_PAINEL ?>?loggout"><i class="fa fa-window-close"></i> <span>Sair</span></a>
	</div><!--Fim do loggout-->
    <div class="clear"></div><!--toda vez que utilizo o float no css tenho usar o (clear)-->
  </div><!--Center-->				
</header>
<!--Este conteiner é o meu conteudo principal-->
<div class="content">
 <!--Orientação a objeto estou trazendo o arquivo Painel-->
  <?php Painel::carregarPagina(); ?>

</div><!--content-->

<!--JavaScript-->
<script src="<?php echo INCLUDE_PATH ?>js/jquery.js"></script>
<?php Painel::loadJS(array('jquery-ui.min.js'),'listar-empreendimentos'); ?>

<!--
<script
  src="https://cdn.jsdelivr.net/npm/zebra_datepicker@1.9.6/dist/zebra_datepicker.min.js"></script>
-->

<!--
<script src="https://cdn.jsdelivr.net/gh/stefangabos/Zebra_Datepicker/dist/zebra_datepicker.min.js"></script>
-->
<script
  src="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/zebra_datepicker.min.js"></script>

<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.maskMoney.js"></script>

<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.mask.js"></script><!--Tem que ser colocada depois da biblioteca jquery..porque jquery.mask.js depende dela-->
<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.ajaxform.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/constants.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/main.js"></script>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
selector:'.tinymce', /*colocando o editor tinymce...somente puchado pela classe
  olha a simplicidade vai em cadastrar-noticia <div class="form-group"> escreve class tinymce...pronto*/
plugins: "image", /*pugin de imagem*/
height:300 /*altura do meu editor*/
});
</script>



<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/helperMask.js"></script>
<?php Painel::loadJS(array('ajax.js'),'gerenciar-clientes'); ?>
<?php Painel::loadJS(array('ajax.js'),'cadastrar-clientes'); ?>
<?php Painel::loadJS(array('ajax.js'),'editar-cliente'); ?>
<?php Painel::loadJS(array('controleFinanceiro.js'),'editar-cliente'); ?>
<?php Painel::loadJS(array('empreendimentos.js'),'listar-empreendimentos'); ?>

</body>
</html>
