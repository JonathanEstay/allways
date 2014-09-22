<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class View
{
    private $_controlador;
    private $_js;
    
    public function __construct(Request $peticion) { //$peticion es un objeto de Request
        $this->_controlador= $peticion->getControlador();
        $this->_js=array();
    }
    
    
    public function setJs(array $js)
    {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                //$this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
                $this->_js[] = BASE_URL . 'public/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }
    }
    
    
    public function renderizaPrincipal($vista, $item=false)
    {
        //se incluye directamente el '/' ya que estas rutas siempre van a ser asi
        $_layoutParams= array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/', 
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/', 
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/', 
            'js' => $js
        );
        $rutaView= ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        
        if(is_readable($rutaView))
        {
            //include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            //include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'menu-left.php';
            include_once $rutaView;
            //include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        }
        else
        {
            throw new Exception('Error de vista: '.$rutaView);
        }
    }
    
    
    
    
    
    public function renderizaSistema($vista, $item=false)
    {
        $js = array();
        
        if(count($this->_js)){
            $js = $this->_js;
        }
        
        //se incluye directamente el '/' ya que estas rutas siempre van a ser asi
        $_layoutParams= array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/', 
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/', 
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'ruta_hoteles' => BASE_URL . 'public/img/hoteles/',
            'js' => $js
        );
        $rutaView= ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        
        if(is_readable($rutaView))
        {
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'menu-left.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        }
        else
        {
            throw new Exception('Error de vista: '.$rutaView);
        }
    }
    
    
    
    
    public function renderizaCenterBox($vista, $item=false)
    {
        $rutaView= ROOT . 'views' . DS . $this->_controlador . DS . 'centerBox' . DS . $vista . '.phtml';
        if(is_readable($rutaView))
        {
            include_once $rutaView;
        }
        else
        {
            throw new Exception('Error de vista AJAX');
        }
    }
    
}