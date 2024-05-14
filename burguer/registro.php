<?php session_start();?>
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
    $nome = $_POST["name"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $data_cadastro = date("y-m-d");
}

function verifica_email($email, PDO $pdo){
  // Verifica se o email é válido
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return false;
  }

    //Prepara a consulta sql
    $sql = "SELECT COUNT(*) FROM usuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);

    //vincula o parametro :email ao valor de $email
    $stmt->bindValue(":email", $email);

    //executa a consulta
    $stmt->execute();

    //Obtem o numero de linhas iguais ao :email
    $numero_linhas = $stmt->fetchColumn();

    // se for maior que 0 tem mais de um email  
    return $numero_linhas>0;

}

if(verifica_email($email, $conn)){
    echo "O email registrado: $email ja exite no sistema";
    header("Refresh: 5; URL=sessionEnd.php");
  } else{
    try {
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
      inserirUsuario($conn, $nome, $email, $senha, $data_cadastro);
      
      getCodigo($conn, $email, $senha);

      $_SESSION['nome'] = $nome;

      echo "Usuário cadastrado com sucesso!" 
      . $_SESSION['user_ID'] 
      . " " . $_Session['nome'] 
      . " $email $senha";
    
    } catch(PDOException $e) {
      echo ''. $e->getMessage();
      echo "<br> Falha no cadastro. Tente novamente mais tarde.";
    }
    
  $conn = null;
  if(array_key_exists('user_ID', $_SESSION))
  header("Refresh: 2; URL=boasVindas.php"); // Redireciona após 2 segundos
  else 
  header("Refresh: 2; URL=index.php");
}

?>
</html>
