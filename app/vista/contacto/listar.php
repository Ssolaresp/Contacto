<?php
require_once __DIR__ . '/../../controlador/ContactoControlador.php';
$controlador = new ContactoControlador();
$contactos = $controlador->listar();
?>

<h2>Contactos</h2>
<a href="nuevo.php">Nuevo contacto</a>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Asunto</th>
            <th>Correo</th>
            <th>Mensaje</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contactos as $c): ?>
            <tr>
                <td><?php echo $c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['nombre']); ?></td>
                <td><?php echo htmlspecialchars($c['asunto']); ?></td>
                <td><?php echo htmlspecialchars($c['correo']); ?></td>
                <td><?php echo htmlspecialchars($c['mensaje']); ?></td>
                <td><?php echo htmlspecialchars($c['estado_contacto']); ?></td>
                <td><?php echo $c['fecha_creacion']; ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $c['id']; ?>">Cambiar estado</a> |
               </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
