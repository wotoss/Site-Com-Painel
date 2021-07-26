	<?php
	include('../config.php');
            //$data = []; //pode ser feito assim  ou como a linha abaixo
	$data = array();
	$assunto = 'Novo mensagem do site!';
	$corpo = '';
	foreach ($_POST as $key => $value) { /*coloquei o foreach do php para percorrer o array e o array que ele vai percorre é $_POST...sendo assim ele vai  percorrer nome email telefone e quantos camops mais você tenha em seu formulário.*/
		$corpo.=ucfirst($key).": ".$value; /*Este ucfirst faz com que a primeira letra da string seja maiscula...da string do campo que é chamdo´pela  ($key) trás a posição atual percorrida pelo foreach */
		$corpo.="<hr>";
	}


	$info = array('assunto'=>$assunto,'corpo'=>$corpo);
	/*Muito tranquilo eu chamo a classe email instancio ela para o mail dai passo os parametros que veio da minha do construtor da minha classe email($host,$username,$senha,$name)*/
	$mail = new Email('vps.dankicode.com','testes@dankicode.com','gui123456','Guilherme');
	$mail->addAdress('contato@dankicode.com','Guilherme');
		 	$mail->formatarEmail($info); //Chamo o método da classe formatarEmail($info) dentro dela coloco o paramentro ($info) que trás junto o assunto e o corpo do meu email... e que a minha variavel do array três linhas acima.
		 	if ($mail->enviarEmail()){
		 		$data['sucesso'] = true;
		 	}else{
		 		$data['erro'] = true;
		 	}

			 //$data['retorno'] = 'sucesso';

		 	die(json_encode($data));/*O segredo do ajax está aqui no (json_encode) permite que o nosso array retorne em um formato que o javascript possa entender. */ 

		 	?>