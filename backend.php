<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'app_store');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para obtener aplicaciones
function getApps($search_term = '') {
    global $conn;
    
    // Buscar aplicaciones según el término de búsqueda
    if ($search_term) {
        $search_query = "SELECT * FROM apps WHERE app_name LIKE '%$search_term%'";
    } else {
        $search_query = "SELECT * FROM apps";
    }

    $apps_result = $conn->query($search_query);
    
    $apps = [];
    if ($apps_result->num_rows > 0) {
        while ($app = $apps_result->fetch_assoc()) {
            $apps[] = $app;
        }
    }
    
    return $apps;
}

// Función para obtener información del usuario
function getUserInfo() {
    global $conn;
    
    // Verificar si el usuario está logueado
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $result = $conn->query("SELECT * FROM users WHERE id = '$user_id'");

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return [
                'avatar' => $user['avatar'],
                'username' => $user['username']
            ];
        }
    }
    
    // Valores predeterminados si no está logueado
    return [
        'avatar' => 'avatar/default_avatar.png',
        'username' => 'Invitado'
    ];
}

// Obtener parámetro de búsqueda
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Obtener apps y usuario
$apps = getApps($search_term);
$user_info = getUserInfo();

$conn->close();
?>