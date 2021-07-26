
<section class="banner-container"> <!--banner-principal..."pega a tela quase toda"-->

	  <div style="background-image: url('<?php echo INCLUDE_PATH; ?>imagens/cozin_blu.jpg');"
	    class="banner-single"></div><!--banner-single-->

	  <div style="background-image: url('<?php echo INCLUDE_PATH; ?>imagens/connect_web.jpg');" 
	  	class="banner-single"></div><!--banner-single-->

	  <div style="background-image: url('<?php echo INCLUDE_PATH; ?>imagens/cozinha_integra.jpg');"
	   class="banner-single"></div><!--banner-single-->
	  
		<div class="overlay"></div><!--overlay-->

		<div class="center"></div>
	
 <!--Bolinhas de Navegação...esta sendo codificado no slider.js o content(conteniner) é a div-->
		<div class="bullets"></div><!--bullets--> 
				
</section><!--banner-container-->


	<section id="sobrevictor" class="descricao-autor"><!--Descrição do Autor-->
		<div class="center"> <!--encapsulamento div center...para trabalhar com disgner responsivo--->
		<div  class="w100 left"> <!--w50 significa que usará 50% da largura da tela-->
			<h2 class="text-center"><img src="<?php echo INCLUDE_PATH ?>imagens/foto.jpg"/><br /><?php echo $infoSite['nome_autor']; ?></h2>
			<p><?php echo $infoSite['descricao']; ?></p>
			
		</div><!--w100-->

		<!--<div class="w50 left" >--> <!--Nos outros 50% da largura vamos colocar uma imagens-->
			<!--
			<img class="right" src="<?php //echo INCLUDE_PATH; ?>imagens/foto.jpg"/>
		</div>-->
		<div class="clear"></div>
		</div><!--center-->
	</section><!--descição-autor-->

	<section id="especialidade"  class="especialidades"> <!--especialidades-->
		<div class="center"><!--Center para trabalhar com disgner responsivo-->
		<h2 class="title">Diversas Linhas & Marcas Trabalho de Qualidade com o seu perfil !</h2>
			<!--<h2 class="title">Especialidades</h2>-->
		  
			<div  class="w33 left box-especialidades">
			  <h3><img class="right" src="<?php echo INCLUDE_PATH; ?>imagens/gelad_industrial.jpg"/></h3>
				<!--<h3><i class="fab fa-css3-alt"></i></h3>-->
				<h4><i class="<?php echo $infoSite['icone1']; ?>" aria-hidden="true"></i></h4>
				<p><?php echo $infoSite['descricao1']; ?></p>
			</div>	

			<div class="w33 left box-especialidades">
			  <h3><img class="right" src="<?php echo INCLUDE_PATH; ?>imagens/gelad_acougue.jpg"/></h3>
				<!--<h3><i class="fab fa-html5"></i></h3>-->
				<h4><i class="<?php echo $infoSite['icone2']; ?>" aria-hidden="true"></i></h4>
				<p><?php echo $infoSite['descricao2']; ?></p>
			</div>

			<div class="w33 left box-especialidades">
				<h3><img class="right" src="<?php echo INCLUDE_PATH; ?>imagens/gelad_comum.jpg"/></h3>
				<!--<h3><i class="fab fa-js"></i></h3>-->
				<h4><i class="<?php echo $infoSite['icone3']; ?>" aria-hidden="true"></i></h4>
				<p><?php echo $infoSite['descricao3']; ?></p>
			</div>
			
			
			<div class="clear"></div><!--Nós estamos usando  flutuação então no final colocamos clear em uma div-->
		</div>
	</section>

	<section class="extras"><!--Extras-->

		<div class="center">
		<div id="depoimentos" class="w50 left depoimentos-container"> <!--w50 metade da tela-->
		  <h2 class="title">Satisfação dos Clientes</h2>
		  
           <!--Rodar do php para pegar uso na query selecionar-->
           <?php
             $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` ORDER BY order_id ASC LIMIT 6 ");
             $sql->execute();
             $depoimentos = $sql->fetchAll();
              foreach ($depoimentos as $key => $value) {	
              
            ?>

		  <div class="depoimento-single"> <!--Div single-->
		  	<p class="depoimento-descricao">"<?php echo $value['depoimento']; ?>"</p>
		  	<p class="nome-autor"><?php echo $value['nome']; ?> - <?php echo $value['data']; ?></p>
		  </div><!--depoimento-single-->
		  <?php } ?>
		</div><!--w50-->


		<div id="servicos" class="w50 left servicos-container"> <!--w50-->
			<h2 class="title">Serviço</h2>
			<div class="servicos"><!--Serviços-->
			<ul>

            <!--Vou rodar o php e recuperar os valores de cadastrar-serviço-->
            <?php
                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.servicos` ORDER BY order_id ASC LIMIT 6");
                $sql->execute();
                $servicos = $sql->fetchAll();
                foreach ($servicos as $key => $value) {
                	              
             ?>
                
				<li><?php echo $value['servico']; ?></li>

				<?php } ?>
				
			</ul>
			</div><!--serviços-->
		</div><!--w50-->
		<div class="clear"></div>
		</div><!--center-->	
	</section><!--extras-->

	