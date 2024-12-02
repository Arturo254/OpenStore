<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'app_store');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Definir la ruta para el avatar
    $avatar = 'avatar/default-avatar.jpg'; // Avatar por defecto
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        // Verificar si el directorio 'avatar' existe, si no, crear
        $avatar_dir = 'avatar/';
        if (!is_dir($avatar_dir)) {
            mkdir($avatar_dir, 0755, true); // Crear directorio si no existe
        }

        $avatar_tmp_name = $_FILES['avatar']['tmp_name'];
        $avatar_name = $_FILES['avatar']['name'];
        $avatar_extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
        
        // Verificar que la imagen sea una imagen válida
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($avatar_extension, $allowed_extensions)) {
            // Generar un nombre único para la imagen
            $avatar = $avatar_dir . uniqid('avatar_') . '.' . $avatar_extension;
            // Subir la imagen al servidor
            if (move_uploaded_file($avatar_tmp_name, $avatar)) {
                // Éxito al subir la imagen
            } else {
                echo "<script>alert('Error al subir la imagen.');</script>";
            }
        } else {
            echo "<script>alert('Formato de imagen no válido.');</script>";
        }
    }

    // Cifrar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe
    $check_user = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check_user->num_rows > 0) {
        echo "<script>alert('El usuario ya está registrado.');</script>";
    } else {
        // Insertar el nuevo usuario
        $query = "INSERT INTO users (username, email, password, avatar) VALUES ('$username', '$email', '$hashed_password', '$avatar')";
        if ($conn->query($query) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['avatar'] = $avatar;
            echo "<script>alert('Registro exitoso. Bienvenido!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error al registrar usuario.');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.1/src/css/pagedone.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-6 max-w-md">
        <h2 class="text-3xl text-center mb-6">Registro de Usuario</h2>

        <form method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-300">Nombre de usuario</label>
                <input type="text" id="username" name="username" class="w-full p-2 mt-1 rounded-md bg-gray-700 text-white" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico</label>
                <input type="email" id="email" name="email" class="w-full p-2 mt-1 rounded-md bg-gray-700 text-white" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-2 mt-1 rounded-md bg-gray-700 text-white" required>
            </div>

            <div class="mb-4">
                <label for="avatar" class="block text-sm font-medium text-gray-300">Avatar</label>
                <input type="file" id="avatar" name="avatar" class="w-full p-2 mt-1 rounded-md bg-gray-700 text-white">
            </div>

            <button type="submit" class="w-full bg-blue-600 p-3 rounded-md hover:bg-blue-700">Registrar</button>
        </form>

        <p class="mt-4 text-center">
            ¿Ya tienes cuenta? <a href="login.php" class="text-blue-400 hover:underline">Inicia sesión</a>
        </p>
    </div>
</body>
</html>
