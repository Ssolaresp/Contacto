<?php
// ✅ Redirección automática (descomenta si quieres que redireccione solo):
// header('Location: /app/vista/listar.php');
// exit;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Redirección a Listar</title>
</head>
<body>

    <h2>Ir a la lista de registros</h2>

    <!-- ✅ Enlace HTML -->
    <p><a href="/contacto/app/vista/contacto/listar.php">👉 Ir al Listado (Enlace)</a></p>

    <!-- ✅ Botón con JavaScript -->
    <button onclick="window.location.href='/contacto/app/vista/contacto/listar.php'">🔄 Ir a Listar (Botón)</button>

</body>
</html>
