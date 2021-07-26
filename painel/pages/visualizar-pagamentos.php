<div class="box-content"> 

  <!--inicio - quando eu quiser enviar um emai-->
  <?php
    if(isset($_GET['email'])){
      //Queremos enviar um e-mail avisando o atraso!
      $parcela_id = (int)$_GET['parcela'];
      $cliente_id = (int)$_GET['email'];

      if(isset($_COOKIE['cliente_'.$cliente_id])){
          Painel::alert('erro','Você já enviou um e-mail cobrando desse cliente! Aguarde mais um pouco.');
      }else{
        //Podemos enviar o email
     $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE id = $parcela_id");
     $sql->execute();
     $infoFinanceiro = $sql->fetch();

     $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE id = $cliente_id");
     $sql->execute();
     $infoCliente = $sql->fetch();
     /*inicio - corpo do email*/
     $corpoEmail = "Olá $infoCliente[nome], você está com um saldo pedente de $infoFinanceiro[valor]com o vencimento para $infoFinanceiro[vencimento]. Entre em contato conosco para quitar suas parcelas";
     $email = new Email('vps.dankicode.com','teste@danicode.com','123456','Guilhereme');
     $email->addAdress($infoCliente['email'], $infoCliente['nome']);
     $email->formatarEmail(array('assunto'=>'Cobrança','corpo'=>$corpoEmail));
     $email->enviarEmail();

        Painel::alert('sucesso','E-mail enviado com sucesso!');
        setcookie('cliente_'.$cliente_id,'true',time()+30,'/');/*30 segundo para o Cookie ser destruido .... estes 30 segundo são para demora de enviar outro email...esta aula modulo 29 ultima aula*/
      }
    }
   ?>

  <!--fim - quando eu quiser enviar um emai-->

  <!--inicio - se clicar no botão url pago (GET)-->
  <?php
  if(isset($_GET['pago'])){
      $sql = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");
      $sql->execute(array($_GET['pago']));
      Painel::alert('sucesso','O pagamento foi quitado com sucesso!');
    }
   ?>
<!--fim - depois do form eu ou h2 titulo adicionar pagamento-->
<!--estotu fora do form e continuo a pagina. Fazendo a listagem de pagamento-->
<h2><i class="fa fa-id-card-o"></i> Pagamentos Pendentes</h2>
<div class="gerar-pdf">
  <a target="_blank" href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamento=pendente">Gerar PDF</a>
</div><!--gerar-pdf-->

<div class="wraper-table">
    <table>
      <tr>
          <td>Nome do pagamento</td>
          <td>Cliente</td>
          <td>Valor</td>
          <td>Vencimento</td>
          <td>Enviar e-mail</td>
          <td>Marcar como pago</td>
      </tr>
      <!--inicio-->
      <?php
         $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 ORDER BY vencimento ASC"); /*ORDER BY vencimento ASC faz a data aparecer front end de forma crescente..do menor para o maior*/
         $sql->execute();
         $pendentes = $sql->fetchAll();

         /*vamos realizar o loop*/
         foreach ($pendentes as $key => $value) {/*no foreach  eu tenho que colocar como pendente porque é onde estão todas as minhas variaveis */

          /*vou pegar o clienteNome separa dos outros*/
          $clienteNome = MySql::conectar()->prepare("SELECT `nome`,`id` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
          $clienteNome->execute();
          $info = $clienteNome->fetch();
          $clienteNome = $info['nome'];
          $idCliente = $info['id'];

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
      <td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos?email=<?php echo $info['id']; ?>&parcela=<?php echo $value['id']; ?>"><i class="fa fa-envelope" aria-hidden="true"></i> E-mail</a></td>

      <td><a style="background: #00bfa5;" class="btn" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-cliente?id=<?php echo $id; ?>&pago=<?php echo $value['id'] ?>"><i class="fa fa-check"></i>Pago</a></td>
         <!--botão editar-->
      
      </tr>

         <?php } ?>

      <!--fim-->
    </table>

</div>  


<h2><i class="fa fa-id-card-o"></i> Pagamentos Concluidos</h2>

<div class="gerar-pdf">
  <a target="_blank" href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamento=concluidos" target="_blank">Gerar PDF</a>
</div><!--gerar-pdf-->

<div class="wraper-table">
    <table>
      <tr>
          <td> Nome do pagamento</td>
          <td> Cliente</td>
          <td> Valor</td>
          <td> Vencimento</td>
      </tr>
    </table>

</div> 

</div><!--box-content--> <!--1º container da tela-->  