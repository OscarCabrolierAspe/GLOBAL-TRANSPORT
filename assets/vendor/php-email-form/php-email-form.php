<?php
class PHP_Email_Form {
    public $ajax = false;
    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    public $messages = array();

    public function add_message($content, $title, $size = 0) {
        $this->messages[$title] = $content;
    }

    public function send() {
        // Obtenemos los datos limpios del formulario
        $nombre = isset($this->messages['From']) ? $this->messages['From'] : $this->from_name;
        $correo = isset($this->messages['Email']) ? $this->messages['Email'] : $this->from_email;
        $mensaje_usuario = isset($this->messages['Message']) ? $this->messages['Message'] : 'Sin mensaje';

        // Diseñamos un correo en formato HTML limpio y corporativo
        $email_subject = "Nueva Solicitud de Contacto/ Contacto Web: " . $this->subject;
        
        $email_content = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; color: #333; background-color: #f4f4f7; margin: 0; padding: 20px; }
                .container { max-width: 600px; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
                .header { background: #0d6efd; color: #ffffff; padding: 15px 20px; border-radius: 6px 6px 0 0; text-align: center; }
                .content { padding: 20px 0; }
                .field { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
                .label { font-weight: bold; color: #555; display: block; margin-bottom: 5px; }
                .value { color: #222; }
                .message-box { background: #f8f9fa; padding: 15px; border-left: 4px solid #0d6efd; border-radius: 4px; margin-top: 10px; }
                .footer { font-size: 12px; color: #888; text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Global Transport - Nuevo Contacto</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='label'>Nombre del Cliente:</span>
                        <span class='value'>" . htmlspecialchars($nombre) . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Correo Electrónico:</span>
                        <span class='value'><a href='mailto:" . htmlspecialchars($correo) . "'>" . htmlspecialchars($correo) . "</a></span>
                    </div>
                    <div class='field'>
                        <span class='label'>Asunto:</span>
                        <span class='value'>" . htmlspecialchars($this->subject) . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Mensaje:</span>
                        <div class='message-box'>" . nl2br(htmlspecialchars($mensaje_usuario)) . "</div>
                    </div>
                </div>
                <div class='footer'>
                    <p>Este mensaje fue enviado desde el formulario de contacto de la web de <a href='https://www.globaltransport.com'>Global Transport</a>.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        // Cabeceras obligatorias para correos en formato HTML y para configurar el remitente real
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $nombre . " <" . $correo . ">\r\n";
        $headers .= "Reply-To: " . $correo . "\r\n";

        // Envío mediante el servidor local o el hosting
        if (mail($this->to, $email_subject, $email_content, $headers)) {
            return "OK";
        } else {
            return "Error: No se pudo enviar el mensaje a través del servidor de correo.";
        }
    }
}
?>
