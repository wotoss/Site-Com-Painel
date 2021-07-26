<?php
  $usuariosOnline = Painel::listarUsuarioOnline();

  /*Pega visitas direto do banco de dados*/
   $pegarVisitasTotais = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas`");
   $pegarVisitasTotais->execute();

   $pegarVisitasTotais = $pegarVisitasTotais->rowCount();

   /*Visitas Hoje*/
   $pegarVisitasHoje = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas` WHERE dia = ?");
   $pegarVisitasHoje->execute(array(date('Y-m-d')));

  $pegarVisitasHoje = $pegarVisitasHoje->rowCount();

?>
<div class="box-content left w100">
	<!--Este carregamento...<?php //echo $NOME_EMPRESA ?>..este vindo do config.php-->


<h2><i class="fa fa-home"></i>Painel de Controle - <?php echo NOME_EMPRESA ?></h2>

    <div class="box-metricas">
      <div class="box-metrica-single">
        <div class="box-metrica-wraper">
          <h2>Usuários Online</h2>

          <p><?php echo count($usuariosOnline); ?></p><!--Fazer a contagem de forma dinanmica-->  
          
        </div><!--box-metrica-wraper--> 
      </div><!--box-metrica-single-->
      <div class="box-metrica-single">
        <div class="box-metrica-wraper">
        <h2>Total de Visitas</h2>
        <p><?php echo $pegarVisitasTotais; ?></p>
      </div><!--box-metrica-wraper-->
      </div><!--box-metrica-single-->
      <div class="box-metrica-single">
        <div class="box-metrica-wraper">
          <h2>Visitas Hoje</h2>
          <p><?php echo $pegarVisitasHoje; ?></p>
        </div><!--box-metrica-wraper-->
      </div><!--box-metrica-single-->
       <div class="clear"></div>
    </div><!--box-metricas-->

	</div><!--box-content-->
<div class="clear"></div>

	<div class="box-content w100">

    <h2><i class="fa fa-rocket" aria-hidden="true"></i> Usuários Online no Site</h2>

    <div class="table-responsive">
    	<div class="row">
    		<div class="col">
    			<span>IP</span>
    		</div><!--col-->

    		<div class="col">
    			<span>Última Ação</span>
    		</div><!--Col-->
    		<div class="clear"></div>
    	</div><!--row-->
         
         <?php /*Criar um lupin*/
            
            foreach ($usuariosOnline as $key => $value) { 

         ?>
    	<div class="row">
    		<div class="col">
    			<span><?php echo $value['ip'] ?></span>
    		</div><!--col-->



      
    	 <div class="col"> 
            
           <span><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao'])) ?></span>	
           
    		</div><!--Col-->







    		<div class="clear"></div>
    	</div><!--row-->
    <?php } ?> <!--fechar o lupim-->
    </div><!--table-responsive-->
		
	</div><!--box-content-->

	<!--<div class="clear"></div>-->


  <!--Proxima pagina-->
<div class="box-content w100">
  <h2><i class="fa fa-rocket" aria-hidden="true"></i> Usuários Painel</h2>

    <div class="table-responsive">
      <div class="row">
        <div class="col">
          <span>Nome</span>
        </div><!--col-->

        <div class="col">
          <span>Cargo</span>
        </div><!--Col-->
        <div class="clear"></div>
      </div><!--row-->
         
         <?php /*Criar um lupin*/
            $usuariosPainel = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios`");
            $usuariosPainel->execute();
            $usuariosPainel = $usuariosPainel->fetchAll();
            foreach ($usuariosPainel as $key => $value) {
              # code...
            
         ?>
      <div class="row">
        <div class="col">
          <span><?php echo $value['user'] ?></span>
        </div><!--col-->

        <div class="col">
          <span><?php echo pegaCargo($value['cargo']); ?></span>
        </div><!--Col-->
        <div class="clear"></div>
      </div><!--row-->
    <?php } ?> <!--fechar o lupim-->
    </div><!--table-responsive-->
    
  </div><!--box-content-->

  <!--<div class="clear"></div>-->

