<!DOCTYPE HTML>  
<html>
  <?php
  function inserirUsuario($pdo, $nome, $email, $senha, $data_cadastro) {
    try {
        // Preparar a consulta SQL
        $sql = "INSERT INTO usuario(nome, email, senha, data_cadastro, ultimo_login) 
                VALUES (:nome, :email, :senha, :data_cadastro, '');";
        $stmt = $pdo->prepare($sql);

        // Vincular parâmetros aos valores
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);
        $stmt->bindValue(":data_cadastro", $data_cadastro);

        // Executa o comando sql preparado, se der erro vai return false
        if (!$stmt->execute()) {
          return false;
        }

        // Retornar true em caso de sucesso
        return true;

    } catch (PDOException $e) {
        echo("Erro ao inserir usuário: " . $e->getMessage());

        // Retornar false em caso de erro
        return false;
    }
}

// Retorna true ou false, mas define a superglobal $_SESSION 
  function getCodigo(PDO $pdo, $email, $senha){
    try{
      //Seleciona o "codigo" especifico de um email e senha
    $sql = "SELECT codigo FROM usuario WHERE email = :email AND senha = :senha;";
    $stmt = $pdo->prepare($sql);

    //Vincular parametros aos valores
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":senha", $senha);

    //Executa o comando sql preparado 
    if(!$stmt->execute()){
      return false;
    }

    //pego o id. VERIFIQUE O SELECT. Selecionei codigo e agora eu passei o valor de codigo
    $userID = $stmt->fetch();

    //retornei, atribuindo o valor a superglobal
    $_SESSION['user_ID'] = $userID['codigo'];
    return true;
    }   catch(PDOException $e) {
    echo("Erro no cadastro: " . $e->getMessage());
  }
  return false;
  }
?>
</html>