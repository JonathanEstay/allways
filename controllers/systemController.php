<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class systemController extends Controller
{
    private $_pdf;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        Session::acceso('Usuario');
        $ciudad= $this->loadModel('ciudad');
        
        $this->_view->objCiudades= $ciudad->getCiudades();
        $this->_view->objCiudadesCNT= count($this->_view->objCiudades);
        
        $this->_view->ML_fechaIni=  Session::get('sess_fechaDefault');
        $this->_view->ML_fechaFin=  Session::get('sess_fechaDefault');
        
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSystem('index');
    }
    
    
    
    public function salir()
    {
        Session::destroy();
        header('Location: ' . BASE_URL . 'login?ex');
        exit;
    }
    
    
    public function adminProgramas()
    {
        Session::acceso('Usuario');
        
        $common= $this->loadModel('common');
        $this->_view->getCiudadesHotel= $common->getCiudadesHot();
        $this->_view->getCiudadesServ= $common->getCiudadesServ();
        $this->_view->getCiudadesPRG= $common->getCiudadesPRG();
        
        $this->_view->currentMenu=3;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('adminProgramas');
    }
    
    public function imagenes()
    {
        Session::acceso('Usuario');
        
        $common= $this->loadModel('common');
        $this->_view->getCiudadesHotel= $common->getCiudadesHot();
        $this->_view->getCiudadesServ= $common->getCiudadesServ();
        $this->_view->getCiudadesPRG= $common->getCiudadesPRG();
        
        $this->_view->currentMenu=5;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('imagenes');
    }
    
    
    
    
    
    
    
    public function consultarBooking($pagina = false)
    {
        Session::acceso('Usuario');
        
        $common= $this->loadModel('common');
        $this->_view->getCiudadesHotel= $common->getCiudadesHot();
        $this->_view->getCiudadesServ= $common->getCiudadesServ();
        $this->_view->getCiudadesPRG= $common->getCiudadesPRG();
        
        
        $this->_view->CR_fechaDesde=date('d/m/Y');
        if(Session::get('sess_pCR_fechaDesde'))
        {
            $this->_view->CR_fechaDesde=Session::get('sess_pCR_fechaDesde');
        }
        
        $this->_view->CR_fechaHasta=Funciones::sumFecha(date('d/m/Y'), 0, 3);
        if(Session::get('sess_pCR_tipoFecha')==1)
        {
                $this->_view->rdbRes='checked';
        }
        else
        {
                $this->_view->rdbVia='checked';
        }
        
        $booking= $this->loadModel('booking');
      
        $this->_view->getBookings= $booking->getConsRes(
                Funciones::invertirFecha(Session::get('sess_pCR_fechaDesde'), '/', '-'),
                Funciones::invertirFecha(Session::get('sess_pCR_fechaHasta'), '/', '-'),
                Session::get('sess_pCR_tipoFecha'),
                Session::get('sess_id_agencia'),
                Session::getLevel('Admin'),
                Session::get('sess_usuario')
                );
        
        
        
        /*BEIGN: Paginador; */
        $pagina= $this->filtrarInt($pagina);
        $this->getLibrary('paginador');
        $paginador= new Paginador();
        /*$this->_view->getBookings=$paginador->paginar($booking->getConsRes(
                Funciones::invertirFecha(Session::get('sess_pCR_fechaDesde'), '/', '-'),
                Funciones::invertirFecha(Session::get('sess_pCR_fechaHasta'), '/', '-'),
                Session::get('sess_pCR_tipoFecha'),
                Session::get('sess_id_agencia'),
                Session::getLevel('Admin'),
                Session::get('sess_usuario')
                ), $pagina);*/
        $this->_view->paginacion = $paginador->getView('prueba', 'sistema/consultarBooking');
        /*END: Paginador;*/
        
        
        
        $this->_view->currentMenu=1;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('consultarBooking');
    }
    
    public function verPDF($id = false)
    {
        Session::acceso('Usuario');
        
        $this->getLibrary('fpdf');
        //$this->_pdf= new FPDF();
        
        $this->getLibrary('pdf_html');
        $pdf= new PDF('P', 'mm','letter');
        
        $ruta_img= ROOT . 'public' . DS . 'img' . DS;
        require_once ROOT . 'views' . DS . 'sistema' . DS . 'pdf' . DS . 'voucherPDF.php';
        
        
        //$this->_pdf->AddPage();
        //$this->_pdf->SetFont('Arial','B',16);
        //$this->_pdf->Cell(40,10, utf8_decode('¡Hola, Mundo!'));
        //$this->_pdf->Cell(40,10,'¡Hola, Mundo!');
        //$this->_pdf->Output();
    }
    
    
    
    
    
    
    public function anularBooking()
    {
        Session::acceso('Usuario');
        
        $common= $this->loadModel('common');
        $this->_view->getCiudadesHotel= $common->getCiudadesHot();
        $this->_view->getCiudadesServ= $common->getCiudadesServ();
        $this->_view->getCiudadesPRG= $common->getCiudadesPRG();
        
        
        $this->_view->CR_fechaDesde=date('d/m/Y');
        if(Session::get('sess_pCR_fechaDesde'))
        {
            $this->_view->CR_fechaDesde=Session::get('sess_pCR_fechaDesde');
        }
        
        $this->_view->CR_fechaHasta=Funciones::sumFecha(date('d/m/Y'), 0, 3);
        if(Session::get('sess_pCR_tipoFecha')==1)
        {
                $this->_view->rdbRes='checked';
        }
        else
        {
                $this->_view->rdbVia='checked';
        }
        
        $booking= $this->loadModel('booking');
      
        $this->_view->getBookings= $booking->getConsRes(
                Funciones::invertirFecha(Session::get('sess_pCR_fechaDesde'), '/', '-'),
                Funciones::invertirFecha(Session::get('sess_pCR_fechaHasta'), '/', '-'),
                Session::get('sess_pCR_tipoFecha'),
                Session::get('sess_id_agencia'),
                Session::getLevel('Admin'),
                Session::get('sess_usuario')
                );
        
        
        
        /*BEIGN: Paginador; */
        $pagina= $this->filtrarInt($pagina);
        $this->getLibrary('paginador');
        $paginador= new Paginador();
        /*$this->_view->getBookings=$paginador->paginar($booking->getConsRes(
                Funciones::invertirFecha(Session::get('sess_pCR_fechaDesde'), '/', '-'),
                Funciones::invertirFecha(Session::get('sess_pCR_fechaHasta'), '/', '-'),
                Session::get('sess_pCR_tipoFecha'),
                Session::get('sess_id_agencia'),
                Session::getLevel('Admin'),
                Session::get('sess_usuario')
                ), $pagina);*/
        $this->_view->paginacion = $paginador->getView('prueba', 'sistema/consultarBooking');
        /*END: Paginador;*/
        
        
        
        $this->_view->currentMenu=6;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('anularBooking');
    }
    
    
    
    
    public function carro()
    {
        Session::acceso('Usuario');
        
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('carro');
    }
    
    
    public function contactenos()
    {
        Session::acceso('Usuario');
        
        $this->_view->currentMenu=7;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('contactenos');
    }
    
    
    public function usuarios()
    {
        Session::acceso('Usuario');
        
        $this->_view->currentMenu=4;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('usuarios');
    }
    
    
    
    
    
    public function buscarHoteles()
    {
        Session::acceso('Usuario');
        
        
        /*BEIGN: Paginador; */
        $pagina= $this->filtrarInt($pagina);
        $this->getLibrary('paginador');
        $paginador= new Paginador();
        /*$this->_view->getHoteles=$paginador->paginar($hoteles->getHoteles(), $pagina);*/
        //$this->_view->paginacion = $paginador->getView('prueba', 'sistema/buscarHoteles');
        /*END: Paginador;*/
        
        
        $this->_view->currentMenu=8;
        $this->_view->titulo='ORISTRAVEL';
        $this->_view->renderizaSistema('buscarHoteles');
    }
    
}

?>