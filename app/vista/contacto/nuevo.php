<?php
require_once __DIR__ . '/../../controlador/ContactoControlador.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new ContactoControlador();
    $controlador->guardar($_POST);
    header('Location: listar.php');
    exit;
}
?>

<h2>Nuevo Contacto</h2>
<form method="post">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Asunto:</label><br>
    <input type="text" name="asunto" required><br><br>

    <label>Correo:</label><br>
    <input type="email" name="correo" required><br><br>

    <label>Mensaje:</label><br>
    <textarea name="mensaje" rows="5" required></textarea><br><br>

    <button type="submit">Guardar</button>
</form>
