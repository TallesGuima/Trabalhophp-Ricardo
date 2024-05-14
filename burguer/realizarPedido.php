<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Faça seu pedido</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      color: #333;
    }
    form {
      margin-top: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      color: #666;
    }
    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 3px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<?php if(array_key_exists('nome', $_SESSION)): ?>
<body>
  <div class="container">
    <h1>Faça seu pedido</h1>
    <form action="processar-pedido.php" method="POST">
      <h2>Opções de Ingredientes:</h2>
      <label for="ingrediente1">Escolha um adicional:</label>
      <select id="ingrediente1" name="ingrediente1">
        <option value="presunto">Presunto</option>
        <option value="mussarela">Mussarela</option>
        <option value="ketchup">Ketchup</option>
        <option value="maionese">Maionese</option>
        <option value="maionese_casa">Maionese da Casa</option>
      </select>

      <h2>Opções de Pedido:</h2>
      <label for="pedido">Escolha o pedido:</label>
      <select id="pedido" name="pedido">
        <option value="Bizz">Bizz Burguer</option>
        <option value="Crackle">Crackle Burguer</option>
        <option value="Rocket">Rocket Burguer</option>
        <option value="Bull">Bull Burguer</option>
        <option value="Smokin">Smokin Burguer</option>
      </select>

      <label for="quantidade">Quantidade:</label>
      <input type="number" id="quantidade" name="quantidade" min="1" required>

      <input type="submit" value="Enviar Pedido">
    </form>
  </div>
</body>
<?php else: ?>

<body>
  <div class="container">
    <h1>Faça <a href="login.html">Login</a> ou se <a href="registro.html">Registre</a> para realizar pedidos nesse site</h1>
    <p><a href="index.php">Voltar a página inicial</a></p>
</body>

<?php endif ?>
</html>