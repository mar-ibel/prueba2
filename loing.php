<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Autenticación exitosa: iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<form method="post" action="">
  <input type="text" name="username" placeholder="Usuario" required><br>
  <input type="password" name="password" placeholder="Contraseña" required><br>
  <button type="submit">Iniciar sesión</button>
</form>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
