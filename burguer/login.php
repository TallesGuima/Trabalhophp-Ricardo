<?php
session_start();
?>
<!DOCTYPE HTML>  
<html>

<?php

include "comportamentos.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Cefet";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $data_ultimo_login = date("y-m-d");
}

//Valida e já passa os valores 'codigo' e 'nome' correspondentes a aquele email e senha ao $_SESSION 
function validaLogin($email, $senha, PDO $pdo) {
    //Seleciona o "codigo" especifico de um email e senha
  $sql = "SELECT codigo, nome FROM usuario WHERE email = :email AND senha = :senha;";
  $stmt = $pdo->prepare($sql);


  //Vincular parametros aos valores
  $stmt->bindValue(":email", $email);
  $stmt->bindValue(":senha", $senha);

  //Executa o comando sql preparado 
  $stmt->execute();

  //pego o id e nome. VERIFIQUE O SELECT. Selecionei codigo e agora eu passei o valor de codigo
  $usuario = $stmt->fetch();

  if ($usuario){
    $_SESSION = $usuario;
    return true;
  }

return false;
}

function updateUltimoDiaOn_LOGIN(PDO $pdo, $user_ID){
  $dataAtual = date("y-m-d");
  $sql = "UPDATE usuario SET ultimo_login = :data_ultimo_login WHERE codigo = :id_de_usuario";
  $stmt = $pdo->prepare($sql);

  $stmt->bindValue(":id_de_usuario", $user_ID);
  $stmt->bindValue(":data_ultimo_login", $dataAtual);

  //Executa o comando sql preparado 
  if(!$stmt->execute()){
    return false;
  }
  return true;
}


try {
  //Executo o validaLogin verificando se deu true ou false
  if(!validaLogin($email, $senha, $conn)){
      echo "O email e senha incorretos";
      header("Refresh: 3; URL=sessionEnd.php");
  } else {
    //Se tem um email com aquela senha entra aqui e atualiza o ultimoDiaOn e vai pro index.php
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      getCodigo($conn, $email, $senha);
      updateUltimoDiaOn_LOGIN($conn, $_SESSION['codigo']);
     

      header("Refresh: 0.5; URL=boasVindas.php");
      
  } 
} catch(PDOException $e) {
  echo $conn . "<br>" . $e->getMessage();
} finally { 
  $conn = null;
}
?>

</html>
