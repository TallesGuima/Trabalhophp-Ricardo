<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Cefet";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $adicional = $_POST["ingrediente1"];
        $pedido = $_POST["pedido"];
        $quantidade = $_POST["quantidade"];
        
        $sql = "INSERT INTO Pedidos (ID_Usuario, hamburguer, adicional, quantidade) VALUES (:ID_user, :pedido, :adicional, :quantidade)";
        $stmt = $conn->prepare($sql);
  
        $id = $_SESSION['user_ID']; // Certifique-se de que a variável de sessão está definida corretamente.

        $stmt->bindValue(":ID_user", $id);
        $stmt->bindValue(":pedido", $pedido);
        $stmt->bindValue(":adicional", $adicional);
        $stmt->bindValue(":quantidade", $quantidade);

        if($stmt->execute()) {
            echo "Pedido efetuado!";
        } else {
            echo "Aconteceu algo errado, tente novamente!";
            header("Refresh: 5; URL=index.php");
        }
    }
} catch(PDOException $e) {
    echo "Falha no pedido. Tente novamente mais tarde." . $e->getMessage();
}
header("Refresh: 0.5; URL=index.php");
$conn = null;

