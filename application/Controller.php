<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

abstract class Controller
{
    protected $_view;
    
    public function __construct() {
        $this->_view= new view(new Request());
    }
    
    abstract public function index();
    
    protected function loadModel($class)
    {
        $dao= $class . 'DAO';
        $dto= $class . 'DTO';
        $rutaDAO= ROOT . 'models' . DS . 'dao'. DS .$dao . '.php';
        $rutaDTO= ROOT . 'models' . DS . 'dto'. DS .$dto . '.php';
        $rutaDetalleDTO= ROOT . 'models' . DS . 'dto'. DS . 'detalle' .$dto . '.php';
        
        if(is_readable($rutaDAO))
        {
            if(is_readable($rutaDTO))
            {
                require_once $rutaDAO;
                require_once $rutaDTO;
                
                if(is_readable($rutaDetalleDTO))
                {
                    require_once $rutaDetalleDTO;
                }
                
                $dao= new $dao;
                return $dao; //retorna la instancia del modelo
            }
            else
            {
                throw new Exception('Error al cargar el DTO: ' . $rutaDTO);
            }
        }
        else
        {
            throw new Exception('Error al cargar el DAO: ' . $rutaDAO);
        }
    }
    
    protected function loadDTO($class)
    {
        $dto= $class . 'DTO';
        $rutaDTO= ROOT . 'models' . DS . 'dto'. DS .$dto . '.php';
        
        
        if(is_readable($rutaDTO))
        {
            require_once $rutaDTO;

            $dto= new $dto;
            return $dto; //retorna la instancia del modelo
        }
        else
        {
            throw new Exception('Error al cargar el DTO: ' . $rutaDTO);
        }
    }
    
    /*protected function loadModel($modelo)
    {
        $modelo= $modelo . 'Model';
        $rutaModelo= ROOT . 'models' . DS . $modelo . '.php';
        
        if(is_readable($rutaModelo))
        {
            require_once $rutaModelo;
            $modelo= new $modelo;
            return $modelo; //retorna la instancia del modelo
        }
        else
        {
            throw new Exception('Error al leer el modelo: ' . $rutaModelo);
        }
    }*/
    
    protected function getServer($clave)
    {
        if(!empty($_SERVER[$clave]))
        {
            return $_SERVER[$clave];
        }
    }
    
    protected function getPOST()
    {
        return $_POST;
    }

    protected function getTexto($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            $_POST[$clave]= htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return trim($_POST[$clave]);
        }
    }
    
    protected function getInt($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            $_POST[$clave]= filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return trim($_POST[$clave]);
        }
        
        return 0;
    }
    
    
    protected function redireccionar($ruta = false)
    {
        if($ruta){
            header('location:' . BASE_URL . $ruta);
            exit;
        }
        else{
            header('location:' . BASE_URL);
            exit;
        }
    }
    
    
    protected function getSql($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = strip_tags($_POST[$clave]);
            
            if(!get_magic_quotes_gpc()){
                $_POST[$clave] = mysql_escape_string($_POST[$clave]);
            }
            
            return trim($_POST[$clave]);
        }
    }
    
    protected function getAlphaNum($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$clave]);
            return trim($_POST[$clave]);
        }
    }
    
    protected function getLibrary($libreria)
    {
        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';
        
        if(is_readable($rutaLibreria)){
            require_once $rutaLibreria;
        }
        else{
            throw new Exception('Error de libreria');
        }
    }
    
    protected function filtrarInt($int)
    {
        $int = (int) $int;
        
        if(is_int($int)){
            return $int;
        }
        else{
            return 0;
        }
    }
    
    protected function validateRequirements()
    {
        $requirements = array(
            'version' => '',
            'curl' => '',
            'dom' => ''
        );

        $version = str_replace('.', '', phpversion());

        if ($version < 533) {
            $requirements['version'] = 'Se requiere PHP version 5.3.3 o superior.';
        }

        if (!function_exists('curl_init')) {
            $requirements['curl'] = 'Se requiere CURL library.';
        }

        if (!class_exists('DOMDocument')) {
            $requirements['dom'] = 'Se requiere DOM XML extension is required.';
        }

        return $requirements;
    }
    
    protected function curlPOST($param, $url) {
        $header = array();
        $header[] = 'Content-Type: text/xml; encoding="UTF-8"';
        $header[] = 'Accept-Charset: ISO-8859-1,utf-8;';
        
        $ch = curl_init($url); 
        
        //especificamos el POST (tambien podemos hacer peticiones enviando datos por GET
        curl_setopt ($ch, CURLOPT_POST, 1);

        //le decimos qu� param�etros enviamos (pares nombre/valor, tambi�n acepta un array)
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $param);

        //le decimos que queremos recoger una respuesta (si no esperas respuesta, ponlo a false)
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }
    
    
    protected function mailReserva($file, $html) {
        // Preparar Correo electr�nico
        $email_asunto="Confirmaci�n de reserva online: ".$file;
        $email_destinatario = 'jestay@tsyacom.cl'; //$_SESSION['sess_email'];
        $email_destinatarioCC = 'j.estay1988@gmail.com'; //$_SESSION['sess_email_opera'];

        $mail = new PHPMailer();

        $mail->IsSMTP(); 
        $mail->Host = trim("190.196.23.232");
        $mail->Port = 25;
        $mail->From = 'panamericana@online.panamericanaturismo.cl';
        $mail->CharSet = CHARSET; //'UTF-8';

        $mail->FromName = "Panamericana Online ";
        $mail->Subject = $email_asunto;
        $mail->MsgHTML($html); 

        $mail->AddAddress($email_destinatario, "");
        $mail->AddCC($email_destinatarioCC);

        $mail->SMTPAuth = true;
        $mail->Username = trim("online@panamericanaturismo.cl");
        $mail->Password = trim("Fe90934");

        $mail->Send();
        sleep(2);
    }
}