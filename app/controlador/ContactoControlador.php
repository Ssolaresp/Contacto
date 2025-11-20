<?php
require_once __DIR__ . '/../Modelo/Contacto.php';

// Importar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class ContactoControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new Contacto();
    }

    public function listar() {
        return $this->modelo->listar();
    }

    public function obtener($id) {
        return $this->modelo->obtener($id);
    }

    public function guardar($data) {
        if (empty($data['id'])) {
            $this->modelo->insertar($data);
            $this->enviarCorreoNuevoContacto($data);  // <--- Envía correo tras insertar
        } else {
            $this->modelo->actualizar($data);
        }
    }

    public function eliminar($id) {
        $this->modelo->eliminar($id);
    }

    public function obtenerEstadosContacto() {
        return $this->modelo->obtenerEstadosContacto();
    }

    private function enviarCorreoNuevoContacto($data) {
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP Gmail (ajusta si usas otro servidor)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '';        // Cambia por tu correo
            $mail->Password = '';      // Cambia por tu App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente y destinatario
            $mail->setFrom('tu_email@gmail.com', 'Tu Empresa o Nombre');
            $mail->addAddress($data['correo'], $data['nombre']);  // Correo de la persona que llenó el formulario

            // Asunto personalizado
            $subject = "Gracias por contactarnos, " . htmlspecialchars($data['nombre']);
            $mail->isHTML(true);
            $mail->Subject = $subject;

            // Variables sanitizadas
            $nombre = htmlspecialchars($data['nombre']);
            $asunto = htmlspecialchars($data['asunto']);
            $mensaje = nl2br(htmlspecialchars($data['mensaje']));

            // Cuerpo HTML mejorado y responsive
            $mail->Body = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Gracias por contactarnos</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f8;
        margin: 0; padding: 0;
        color: #333;
    }
    .container {
        max-width: 600px;
        margin: 30px auto;
        background-color: #ffffff;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 {
        color: #2c3e50;
    }
    p {
        font-size: 16px;
        line-height: 1.5em;
    }
    .footer {
        margin-top: 30px;
        font-size: 14px;
        color: #888;
        border-top: 1px solid #ddd;
        padding-top: 15px;
        text-align: center;
    }
    .btn {
        display: inline-block;
        margin-top: 20px;
        background-color: #27ae60;
        color: white !important;
        padding: 12px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }
    .message-box {
        background-color: #f9f9f9;
        padding: 15px;
        border-left: 4px solid #27ae60;
        margin-top: 20px;
        white-space: pre-wrap;
        font-family: monospace;
        font-size: 14px;
        color: #444;
    }
    @media only screen and (max-width: 620px) {
        .container {
            margin: 10px;
            padding: 15px;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Hola {$nombre},</h2>
        <p>Gracias por contactarnos respecto a <strong>"{$asunto}"</strong>.</p>
        <p>Hemos recibido tu mensaje y nos pondremos en contacto contigo lo antes posible.</p>

        <div class="message-box">
            <strong>Tu mensaje:</strong><br>
            {$mensaje}
        </div>

        <p>Mientras tanto, te invitamos a visitar nuestra página web para más información:</p>
        <a href="https://tuempresa.com" class="btn" target="_blank" rel="noopener noreferrer">Visitar sitio web</a>

        <div class="footer">
            <p>Saludos cordiales,<br>Equipo de <strong>Tu Empresa</strong></p>
            <p><small>Si no solicitaste este correo, por favor ignóralo.</small></p>
        </div>
    </div>
</body>
</html>
HTML;

            // Texto plano para clientes que no leen HTML
            $mail->AltBody = 
                "Hola {$nombre},\n\n".
                "Gracias por contactarnos respecto a \"{$asunto}\".\n".
                "Hemos recibido tu mensaje y nos pondremos en contacto contigo lo antes posible.\n\n".
                "Tu mensaje:\n{$data['mensaje']}\n\n".
                "Visita nuestra página web: https://tuempresa.com\n\n".
                "Saludos cordiales,\n".
                "Equipo de Tu Empresa\n\n".
                "Si no solicitaste este correo, por favor ignóralo.";

            $mail->send();

        } catch (Exception $e) {
            error_log("Error enviando correo: " . $mail->ErrorInfo);
        }
    }
}
