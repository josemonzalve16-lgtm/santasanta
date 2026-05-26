<?php
$carpeta = __DIR__ . '/requests/';
$limite_segundos = 480; // Archivos más antiguos de 8 minutos se eliminan

if (!is_dir($carpeta)) {
    exit("La carpeta 'requests' no existe.");
}

$archivos = glob($carpeta . '*.json');
$ahora = time();

foreach ($archivos as $archivo) {
    $id_sesion = basename($archivo, '.json');

    // Revisa si la sesión aún existe
    session_write_close();
    session_id($id_sesion);
    session_start();

    $activo = isset($_SESSION['load_entry_time']) && ($ahora - $_SESSION['load_entry_time']) < $limite_segundos;

    session_write_close(); // Cierra la sesión después de leer

    // Si no hay sesión activa y el archivo está viejo, lo eliminamos
    if (!$activo && ($ahora - filemtime($archivo)) > $limite_segundos) {
        unlink($archivo);
    }
}
?>
