<?php

   class Painel{

/*Variaveis cargo painel*/
    public static $cargos = [
     '0' => 'Normal',
     '1' => 'Sub Adminstrador',
     '2' => 'Administrador'];

     /*inicio - cadastro de cliente*/
     public static function loadJS($file,$page){
      $url = explode('/',@$_GET['url'])[0];
      if($page == $url){
        foreach ($file as $key => $value) {
           echo '<script src="'.INCLUDE_PATH_PAINEL.'js/'.$value.'"></script>';
        }
      }
     }
     /*fim - cadastro de cliente*/

   /*Criando a função generateSulg --- gerar Slug*/

    public static function generateSlug($str){
      $str = mb_strtolower($str);/*(mb_strtolower) mesmo com acentuação fique tudo em letra minuscula*/
      $str = preg_replace('/(â|á|ã)/', 'a', $str);
      $str = preg_replace('/(ê|é)/', 'e', $str);
      $str = preg_replace('/(í|Í)/', 'i', $str);
      $str = preg_replace('/(ú)/', 'u', $str);
      $str = preg_replace('/(ó|ô|õ|Ô)/', 'o', $str);
      $str = preg_replace('/(_|\/|!|\?|#)/', '', $str);
      $str = preg_replace('/( )/', '-', $str);
      $str = preg_replace('/ç/', 'c', $str);
      $str = preg_replace('/(-[-]{1,})/', '-', $str);
      $str = preg_replace('/(,)/', '-', $str);
      $str=strtolower($str);/*para garantir fique em letra minuscula*/
      return $str;

    }


   	
   	public static function logado(){
   		/*Usando operador ternario*/
   		return isset($_SESSION['login']) ? true : false;
   	 }

   	 /*implementando a função loggout que está sendo chamada no main.php*/
   	 public static function loggout(){
      setcookie('lembrar','true',time()-1,'/'); /*Não tenho como destruir um cookie então eu coloco ele negativo...ai quando for entrar na pagina novamente o cookie esta espirado*/  /*....('/') significa que para pegar em todo o site*/

   	 	session_destroy(); /*Destroy tudo que tem na pagina inclusive as sessões*/
   	    header('Location: '.INCLUDE_PATH_PAINEL); /*redireciona para o login..atraves do config.php*/
   	    /*Já esta função ela direciona para o config.php..lá tem as constantes..INCLUDE_PATH_PAINEL..que dará acesso de login..Lembrando que toda esta configuração é para apertar o X loggout..Muito bom */
   	 }
       //Esta é a função do carregamento de pagina/*Ela sendo chamada na classe content do arquivo main.php*/  (e vindo a codificação da home) (E estamos na pasta classe arquivo Painel.php)
       public static function carregarPagina(){
         if (isset($_GET['url'])){
            $url = explode('/',$_GET['url']);
            if (file_exists('pages/'.$url[0].'.php')){
               include('pages/'.$url[0].'.php');
            }else{
               //Isto é  quando a pagina não existi..poderia ser uma pagina de erro.
               header('Location: '.INCLUDE_PATH_PAINEL);
            }
         }else{
            include('pages/home.php');
         }/*DE EXTRMA IMPORTANCIA UM  VALIDAÇÃO DE PAGINA*/
       }/*QUANDO NAO TIVER A PAGINA E VAI PARA HOME..PODERIA SER UMA PAGINA DE ERRO MAS NÃO FIZEMOS*/


       public static function listarUsuarioOnline(){
        /*este metodo self::limparUsuariosOnline(); tem a responsabilidade de limpar tirar os usuarios que estão inativos a mais de 1 minuto.*/
            self::limparUsuariosOnline();
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
            $sql->execute();
            return $sql->fetchAll();
       }

       public static function limparUsuariosOnline(){
            $date = date('Y-m-d H:i:s');
            $sql = MySql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE ");
       }


  /*Veja estou usando está função no editar usuario na atualização  formulario*/

  public static function alert($tipo, $mensagem){
    if($tipo == 'sucesso'){
      echo '<div class=" box-alert sucesso"><i class="fa fa-check"></i>'.$mensagem.'</div>';
    }else if($tipo == 'erro'){
      echo '<div class=" box-alert erro"><i class="fa fa-times"></i>'.$mensagem.'</div>';
       }else if($tipo == 'atencao'){
        echo '<div class="box-alert atencao"><i class="fa fa-warning"></i> '.$mensagem.'</div>';
       }
     }

    /*Validação de Imagem...dá*/
     public static function imagemValida($imagem){
      if ($imagem['type'] == 'image/jpeg' ||
           $imagem['type'] == 'image/jpg' ||
           $imagem['type'] == 'image/png') {

    /*Verificar o tamanho da imagem*/
   /*size me retorna valor em bytes..mas eu quero em kb desta forma eu converto['size']/1024...ai eu teho valor em kb */
    $tamanho = intval($imagem['size']/1024);/*objeto intval relaciona numeros inteiros exemplo Double = 12.5 ele transforma em numero inteiro 12*/
    if($tamanho < 900)/*Eu estou colocando o tamanho em 300 kb...somente para o servidor não ficar muito carregado...mas poderia ser maior */
      /*900 kb é o tamanho maximo da imagem*/
      return true;
    else
      return false;
        }else{
        return false;
      }
     }/*Fim da validação*/


     /*Upload de imagem*/

     public static function uploadFile($file){
      $formatoArquivo = explode('.',$file['name']);
      $imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];/*gera um id unico...uniqid().Quando temos duas imgems salvas exemplo woto e woto1*/
  if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/'.$imagemNome))
          return $imagemNome;
          else
            return false;
     }/*Fim do Upload de imagem*/

     public static function deleteFile($file){
      @unlink('uploads/'.$file);
     }

     /*Criar o método ou função insert*/
     public static function insert($arr){
      $certo = true;
      $nome_tabela = $arr['nome_tabela'];
      $query = "INSERT INTO `$nome_tabela` VALUES (null";
       foreach ($arr as $key => $value) {
         $nome = $key;
         $valor = $value;
         if($nome == 'acao' || $nome == 'nome_tabela')
          continue;
         if($value == ''){
            $certo = false;
            break;
         }
         $query.=",?";
         $parametros[] = $value;
       }
        
        $query.=")";
        if($certo == true){
        $sql = MySql::conectar()->prepare($query);
        $sql->execute($parametros);
        $lastId = MySql::conectar()->lastInsertId();
        $sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $lastId");
        $sql->execute(array($lastId));
         }
        return $certo;
        }
       
     

     /*implementação da da tabela listar-depooimentos.php*/
     public static function selectAll($tabela,$start = null, $end = null){
      if($start == null && $end == null)
  $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
  else
  $sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");
          $sql->execute(); 
   
       return $sql->fetchAll();/*Vem varios dados do bd*/
     }
     
     /*Função de deletar*/
     public static function deletar($tabela,$id=false){
         if ($id == false){
        $sql = Mysql::conectar()->prepare("DELETE FROM `$tabela`");
     }else{
        $sql = MySql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
     }
     $sql->execute();

    }
    /*redirecionamento*/
    public static function redirect($url){
      echo '<script>location.href="'.$url.'"</script>';
      die();
    }
    /*editar depoimento select*/
    /*Este método select é um metodo especifico para seleciona apenas um regisro fetch*/
    
   /* public static function select($table,$query,$arr){
       $sql = Mysql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
       $sql->execute($arr);
       return $sql->fetch(); /*fetch passa apenas o primeiro resultado no caso id*/
   // }

       /*TESTE NOVO SELECT*/
       public static function select($table,$query = '',$arr = ''){
      if($query != false){
        $sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
        $sql->execute($arr);
      }else{
        $sql = MySql::conectar()->prepare("SELECT * FROM `$table`");
        $sql->execute();
      }
      return $sql->fetch();
    }


       /*FIM NOVO SELECT*/

    public static function update($arr,$single = false){ /*single quer dizer individual ou seja não vai precisar do id...Lembrando que estamos colocando o single no final do projeto em editar-site*/
      $certo = true;
      $first = false;
      $nome_tabela = $arr['nome_tabela'];
      $query = "UPDATE `$nome_tabela` SET ";
       foreach ($arr as $key => $value) {
         $nome = $key;
         $valor = $value;
         if($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
          continue;
         if($value == ''){
            $certo = false;
            break;
         }
         if($first == false){
            $first = true;
            $query.="$nome=?";
         }else{
            $query.=",$nome=?";
         }
         
         $parametros[] = $value;
       }
        
        
        if($certo == true){
          if($single == false){
        $parametros[] = $arr['id']; 
        $sql = MySql::conectar()->prepare($query.' WHERE id=?');
        $sql->execute($parametros);
        }else{
          $sql = MySql::conectar()->prepare($query);
          $sql->execute($parametros);
        }
      }
       return $certo;
     }
     /*Inciando função de ordenamento*/
     public function orderItem($tabela, $orderType,$idItem){

      if($orderType == 'up'){
        $infoItemAtual = Painel::select($tabela, 'id=?',array($idItem));
        $order_id = $infoItemAtual['order_id'];
        $itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $order_id ORDER BY order_id DESC LIMIT 1");/*item Before - itemAnterior*/
        $itemBefore->execute();
        if($itemBefore->rowCount() == 0)
          return;
        $itemBefore = $itemBefore->fetch(); /*fetch para pegar apenas o 1º id*/
        Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
        Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));

      }else if($orderType == 'down'){
        $infoItemAtual = Painel::select($tabela, 'id=?',array($idItem));
        $order_id = $infoItemAtual['order_id'];
        $itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $order_id ORDER BY order_id ASC LIMIT 1");
        $itemBefore->execute();
        if($itemBefore->rowCount() == 0)
          return;
        $itemBefore = $itemBefore->fetch();
        Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
        Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
      }
     } 
   }

?>