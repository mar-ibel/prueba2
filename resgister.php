<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        try {
            $stmt->execute([$username, $hashed_password]);
            echo "Usuario registrado con éxito.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "El nombre de usuario ya existe.";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Por favor, llena todos los campos.";
    }
}
?>

<form method="post" action="">
  <input type="text" name="username" placeholder="Usuario" required><br>
  <input type="password" name="password" placeholder="Contraseña" required><br>
  <button type="submit">Registrar</button>
</form>
