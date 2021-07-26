<?php
   if(isset($_GET['id'])){
       $id = (int)$_GET['id'];
       $cliente = Painel::select('tb_admin.clientes','id = ?',array($id));
   }else{
       Painel::alert('erro','Você precisa passar o parametro ID.');
       die(); /* die() Mata o script*/
   }

 ?>

<div class="box-content">
	<h2><i class="fa fa-pencil"></i> Editar Cliente</h2>

	<!--Fazer o formulário do tipo post-->
	<form class="ajax" atualizar method="post" action="<?php echo INCLUDE_PATH_PAINEL ?>ajax/forms.php" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

<!--TODA A RECUPERAÇÃO DOS DADOS VINDO BD ESTÁ VINDO DA PAGINA e forms.php-->

    <div class="form-group">
      <label>Nome: </label>
      <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>">
    </div><!--form-group-->
        
        <div class="form-group">
          <label>E-mail: </label>
          <input type="text" name="email" value="<?php echo $cliente['email']; ?>">
        </div><!--form-group-->
         

         <div class="form-group">
          <label>Tipo: </label>
          <select name="tipo_cliente">
            <option <?php if($cliente['tipo'] == 'fisico') echo 'selected'; ?> value="fisico">Fisico</option>
            <option <?php if($cliente['tipo'] == 'juridico') echo 'selected'; ?> value="juridico">Jurídico</option> 
          </select>
        </div><!--form-group-->

<!--inicio - validação para escolha de cpf_cnpj-->
        <?php
           if($cliente['tipo'] == 'fisico'){
         ?>

        <div ref="cpf" class="form-group">
          <label>CPF</label>
          <input type="text" name="cpf" value="<?php echo $cliente['cpf_cnpj']; ?>" />
        </div><!--form-goup-->

        <div style="display: none;" ref="cnpj" class="form-group">
          <label>CNPJ</label>
          <input type="text" name="cnpj"  /> <!--atraves do name eu consigo validar no bd-->
        </div><!--form-goup-->

          <?php }else{ ?>

        <div style="display: none;" ref="cpf" class="form-group">
          <label>CPF</label>
          <input type="text" name="cpf" />
        </div><!--form-goup-->

        <div style="display: block;" ref="cnpj" class="form-group">
          <label>CNPJ</label>
          <input type="text" name="cnpj" value="<?php echo $cliente['cpf_cnpj']; ?>"  /> <!--atraves do name eu consigo validar no bd-->
        </div><!--form-goup-->

          <?php } ?>

<!--fim - validação para escolha de cpf_cnpj-->

        <div class="form-group">
          <label>Imagem: </label>
          <input type="file" name="imagem"/>

        </div><!--form-group-->

        <div class="form-group">
          <input type="hidden" name="imagem_original" value="<?php echo $cliente['imagem']; ?>">
        </div><!--form-group referente a imagem -->

        <div class="form-group">
          <input type="hidden" name="tipo_acao" value="atualizar_cliente">
        </div><!--form-group-- este é hidden..escondido>-->

        <div class="form-group">
          <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
        </div><!--form-group id-->


        <div class="form-group">
          <input type="submit" name="acao" value="Atualizar!">
        </div><!--form-group-->


  </form><!--post-->
<!--NO ARQUIVO /JS/CONTROLEFINANCEIRO.PHP E QUE IMPLEMENTAOS O S PAGAMENTOS-->
<!--inicio - depois do form eu ou h2 titulo adicionar pagamento-->
  <h2><i class="fa fa-pencil"></i> Adicionar Pagamentos</h2>

  <form method="post">

    <!--inicio - da implementação do formulário-->
    <?php
       if(isset($_POST['acao'])){
        /*informações vinda do bd*/
        $cliente_id = $id;
        $nome = $_POST['nome_pagto'];
        //$valor = str_replace('.','',$_POST['valor']);/*estou transformando o valor do formato double usando str_replace*/
        //$valor = str_replace(',','.',$valor);
        $valor = $_POST['valor'];
        $intervalo = $_POST['intervalo'];
        $numero_parcelas = $_POST['parcelas'];
        $status = 0;
        $vencimentoOriginal = $_POST['vencimento'];

    /*inicio - validação de vencimento não aceitando vencimento menor que a data atual*/
      if(strtotime($vencimentoOriginal) < strtotime(date('Y-m-d'))){/*não quero que cadastre data negativa*/
         Painel::alert('erro','Você selecionou uma data negativa!');
        }else{/*foi cadastrado com sucesso*/

        for($i = 0; $i < $numero_parcelas; $i++){/*for*/
          $vencimento = strtotime($vencimentoOriginal) + (($i * $intervalo)*(60*60*24));
          $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.financeiro` VALUES (null,?,?,?,?,?)");
          $sql->execute(array($cliente_id,$nome,$valor,date('Y-m-d',$vencimento),0));
        }
          
        Painel::alert('sucesso','O(s) pagamento(s) foi inserido com sucesso');
         
          
         

          }   
       }
       

     ?>

    <!--fim - da implementação do formulário-->

    <div class="form-group">
        <label>Nome do pagamento:</label>
        <input type="text" name="nome_pagto"  /> 
    </div><!--form-goup-->
    
    <div class="form-group">
        <label>Valor do pagamento:</label>
        <input type="text" name="valor"  /> 
    </div><!--form-goup-->

    <div class="form-group">
        <label>Número de parcelas:</label>
        <input type="text" name="parcelas"  /> 
    </div><!--form-goup-->

    <div class="form-group">
        <label>Intervalo:</label>
        <input type="text" name="intervalo" /> 
    </div><!--form-goup-->

    <div class="form-group">
        <label>Vencimento:</label>
        <input type="date" name="vencimento" value="<?php echo date('Y-m-d'); ?>" /> 
    </div><!--form-goup-->

    <div class="form-group">
       <input type="submit" name="acao" value="Inserir Pagamento">
    </div>
    
  </form>

  <?php
            /*quando clikar no pago ele vai mudar para verde*/
    if(isset($_GET['pago'])){
    $sql = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");
    $sql->execute(array($_GET['pago']));
    Painel::alert('sucesso','O pagamento foi quitado com sucesso!');

       }


   ?>


  
<!--fim - depois do form eu ou h2 titulo adicionar pagamento-->

<!--estotu fora do form e continuo a pagina. Fazendo a listagem de pagamento-->
<h2><i class="fa fa-id-card-o"></i> Pagamentos Pendentes</h2>

<div class="wraper-table">
    <table>
      <tr>
          <td> Nome do pagamento</td>
          <td> Cliente</td>
          <td> Valor</td>
          <td> Vencimento</td>
          <td>Enviar e-mail</td>
          <td>Marcar como pago</td>
      </tr>
    <!--iniciando a conexão com banco de dados -->
      <?php
         $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 ORDER BY vencimento ASC"); /*ORDER BY vencimento ASC faz a data aparecer front end de forma crescente..do menor para o maior*/
         $sql->execute();
         $pendentes = $sql->fetchAll();

         /*vamos realizar o loop*/
         foreach ($pendentes as $key => $value) {/*no foreach  eu tenho que colocar como pendente porque é onde estão todas as minhas variaveis */

          /*vou pegar o clienteNome separa dos outros*/
          $clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
          $clienteNome->execute();
          $clienteNome = $clienteNome->fetch()['nome'];

          /*vou montar a implementação de cores quando estiver vencido ou pago*/
          $style =""; /*inicio o estilo vazio*/
          if(strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])){
            $style = 'style="background-color:#ff7070;font-weight:bold;"'; /*o que esta vencido aparece desta forma*/
          }
         ?> 
           
      <tr <?php echo $style; ?>><!--não esquecer de imprimir(echo) o stilo style aqui na tabela-->
          <td><?php echo $value['nome']; ?></td>
          <td><?php echo $clienteNome; ?></td>
          <td><?php echo $value['valor']; ?></td>
          <!--conversão das horas-->
          <td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
          <!--inicio - dos botões-->
      <td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fa fa-envelope" aria-hidden="true"></i> E-mail</a></td>

      <td><a style="background: #00bfa5;" class="btn" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-cliente?id=<?php echo $id; ?>&pago=<?php echo $value['id'] ?>"><i class="fa fa-check"></i>Pago</a></td>
         <!--botão editar-->
      
      </tr>

         <?php } ?>

      

    </table>

</div>  


<h2><i class="fa fa-id-card-o"></i> Pagamentos Concluidos</h2>

<div class="wraper-table">
    <table>
      <tr>
          <td> Nome do pagamento</td>
          <td> Cliente</td>
          <td> Valor</td>
          <td> Vencimento</td>
      </tr>
      
          <!--iniciando a conexão com banco de dados -->
      <?php
         $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 1 ORDER BY vencimento ASC LIMIT 10"); /*ORDER BY vencimento ASC faz a data aparecer front end de forma crescente..do menor para o maior*/
         $sql->execute();
         $pendentes = $sql->fetchAll();

         /*vamos realizar o loop*/
         foreach ($pendentes as $key => $value) {/*no foreach  eu tenho que colocar como pendente porque é onde estão todas as minhas variaveis */

          /*vou pegar o clienteNome separa dos outros*/
          $clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
          $clienteNome->execute();
          $clienteNome = $clienteNome->fetch()['nome'];

        ?>
           
      <tr>
          <td><?php echo $value['nome']; ?></td>
          <td><?php echo $clienteNome; ?></td>
          <td><?php echo $value['valor']; ?></td>
          <!--conversão das horas-->
          <td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
      </tr>

         <?php } ?>

    </table>

</div>  
</div><!--box-content-->



