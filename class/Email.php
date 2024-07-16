<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre,$email,$token){
        $this-> email = $email;
        $this-> nombre = $nombre;
        $this-> token = $token;
    }

    public function enviarConfirmacion(){
        //?creamos el objeto de email
        $phpmailer = new PHPMailer();//creamos el objeto de email
        $phpmailer->isSMTP();//configurar smpt protocolo de envio de email
        // $phpmailer->Host = 'sandbox.smtp.mailtrap.io';//host
        $phpmailer->Host = $_ENV['EMAIL_HOST'];

        $phpmailer->SMTPAuth = true;//nos vamos a autenticar
        // $phpmailer->Port = 2525;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        // $phpmailer->Username = 'f0e46a405c9237';
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        // $phpmailer->Password = 'de96ba15705680';
        $phpmailer->Password = $_ENV['EMAIL_PASS'];
        $phpmailer->SMTPSecure ='tls';

        //?configurar contenido de email
        $phpmailer->setFrom('cuentas@appsalon.com');//quien lo envia
        $phpmailer->addAddress('cuentas@appsalon.com','Appsalon.com');// a quien va a llegar
        $phpmailer->Subject = 'confirma tu cuenta';//este es el mensaje que nos avisara de una nuevo email en mailtrap

        //?habilitar HTML
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

           //?Definir el contenido
           $contenido = '<html>';
           $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en App Salon
           ,solo debes confirmarla presionando el siguente enlace</p>";
        //    $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token . "'>Confirmar Cuenta</a></p>";
           $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=". $this->token . "'>Confirmar Cuenta</a></p>";
           $contenido .= "<p>Si tu no solitaste esta cuenta puedes ignorar el mensaje</>";
           $contenido .= "</html>";

           $phpmailer->Body = $contenido;

            //?enviar el mail
            //*send se encarga de enviar el mail y retorna true o false
          $phpmailer->send();
    }

    public function enviarInstrucciones(){
         //?creamos el objeto de email
         $phpmailer = new PHPMailer();//creamos el objeto de email
         $phpmailer->isSMTP();//configurar smpt protocolo de envio de email
        //  $phpmailer->Host = 'sandbox.smtp.mailtrap.io';//host
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
         $phpmailer->SMTPAuth = true;//nos vamos a autenticar
        //  $phpmailer->Port = 2525;
         $phpmailer->Port = $_ENV['EMAIL_PORT'];
        //  $phpmailer->Username = 'f0e46a405c9237';
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        //  $phpmailer->Password = 'de96ba15705680';
        $phpmailer->Password = $_ENV['EMAIL_PASS'];
         $phpmailer->SMTPSecure ='tls';
 
         //?configurar contenido de email
         $phpmailer->setFrom('cuentas@appsalon.com');//quien lo envia
         $phpmailer->addAddress('cuentas@appsalon.com','Appsalon.com');// a quien va a llegar
         $phpmailer->Subject = 'Restablece tu Password';//este es el mensaje que nos avisara de una nuevo email en mailtrap
 
         //?habilitar HTML
         $phpmailer->isHTML(true);
         $phpmailer->CharSet = 'UTF-8';
 
            //?Definir el contenido
            $contenido = '<html>';
            $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu password,
            sigue el siguiente enlace para hacerlo</p>";
            // $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=". $this->token . "'>Restablecer Password</a></p>";
            $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=". $this->token . "'>Restablecer Password</a></p>";
            $contenido .= "<p>Si tu no solitaste esta cuenta puedes ignorar el mensaje</>";
            $contenido .= "</html>";
 
            $phpmailer->Body = $contenido;
 
             //?enviar el mail
             //*send se encarga de enviar el mail y retorna true o false
           $phpmailer->send();
    }

}