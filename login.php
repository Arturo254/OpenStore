<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'app_store');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar al usuario en la base de datos
    $query = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Iniciar sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['avatar'] = $user['avatar'];

            echo "<script>alert('Inicio de sesión exitoso. Bienvenido!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    } else {
        echo "<script>alert('No se encontró un usuario con ese correo electrónico.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.1/src/css/pagedone.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-6 max-w-md">
        <h2 class="text-3xl text-center mb-6">Iniciar Sesión</h2>

        <form method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico</label>
                <input type="email" id="email" name="email" class="w-full p-2 mt-1 rounded-md bg-gray-700 text-white" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-2 mt-1 rounded-md bg-gray-700 text-white" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 p-3 rounded-md hover:bg-blue-700">Iniciar Sesión</button>
        </form>

        <p class="mt-4 text-center">
            ¿No tienes cuenta? <a href="register.php" class="text-blue-400 hover:underline">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>
