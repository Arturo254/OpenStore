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

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $app_name = $_POST['app_name'];
    $app_description = $_POST['app_description'];
    $app_link = $_POST['app_link'];
    
    // Subir el icono de la aplicación
    $icon_dir = 'icons/';
    $app_icon = $icon_dir . basename($_FILES['app_icon']['name']);
    
    // Validar la subida del icono
    if (move_uploaded_file($_FILES['app_icon']['tmp_name'], $app_icon)) {
        // Insertar los datos en la base de datos
        $stmt = $conn->prepare("INSERT INTO apps (user_id, app_name, app_description, app_link, app_icon) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $app_name, $app_description, $app_link, $app_icon);
        
        if ($stmt->execute()) {
            $message = "Aplicación subida con éxito.";
        } else {
            $message = "Hubo un error al subir la aplicación.";
        }
        
        $stmt->close();
    } else {
        $message = "Hubo un error al subir el icono de la aplicación.";
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Aplicación</title>
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
            <img src="<?php echo $_SESSION['avatar']; ?>" alt="Avatar" class="w-10 h-10 rounded-full mr-4 border-2 border-white/20 shadow-md object-cover">
            <span class="text-lg font-medium"><?php echo $_SESSION['username']; ?></span>
        </div>
        <div>
        <a href="index.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all mr-2">Casa</a>
            <a href="panel.php" class="text-white/80 hover:text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all mr-2">Panel</a>
            <a href="logout.php" class="text-red-400 hover:text-red-300 px-3 py-1.5 rounded-full hover:bg-red-500/10 transition-all">Cerrar sesión</a>
        </div>
    </div>
</header>
<br>
<br>
<br>

    <!-- Formulario para subir la aplicación -->
    <main class="container mx-auto p-6">
        <h2 class="text-3xl text-center mb-6">Subir Nueva Aplicación</h2>
        
        <?php if (isset($message)): ?>
            <div class="bg-green-600 text-white text-center p-4 rounded-lg mb-6">
                <strong><?php echo $message; ?></strong>
            </div>
        <?php endif; ?>

        <form action="upload_app.php" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="app_name" class="block text-sm font-medium text-white">Nombre de la Aplicación</label>
                <input type="text" id="app_name" name="app_name" class="w-full p-2 mt-2 bg-gray-700 text-white rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="app_description" class="block text-sm font-medium text-white">Descripción de la Aplicación</label>
                <textarea id="app_description" name="app_description" class="w-full p-2 mt-2 bg-gray-700 text-white rounded-lg" required></textarea>
            </div>

            <div class="mb-4">
                <label for="app_link" class="block text-sm font-medium text-white">Enlace de Descarga</label>
                <input type="url" id="app_link" name="app_link" class="w-full p-2 mt-2 bg-gray-700 text-white rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="app_icon" class="block text-sm font-medium text-white">Icono de la Aplicación (archivo JPG o PNG)</label>
                <input type="file" id="app_icon" name="app_icon" accept="image/*" class="w-full p-2 mt-2 bg-gray-700 text-white rounded-lg" required>
            </div>
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
  <span class="font-medium">No tienes donde subir tu apk?</span> subelo a : <a href="https://catbox.moe"><i>Catbox.moe</i></a>
</div>

            <br>

            <div class="mb-4 text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Subir Aplicación</button>
            </div>
        </form>
    </main>

</body>
</html>
