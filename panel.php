<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'app_store');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir si no está logueado
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener los datos del usuario
$result = $conn->query("SELECT * FROM users WHERE id = '$user_id'");

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username']; // Obtener el nombre de usuario
    $avatar = $user['avatar']; // Obtener el avatar del usuario
}

// Obtener las aplicaciones subidas por el usuario
$apps_result = $conn->query("SELECT * FROM apps WHERE user_id = '$user_id'");

// Eliminar aplicación
if (isset($_POST['delete_app_id'])) {
    $app_id = $_POST['delete_app_id'];
    
    // Obtener el nombre del archivo de la aplicación para eliminarlo
    $app_result = $conn->query("SELECT * FROM apps WHERE id = '$app_id' AND user_id = '$user_id'");
    
    if ($app_result->num_rows > 0) {
        $app = $app_result->fetch_assoc();
        $app_file = $app['app_link'];  // Aquí deberías almacenar el archivo físico si es necesario eliminarlo

        // Eliminar el archivo si es necesario
        // Puedes usar unlink($app_file) si es un archivo en el servidor

        // Eliminar la aplicación de la base de datos
        $conn->query("DELETE FROM apps WHERE id = '$app_id'");

        // Redirigir para evitar el reenvío del formulario
        header("Location: panel.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.1/src/css/pagedone.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">

    <!-- Header -->
    <header class="bg-gray-800 text-white p-3 fixed top-5 left-5 right-5 z-50 rounded-3xl shadow-xl backdrop-blur-lg bg-opacity-80">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <img src="<?php echo $avatar; ?>" alt="Avatar" class="w-10 h-10 rounded-full mr-4 border-2 border-white/20 shadow-md object-cover">
            <span class="text-lg font-medium"><?php echo $username; ?></span>
        </div>
        <div>
        <a href="index.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all mr-2">Casa</a>
        <a href="profile.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all mr-2">
                Modificar Perfil
            </a>
            <a href="logout.php" class="text-red-400 hover:text-red-300 px-3 py-1.5 rounded-full hover:bg-red-500/10 transition-all">
                Cerrar sesión
            </a>
        </div>
    </div>
</header>
<br>
<br>
<br>
    <!-- Panel de control -->
    <main class="container mx-auto p-6">
        <h2 class="text-3xl text-center mb-6">Bienvenido a tu Panel de Control</h2>
        
        <!-- Mostrar las aplicaciones subidas -->
        <h3 class="text-2xl mb-4">Tus Aplicaciones:</h3>

        <?php if ($apps_result->num_rows > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php while ($app = $apps_result->fetch_assoc()): ?>
                    <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                        <img src="<?php echo $app['app_icon']; ?>" alt="App Icon" class="w-16 h-16 mb-4 mx-auto">
                        <h3 class="text-xl font-semibold text-center"><?php echo $app['app_name']; ?></h3>
                        <p class="text-sm text-gray-300 mt-2"><?php echo $app['app_description']; ?></p>
                        <a href="<?php echo $app['app_link']; ?>" target="_blank" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-center w-full">Descargar</a>

                        <!-- Formulario para eliminar la aplicación -->
                        <form method="POST" class="mt-4 text-center">
                            <input type="hidden" name="delete_app_id" value="<?php echo $app['id']; ?>">
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Eliminar</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-red-500 text-white text-center p-4 rounded-lg">
                <strong>No has subido ninguna aplicación aún.</strong>
            </div>
        <?php endif; ?>

        <!-- Botón para subir nueva aplicación -->
        <div class="mt-6 text-center">
            <a href="upload_app.php" class="bg-green-600 text-white px-6 py-2 rounded-lg">Subir Nueva Aplicación</a>
        </div>
    </main>
</body>
</html>
