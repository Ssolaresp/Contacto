<?php
require_once __DIR__ . '/../../controlador/ContactoControlador.php';

$controlador = new ContactoControlador();
$estados = $controlador->obtenerEstadosContacto();

if (!isset($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$contacto = $controlador->obtener($_GET['id']);

if (!$contacto) {
    echo "Contacto no encontrado";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id' => $contacto['id'],
        'nombre' => $contacto['nombre'],
        'asunto' => $contacto['asunto'],
        'correo' => $contacto['correo'],
        'mensaje' => $contacto['mensaje'],
        'estado_contacto_id' => $_POST['estado_contacto_id']
    ];
    $controlador->guardar($datos);
    header('Location: listar.php');
    exit;
}
?>

<h2>Editar estado de contacto</h2>
<form method="post">
    <label>Nombre:</label><br>
    <input type="text" value="<?php echo htmlspecialchars($contacto['nombre']); ?>" readonly><br><br>

    <label>Asunto:</label><br>
    <input type="text" value="<?php echo htmlspecialchars($contacto['asunto']); ?>" readonly><br><br>

    <label>Correo:</label><br>
    <input type="email" value="<?php echo htmlspecialchars($contacto['correo']); ?>" readonly><br><br>

    <label>Mensaje:</label><br>
    <textarea rows="5" readonly><?php echo htmlspecialchars($contacto['mensaje']); ?></textarea><br><br>

    <label>Estado:</label><br>
    <select name="estado_contacto_id" required>
        <?php foreach ($estados as $estado): ?>
            <option value="<?php echo $estado['id']; ?>" <?php if ($estado['id'] == $contacto['estado_contacto_id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($estado['nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Actualizar estado</button>
</form>
