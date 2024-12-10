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
    }
} else {
    $avatar = 'avatar/default_avatar.png'; // Avatar predeterminado si no está logueado
    $username = 'Invitado'; // Nombre de usuario por defecto
}

// Comprobar si se ha enviado la búsqueda
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Buscar aplicaciones según el término de búsqueda
if ($search_term) {
    $search_query = "SELECT * FROM apps WHERE app_name LIKE '%$search_term%'";
} else {
    $search_query = "SELECT * FROM apps";
}

$apps_result = $conn->query($search_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Store</title>
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
            <!-- Avatar -->
            <img src="<?php echo $avatar; ?>" alt="Avatar" class="w-10 h-10 rounded-full mr-4 border-2 border-white/20 shadow-md object-cover">
            <span class="text-lg font-medium"><?php echo $username; ?></span>
        </div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="panel.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all">Panel</a>
            <?php else: ?>
                <a href="login.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all mr-2">Iniciar</a>
                <a href="register.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all">Registro</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<br>
<br>
<br>

<!-- Barra de búsqueda -->
<div class="flex justify-center mt-20">
    <form method="GET" class="w-full max-w-4xl flex items-center">
        <input type="text" name="search" placeholder="Buscar aplicaciones..." class="w-full px-4 py-2 rounded-full bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($search_term); ?>">
        <button type="submit" class="ml-4 px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 focus:outline-none">Buscar</button>
    </form>
</div>

<main class="container mx-auto p-6 mt-10">
    <?php if ($apps_result->num_rows > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php while ($app = $apps_result->fetch_assoc()): ?>
                <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl group relative">
                    <div class="p-6">
                        <div class="flex flex-col items-center">
                            <div class="mb-4 w-24 h-24 rounded-2xl bg-gray-700 flex items-center justify-center p-3 shadow-md group-hover:shadow-lg transition-all">
                                <img src="<?php echo $app['app_icon']; ?>" alt="App Icon" class="w-full h-full object-contain rounded-xl">
                            </div>
                            <h3 class="text-xl font-bold text-center mt-4 mb-2"><?php echo $app['app_name']; ?></h3>
                            <p class="text-sm text-gray-400 text-center line-clamp-2 mb-4"><?php echo $app['app_description']; ?></p>
                            <a href="<?php echo $app['app_link']; ?>" target="_blank" 
                               class="w-full text-center px-4 py-2 rounded-full bg-transparent border border-white/20 text-white/80 
                                      hover:bg-white/10 hover:border-white/40 transition-all duration-300 
                                      flex items-center justify-center space-x-2 group">
                                <span>Descargar</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="bg-red-500 text-white text-center p-4 rounded-lg">
            <strong>¡No hay aplicaciones disponibles!</strong>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
