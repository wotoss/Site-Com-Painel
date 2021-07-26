         <?php
         verificaPermissaoPagina(2);
         ?>

         <div class="box-content">
         	<h2><i class="fa fa-pencil"></i> Adicionar Usuário</h2>

         	<!--Fazer o formulário do tipo post-->
         	<form method="post" enctype="multipart/form-data"><!--para fazer upload de imagem eu tenho que usar ...enctype...-->

            <!--Vou fazer a atualização do formulário abaixo no bd-->
            <?php
            if(isset($_POST['acao'])){

             $login = $_POST['login'];
             $nome = $_POST['nome'];
             $senha = $_POST['password'];
             $imagem = $_FILES['imagem'];
             $cargo = $_POST['cargo'];


             /*Veja que interressante estou fazendo a validação pelo php ao invés de realizar pelo front end em html com required*/

             if($login == ''){
               Painel::alert('erro','O login está vázio !');
             }elseif($nome == '') {
               Painel::alert('erro','O nome está vázio !');
             }elseif ($senha == ''){
               Painel::alert('erro','A senha está vázia !');
             }elseif ($cargo == '') {
               Painel::alert('erro','O cargo está vázio !');
             }elseif ($imagem['name'] == ''){
              Painel::alert('erro','A imagem precisa estar selecionada !');
            }else{
                       //Podemos cadastrar!
             if($cargo >= $_SESSION['cargo']){
               Painel::alert('erro','Você precisa selecionar um cargo menor que o seu!');
             }elseif (Painel::imagemValida($imagem) == false) {
               Painel::alert('erro','O formato especificado não está correto');
             }elseif (Usuario::userExists($login)) {
               Painel::alert('erro', 'O login já existe, selecione outro por favor !');
             }else{
                         //Apenas cadastrar no banco de dados.
               /*instanciando a classe Usuario encontrda na pagina Usuario.php..*/
               $usuario = new Usuario();
               $imagem = Painel::uploadFile($imagem);
               $usuario->cadastrarUsuario($login,$senha,$imagem,$nome,$cargo);/*Estes dados estão vindo do bd e tambem do inicio desta pagina post*//*Estou pegando da pagina Usuario.php*/
               Painel::alert('sucesso','O cadastro do usuário '.$login.' foi feito com sucesso!');

             }

           }


         }
         ?>

         <!--Não vou realizar a validação no front end exemplo o login com required...vou fazer em php..para treinar -->
         <div class="form-group">
           <label>Login: </label>
           <input type="text" name="login">
           <!--<input type="text" name="login" required>-->
         </div><!--form-group-->

         <div class="form-group">
          <label>Nome: </label>
          <input type="text" name="nome">
         </div><!--form-group-->

         <div class="form-group">
          <label>Senha: </label>
          <input type="password" name="password">
         </div><!--form-group-->


         <div class="form-group">
           <label>Cargo: </label>
           <select name="cargo">
             <?php
             foreach (Painel::$cargos as $key => $value) { /*cargos menor que o meu...$Key....administrador*/
              if($key < $_SESSION['cargo']) echo '<option value="'.$key.'">'.$value.'</option>';
            }
            ?>
          </select>
         </div><!--form-group-->


         <div class="form-group">
          <label>Imagem: </label>
          <input type="file" name="imagem"/>

         </div><!--form-group-->


         <div class="form-group">
          <input type="submit" name="acao" value="Atualizar!">
         </div><!--form-group-->


         </form>

         </div>