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
        
        
        
        if(Session::get('sess_CR_fechaDesde') && Session::get('sess_CR_fechaHasta'))
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
            $this->_view->objReservas=false;
            $this->_view->CR_fechaIni= Session::get('sess_fechaDefault');
            $this->_view->CR_fechaFin= Functions::sumFecha(Session::get('sess_fechaDefault'), 0, 3);

            if(Session::get('sess_CR_tipoFecha')==1)
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
    
    
    public function hoteles()
    {
        Session::acceso('Usuario');
        $categorias= $this->loadModel('categoria');
        $hoteles= $this->loadModel('hotel');
        
        $this->_view->objCiudades= $this->_ciudad->getCiudadesPRG();
        $this->_view->objCiudadesCNT= count($this->_view->objCiudades);


        $this->_view->objCategorias= $categorias->getCategorias();
        $this->_view->objCategoriasCNT= count($this->_view->objCategorias);
        
        if(Session::get('sess_H_nombre') || Session::get('sess_H_ciudad') || Session::get('sess_H_cat'))
        {
            $this->_view->objHoteles= $hoteles->getHoteles(Session::get('sess_H_nombre'), Session::get('sess_H_ciudad'), Session::get('sess_H_cat'));
            $this->_view->objHotelesCNT= count($this->_view->objHoteles);
        }
        else
        {
            $this->_view->objHoteles=false;
        }
        
        
        
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
    
    
    public function verPDF_HTML($numFile)
    {
        $ruta_img= 'views/layout/' . DEFAULT_LAYOUT . '/img/';
        
        ob_start();
        require_once ROOT . 'views' . DS . 'system' . DS .'pdf' . DS . 'vouchea.php';
        $content = ob_get_clean();
        
        $this->getLibrary('html2pdf.class');
        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
                    //$html2pdf->setModeDebug();
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Voucher_N_'.$numFile.'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    
    
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                          METODOS VIEWS CENTER BOX                            *
    *                                                                              *
    *******************************************************************************/
    public function cartaConfirmacion()
    {
        //Cargando modelos
        $M_file= $this->loadModel('reserva');
        $M_bloqueos= $this->loadModel('bloqueo');
        $M_packages= $this->loadModel('programa');
        
        //Rescatando post
        $nFile= $this->getTexto('CR_n_file');
        $codPRG= $this->getTexto('CR_cod_prog');
        $codBloq= $this->getTexto('CR_cod_bloq');

        //Creando los objetos para las View
        $objsFile= $M_file->getFile($nFile);
        //$objsFileCNT= count($objsFile);
        
        $this->_view->CC_objsDetFile= $M_file->getDetFile($nFile);
        $this->_view->CC_objsDetFileCNT= count($this->_view->CC_objsDetFile);
        
        $objsBloq= $M_bloqueos->getBloqueos($codBloq);
        
        $this->_view->CC_objsDetBloq= $M_bloqueos->getDetBloq($codBloq, $nFile);
        $this->_view->CC_objsDetBloqCNT= count($this->_view->CC_objsDetBloq);
        
        $objsPackages= $M_packages->getPackages($codPRG);
        
        
        if($objsFile!=false)
        {
            $this->_view->CC_agencia=$objsFile[0]->getAgencia();
            $this->_view->CC_vage= $objsFile[0]->getVage();
            $this->_view->CC_nomPax= $objsFile[0]->getNomPax();
            $this->_view->CC_nPax= $objsFile[0]->getNPax();
            $this->_view->CC_fviaje= $objsFile[0]->getFViaje();
            $this->_view->CC_moneda= $objsFile[0]->getMoneda();
            $this->_view->CC_totventa= $objsFile[0]->getTotVenta();
            $this->_view->CC_cambio= $objsFile[0]->getCambio();
            $this->_view->CC_comag= $objsFile[0]->getComag();
            
            $this->_view->CC_datos= $objsFile[0]->getDatos();
            $this->_view->CC_ajuste= $objsFile[0]->getAjuste();
            $this->_view->CC_tcomi= $objsFile[0]->getTComi();
        }
        
        if($objsPackages!=false)
        {
            $this->_view->CC_nombreProg=$objsPackages[0]->getNombre();
        }
        
        if($objsBloq!=false)
        {
            $this->_view->CC_notas= str_replace("\n", "<br>", $objsBloq[0]->getNotas());
        }
        
        $this->_view->numFile= $nFile;
        $this->_view->codigoPRG= $codPRG;
        $this->_view->codigoBloq= $codBloq;
        
        
        
        $this->_view->renderingCenterBox('cartaConfirm');
    }
    
    public function editarTipoHab()
    {
        $ETH_codHotel= $this->getTexto('H_codHotel');
        if($ETH_codHotel)
        {
            Session::set('sessMOD_ETH_codHotel', $ETH_codHotel);
            $ETH_hotel= $this->loadModel('hotel');
            $ETH_tHab= $this->loadModel('tipoHab');
            
            
            $ETH_objHotel= $ETH_hotel->getHotel($ETH_codHotel);
            $this->_view->ETH_nombreHotel= $ETH_objHotel[0]->getHotel();
            
            
            $this->_view->ETH_objsTipoHab= $ETH_tHab->getTipoHab();
            $this->_view->ETH_objsTipoHabCNT= count($this->_view->ETH_objsTipoHab);
        
            
            $this->_view->renderingCenterBox('editarTipoHab');
        }
        else
        {
            throw new Exception('Error al editar Tipo habitaci&oacute;n');
        }
    }
    
    public function detalleTipoHab()
    {
        $DTH_codTiHab= $this->getTexto('DTH_valor');
        if($DTH_codTiHab)
        {
            $DTH_tHab= $this->loadModel('tipoHab');
            
            $DTH_objsTipoHab= $DTH_tHab->getTipoHab($DTH_codTiHab);
            $this->_view->DTH_nombreDTipoHab= $DTH_objsTipoHab[0]->getNombre();
            
            $DTH_objsDetTipoHab= $DTH_tHab->getDetTipoHab($DTH_codTiHab, Session::get('sessMOD_ETH_codHotel'));
            if($DTH_objsDetTipoHab!=false)
            {
                $this->_view->DTH_foto1= $DTH_objsDetTipoHab[0]->getFoto1();
                $this->_view->DTH_foto2= $DTH_objsDetTipoHab[0]->getFoto2();
                $this->_view->DTH_foto3= $DTH_objsDetTipoHab[0]->getFoto3();
                $this->_view->DTH_foto4= $DTH_objsDetTipoHab[0]->getFoto4();
            }
            else
            {
                $this->_view->DTH_foto1=false;
                $this->_view->DTH_foto2=false;
                $this->_view->DTH_foto3=false;
                $this->_view->DTH_foto4=false;
            }
            $this->_view->renderingCenterBox('detalleTipoHab');
        }
        else
        {
            throw new Exception('Error al cargar el detalle de tipo habitaci&oacute;n');
        }
    }
    
    public function modificarHotel()
    {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest')
        {
            
            $this->getLibrary('upload' . DS . 'class.upload');
            $rutaImg= ROOT . 'public' . DS . 'img' . DS .'fotos_hab' . DS;

            for($i=1; $i<=4; $i++)
            {
                if(isset($_FILES['DTH_flImagen' . $i]))
                {
                    $upload= new upload($_FILES['DTH_flImagen' . $i], 'es_ES');
                    $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                    $upload->file_max_size = '524288'; // 512KB
                    $upload->file_new_name_body= 'upl_' . sha1(uniqid());
                    //$upload->process($rutaImg);

                    echo '(Imagen ' . $i . ')'. $upload->error . '<br>';
                    $upload=false;
                }
                //$upload->processed=false;
            }
            
            echo ' - FIN'; exit;
            for($i=1; $i<=4; $i++)
            {
                /*if(isset($_FILES['DTH_flImagen' . $i]['name']))
                {*/
                    $upload= new upload($_FILES['DTH_flImagen' . $i], 'es_ES');
                    $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                    $upload->file_max_size = '524288'; // 512KB
                    $upload->file_new_name_body= 'upl_' . sha1(uniqid());
                    $upload->process($rutaImg);

                    if($upload->processed)
                    {   //THUMBNAILS
                        /*$imagen= $upload->file_dst_name; //nombre de la imagen
                        $thumb= new upload($upload->file_dst_pathname);
                        $thumb->image_resize= true;
                        $thumb->image_x= 100;
                        $thumb->image_y= 100;
                        $thumb->file_name_body_pre= 'thumb_';
                        $thumb->process($rutaImg . 'thumb' . DS);*/
                    }
                    else
                    {
                        echo '(Imagen ' . $i . ')'.$upload->error . '<br>';
                    }
                /*}
                else
                {
                    $imagenesFail.= '(imagen ' . $i . ') ';
                }*/
            }

            echo 'OK';
        }
        else
        {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
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
        Session::set('sess_alerts', $tipo); //Tipo alerta
        Session::set('sess_alerts_msg', $msg);
    }
    
    private function _alertDestroy()
    {
        Session::destroy('sess_alerts');
        Session::destroy('sess_alerts_msg');
    }
    
    
    
    
    
    
    
    
    
    
    /*******************************************************************************
    *                                                                              *
    *                             METODOS PROCESADORES                             *
    *                                                                              *
    *******************************************************************************/
    public function buscarHotel()
    {
        Session::set('sess_H_nombre', $this->getTexto('txtNombre-Hot'));
        Session::set('sess_H_ciudad', $this->getTexto('txtCiudad-Hot'));
        Session::set('sess_H_cat', $this->getTexto('cmbCategoria'));
        
        $this->redireccionar('system/hoteles');
    }
    
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