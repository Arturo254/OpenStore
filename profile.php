<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'app_store');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario está logueado
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT * FROM users WHERE id = '$user_id'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $avatar = $user['avatar']; // Obtener el avatar del usuario
        $username = $user['username']; // Obtener el nombre de usuario
        $email = $user['email']; // Obtener el correo del usuario
    }
} else {
    header('Location: login.php'); // Redirigir al login si no está logueado
    exit();
}

// Procesar la actualización del perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $new_password_confirm = $_POST['password_confirm'];

    // Verificar si se ha subido un nuevo avatar
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        // Eliminar el avatar anterior si existe
        if ($avatar != 'avatar/default_avatar.png' && file_exists($avatar)) {
            unlink($avatar); // Eliminar archivo anterior
        }

        // Subir el nuevo avatar
        $avatar_dir = 'avatar/';
        $avatar_name = $_FILES['avatar']['name'];
        $avatar_path = $avatar_dir . basename($avatar_name);

        // Mover el archivo subido al directorio
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
            $avatar = $avatar_path; // Actualizar la ruta del avatar
        } else {
            $error = "Error al subir el avatar.";
        }
    }

    // Actualizar el correo y nombre de usuario en la base de datos
    $update_query = "UPDATE users SET username = '$new_username', email = '$new_email', avatar = '$avatar' WHERE id = '$user_id'";

    if ($new_password != '' && $new_password == $new_password_confirm) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET username = '$new_username', email = '$new_email', password = '$hashed_password', avatar = '$avatar' WHERE id = '$user_id'";
    }

    if ($conn->query($update_query)) {
        $success = "Perfil actualizado correctamente.";
        // Actualizar el nombre de usuario, correo y avatar en la sesión
        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $new_email;
    } else {
        $error = "Error al actualizar el perfil: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.1/src/css/pagedone.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">

<header class="bg-gray-800 text-white p-3 fixed top-5 left-5 right-5 z-50 rounded-3xl shadow-xl backdrop-blur-lg bg-opacity-80">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <img src="<?php echo $avatar; ?>" alt="Avatar" class="w-10 h-10 rounded-full mr-4 border-2 border-white/20 shadow-md object-cover">
            <span class="text-lg font-medium"><?php echo $username; ?></span>
        </div>
        <div>
        <a href="index.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all mr-2">Casa</a>
            <a href="logout.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all">Cerrar sesión</a>
        </div>
    </div>
</header>

<main class="container mx-auto p-6 mt-24">
    <h1 class="text-2xl font-bold text-center mb-6">Editar Perfil</h1>

    <?php if (isset($success)): ?>
        <div class="bg-green-500 text-white text-center p-4 rounded-lg mb-4">
            <?php echo $success; ?>
        </div>
    <?php elseif (isset($error)): ?>
        <div class="bg-red-500 text-white text-center p-4 rounded-lg mb-4">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- Nombre de usuario -->
        <div>
            <label for="username" class="block text-lg font-medium">Nombre de usuario</label>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="w-full p-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Correo -->
        <div>
            <label for="email" class="block text-lg font-medium">Correo</label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>" class="w-full p-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password" class="block text-lg font-medium">Contraseña</label>
            <input type="password" name="password" id="password" class="w-full p-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="password_confirm" class="block text-lg font-medium">Confirmar Contraseña</label>
            <input type="password" name="password_confirm" id="password_confirm" class="w-full p-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Avatar -->
        <div>
            <label for="avatar" class="block text-lg font-medium">Avatar</label>
            <input type="file" name="avatar" id="avatar" class="w-full p-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-sm text-gray-400 mt-2">Elige un archivo para cambiar tu avatar.</p>
        </div>

        <!-- Botón de actualización -->
        <div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Actualizar Perfil</button>
        </div>
    </form>
</main>

</body>
</html>
