<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class systemController extends Controller
{
    private $_pdf;
    private $_ciudad;
    
    public function __construct() {
        parent::__construct();
        $this->_ciudad= $this->loadModel('ciudad');
        $this->_loadLeft();
    }
    
    
    /*******************************************************************************
    *                                                                              *
    *                                METODOS VIEWS                                 *
    *                                                                              *
    *******************************************************************************/
    public function index()
    {
        Session::acceso('Usuario');
        //$this->_view->setJS(array(''));
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesPRG();
        $this->_view->objCiudadesCNT= count($this->_view->objCiudades);
        
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('index');
    }
    
    
    public function consultarReserva()
    {
        Session::acceso('Usuario');
        $reserva= $this->loadModel('reserva');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesPRG();
        $this->_view->objCiudadesCNT= count($this->_view->objCiudades);
        
        
        
        if(Session::get('sess_CR_fechaDesde'))
        {
            $this->_view->CR_fechaIni= Session::get('sess_CR_fechaDesde');
            $this->_view->CR_fechaFin= Session::get('sess_CR_fechaHasta');

            if(Session::get("sess_CR_tipoFecha")==1)
            {
                $this->_view->rdbRes='checked';
            }
            else
            {
                $this->_view->rdbVia='checked';
            }
            
            $this->_view->objReservas= $reserva->getReservas(
                Functions::invertirFecha(Session::get('sess_CR_fechaDesde'), '/', '-'),
                Functions::invertirFecha(Session::get('sess_CR_fechaHasta'), '/', '-'),
                Session::get('sess_CR_tipoFecha'),
                Session::get('sess_sp_acceso'),
                Session::get('sess_clave_usuario')
                );
            $this->_view->objReservasCNT= count($this->_view->objReservas);
            
        }
        else
        {
            $this->_view->CR_fechaIni= Session::get('sess_fechaDefault');
            $this->_view->CR_fechaFin= Functions::sumFecha(Session::get('sess_fechaDefault'), 0, 3);

            if(Session::get("sess_CR_tipoFecha")==1)
            {
                $this->_view->rdbRes='checked';
            }
            else
            {
                $this->_view->rdbVia='checked';
            }
        }
        
       
        
        $this->_view->currentMenu=1;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('consultarReserva');
    }
    
    public function cartaConfirmacion()
    {
        $this->getTexto('CR_n_file');
        $this->getTexto('CR_cod_prog');
        $this->getTexto('CR_cod_bloq');
        
        $this->_view->renderingCenterBox('cartaConfirm');
    }
    
    public function hoteles()
    {
        Session::acceso('Usuario');
        $categorias= $this->loadModel('categoria');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesPRG();
        $this->_view->objCiudadesCNT= count($this->_view->objCiudades);
        
        
        $this->_view->objCategorias= $categorias->getCategorias();
        $this->_view->objCategoriasCNT= count($this->_view->objCategorias);
        
        $this->_view->currentMenu=2;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('hoteles');
    }
    
    
    public function adminProgramas()
    {
        Session::acceso('Usuario');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesPRG();
        $this->_view->objCiudadesCNT= count($this->_view->objCiudades);
        
        $this->_view->currentMenu=3;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('adminProgramas');
    }
    
    
    public function imagenes()
    {
        Session::acceso('Usuario');
        $agencia= $this->loadModel('agencia');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesPRG();
        $this->_view->objCiudadesCNT= count($this->_view->objCiudades);
        
        $this->_view->objAgencias= $agencia->getAgencias();
        $this->_view->objAgenciasCNT= count($this->_view->objAgencias);
        
        $this->_view->currentMenu=4;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderingSystem('imagenes');
    }
    
    
    public function contactenos()
    {
        Session::acceso('Usuario');
        
        $this->_view->currentMenu=5;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('contactenos');
    }
    
    
    public function verPDF($id = false)
    {
        Session::acceso('Usuario');
        
        $this->getLibrary('fpdf');
        $this->getLibrary('pdf_html');
        
        $pdf= new PDF('P', 'mm','letter');
        $ruta_img= ROOT . 'public' . DS . 'img' . DS;
        
        require_once ROOT . 'views' . DS . 'sistema' . DS . 'pdf' . DS . 'voucherPDF.php';
        
        //$this->_pdf= new FPDF();
        //$this->_pdf->AddPage();
        //$this->_pdf->SetFont('Arial','B',16);
        //$this->_pdf->Cell(40,10, utf8_decode('¡Hola, Mundo!'));
        //$this->_pdf->Cell(40,10,'¡Hola, Mundo!');
        //$this->_pdf->Output();
    }
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                               METODOS PRIVADOS                               *
    *                                                                              *
    *******************************************************************************/
    private function _loadLeft()
    {
        $this->_view->ML_fechaIni=  Session::get('sess_fechaDefault');
        $this->_view->ML_fechaFin=  Session::get('sess_fechaDefault');
    }
    
    private function _alert($tipo=false, $msg=false)
    {
        if($tipo)
        {
            Session::set('sess_alerts', $tipo); //Tipo alerta
            Session::set('sess_alerts_msg', $msg);
        }
        else
        {
            Session::destroy('sess_alerts');
            Session::destroy('sess_alerts_msg');
        }
    }
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                             METODOS PROCESADORES                             *
    *                                                                              *
    *******************************************************************************/
    public function buscarReservas()
    {
        Session::set('sess_CR_fechaDesde', $this->getTexto('txtFechaDesde-ConsRes'));
        Session::set('sess_CR_fechaHasta', $this->getTexto('txtFechaHasta-ConsRes'));
        Session::set('sess_CR_tipoFecha', $this->getInt('rdbFecha'));
        
        $this->redireccionar('system/consultarReserva');
    }
    
    public function salir()
    {
        Session::destroy();
        header('Location: ' . BASE_URL . 'login?ex');
        exit;
    }
    
    
}

?>