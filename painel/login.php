<?php
  if(isset($_COOKIE['lembrar'])){
    $user = $_COOKIE['user'];
    $password = $_COOKIE['password'];

    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ? ");
    $sql->execute(array($user,$password));
    if($sql->rowCount() == 1){
    $info = $sql->fetch(); /*Vai resgatar do bd info*/
    $_SESSION['login'] = true;
    $_SESSION['user'] = $user;
    $_SESSION['password'] = $password;
    $_SESSION['cargo'] = $info['cargo']; /*O $info buscar no BD ['cargo']*/
    $_SESSION['nome'] = $info['nome'];/*O $info buscar no BD ['nome']*/
    $_SESSION['img'] = $info['img'];
    header('Location: '.INCLUDE_PATH_PAINEL); /*header manda informação para o navegador. Já o Location faz o direcionamento.*/
    die();/*com o die() eu elimino o script e faço o direcionamento Location ou deixo passar paro o else logo abaixo.*/
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Painel de Controle</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!--Deixar meu site responsivo-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>estilo/font-awesome.min.css">
	<!--<link rel="stylesheet" href="<?php //echo INCLUDE_PATH_PAINEL?>css/style.css"/>--> <!--Para funcionar(chamar o css em meu html) o css-->
	<link href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css" rel="stylesheet" />
</head>
<body>

	<div class="box-login">

		<?php
		/*Recuperando o valor da tabela abaixo*/
          if(isset($_POST['acao'])){/*SE existir post(acao) é porque clicamos no formulário queremos (logar).*/
            $user = $_POST['user'];
           	$password = $_POST['password'];
           	$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ? ");
           	$sql->execute(array($user,$password));

           	if($sql->rowCount() == 1){
           		$info = $sql->fetch(); /* O fetch()..vai pegar apenas uma coluna*/
           		// Logamos com sucesso.
           		$_SESSION['login'] = true;
           		$_SESSION['user'] = $user;
           		$_SESSION['password'] = $password;
           		$_SESSION['cargo'] = $info['cargo']; /*O $info buscar no BD ['cargo']*/
           		$_SESSION['nome'] = $info['nome'];/*O $info buscar no BD ['nome']*/
           		$_SESSION['img'] = $info['img'];

              if(isset($_POST['lembrar'])){
                 setcookie('lembrar',true,time()+(60*60*24),'/'); /*Neste momento criei o setcookie*/ /*..'/'..esta barra significa que é para pegar em todo o site*/ /*Este login que contruir aqui ele é chamado pela pagina painel na função logout. Veja que lá eu coloco negativo e ele inspira.*/
                 setcookie('user',$user,time()+(60*60*24),'/');
                 setcookie('password',$password,time()+(60*60*24),'/');
              }
           		header('Location: '.INCLUDE_PATH_PAINEL); /*header manda informação para o navegador. Já o Location faz o direcionamento.*/
           		die();/*com o die() eu elimino o script e faço o direcionamento Location ou deixo passar paro o else logo abaixo.*/
           	}else{
           		//Falhou
           		echo '<div class="erro-box"><i class="fa fa-times"></i>Usuário ou senha incorretos!</div>';
             	}

           }


		?>

		<h2>Efetue o login</h2>
		<form method="post">
			<input type="text" name="user" placeholder="Login..." required>
			<input type="password" name="password" placeholder="Senha..." required>

      <div class="form-group-login left">
			<input type="submit" name="acao" value="Logar!">
      </div><!--Logar-->
      <!--Lembrar-me-->
      <div class="form-group-login right">
        <label>Lembrar-me</label>
      <input type="checkbox" name="lembrar"/>
      </div><!--Lembrar-me-->
      <div class="clear"></div>
		</form>

	</div><!--box-login-->

</body>
</html>