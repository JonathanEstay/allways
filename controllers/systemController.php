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
            Session::set('sessMOD_DTH_codTipoHab', $DTH_codTiHab);
            $DTH_tHab= $this->loadModel('tipoHab');
            
            $DTH_objsTipoHab= $DTH_tHab->getTipoHab($DTH_codTiHab);
            $this->_view->DTH_nombreDTipoHab= $DTH_objsTipoHab[0]->getNombre();
            
            $DTH_objsDetTipoHab= $DTH_tHab->getDetTipoHab($DTH_codTiHab, Session::get('sessMOD_ETH_codHotel'));
            if($DTH_objsDetTipoHab!=false)
            {
                Session::set('sess_DTH_cntFotos', 1);
                $this->_view->DTH_foto1= $DTH_objsDetTipoHab[0]->getFoto1();
                $this->_view->DTH_foto2= $DTH_objsDetTipoHab[0]->getFoto2();
                $this->_view->DTH_foto3= $DTH_objsDetTipoHab[0]->getFoto3();
                $this->_view->DTH_foto4= $DTH_objsDetTipoHab[0]->getFoto4();
                
                Session::set('sessMOD_DTH_img1', $this->_view->DTH_foto1);
                Session::set('sessMOD_DTH_img2', $this->_view->DTH_foto2);
                Session::set('sessMOD_DTH_img3', $this->_view->DTH_foto3);
                Session::set('sessMOD_DTH_img4', $this->_view->DTH_foto4);
            }
            else
            {
                Session::set('sess_DTH_cntFotos', 0);
                $this->_view->DTH_foto1=false;
                $this->_view->DTH_foto2=false;
                $this->_view->DTH_foto3=false;
                $this->_view->DTH_foto4=false;
                
                Session::set('sessMOD_DTH_img1', $this->_view->DTH_foto1);
                Session::set('sessMOD_DTH_img2', $this->_view->DTH_foto2);
                Session::set('sessMOD_DTH_img3', $this->_view->DTH_foto3);
                Session::set('sessMOD_DTH_img4', $this->_view->DTH_foto4);
            }
            
            $this->_view->renderingCenterBox('detalleTipoHab');
        }
        else
        {
            throw new Exception('Error al cargar el detalle de tipo habitaci&oacute;n');
        }
    }
    
    public function modificarTipoHab()
    {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest')
        {
            $MTH_tHab= $this->loadModel('tipoHab');
            $this->getLibrary('upload' . DS . 'class.upload');
            $rutaImg= ROOT . 'public' . DS . 'img' . DS .'tipo_habitacion' . DS;

            $cntFotos=0;
            $ML_status=true;
            $ML_sqlIns='INSERT INTO fotos_hoteles (tipoh, cod_hotel';
            for($i=1; $i<=4; $i++)
            {
                if(isset($_FILES['DTH_flImagen' . $i]['name']))
                {
                    if($_FILES['DTH_flImagen' . $i]['name'])
                    {
                        if(Functions::validaFoto($_FILES['DTH_flImagen' . $i]['type'])==false)
                        {
                            $ML_status=false;
                            echo 'La Imagen '. $i .' debe ser formato [.JPG] [.GIF] [.PNG]';
                            break;
                        }

                        if($_FILES['DTH_flImagen' . $i]['size'] > 524288) //512KB
                        {
                            $ML_status=false;
                            echo 'La Imagen '. $i .' debe ser menor a <b>500kb</b>';
                            break;
                        }
                        
                        $ML_sqlIns.=', foto' . $i;
                    }
                    else
                    {
                        ++$cntFotos;
                    }
                }
                else
                {
                    ++$cntFotos;
                }
            }
            
            
            
            
            
            
            if($ML_status)
            {
                $ML_sqlUpd='UPDATE fotos_hoteles SET ';
                $ML_sqlIns.=') VALUES ( "'.Session::get('sessMOD_DTH_codTipoHab').'", "'.Session::get('sessMOD_ETH_codHotel').'" ';
                $ML_c='';
                for($i=1; $i<=4; $i++)
                {
                    if(isset($_FILES['DTH_flImagen' . $i]['name']))
                    {
                        if($_FILES['DTH_flImagen' . $i]['name'])
                        {
                            $upload= new upload($_FILES['DTH_flImagen' . $i], 'es_ES');
                            $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                            $upload->file_max_size = '524288'; // 512KB
                            $upload->file_new_name_body= 'upl_' . sha1(uniqid());
                            $upload->process($rutaImg);
                            
                            $ML_sqlIns.= ', "' . $upload->file_dst_name . '" ';
                            $ML_sqlUpd.= $ML_c . ' foto' . $i . '= "' . $upload->file_dst_name . '" ';
                            $ML_c=','; 
                            /*if($upload->processed)
                            {   //THUMBNAILS
                                $imagen= $upload->file_dst_name; //nombre de la imagen
                                $thumb= new upload($upload->file_dst_pathname);
                                $thumb->image_resize= true;
                                $thumb->image_x= 100;
                                $thumb->image_y= 100;
                                $thumb->file_name_body_pre= 'thumb_';
                                $thumb->process($rutaImg . 'thumb' . DS);
                            }
                            else
                            {
                                echo '(Imagen ' . $i . ')'.$upload->error . '<br>';
                            }*/
                        }
                    }
                    else
                    {
                        if($this->getTexto('chkDTH_flImagen' . $i)=='on')
                        {
                            $cntFotos=0;
                            Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            $ML_sqlUpd.= $ML_c . ' foto' . $i . '= "" ';
                            $ML_c=',';
                        }
                    }
                    
                }
                
                
                if($cntFotos==4)
                {
                    $ML_status=false;
                    echo 'Para modificar debe realizar al menos un cambio. ';
                }
                else
                {
                    if(Session::get('sess_DTH_cntFotos')==1)
                    {
                        $ML_sqlUpd.=' WHERE tipoh = "'.Session::get('sessMOD_DTH_codTipoHab').'" AND cod_hotel = "'.Session::get('sessMOD_ETH_codHotel').'"';
                        //echo $ML_sqlUpd;
                        $MTH_tHab->exeSQL($ML_sqlUpd);
                    }
                    else
                    {
                        $ML_sqlIns.=')';
                        $MTH_tHab->exeSQL($ML_sqlIns);
                    }
                    echo 'OK';
                }
                
            }
        }
        else
        {
            throw new Exception('Error inesperado, intente nuevamente. Si el error persiste comuniquese con el administrador');
        }
    }
    
    
    
    public function editarHotel()
    {
        $EH_codHotel= $this->getTexto('H_codHotel');
        if($EH_codHotel)
        {
            Session::set('sessMOD_EH_codHotel', $EH_codHotel);
            $hoteles= $this->loadModel('hotel');
            $categorias= $this->loadModel('categoria');

            $this->_view->objCategorias= $categorias->getCategorias();
            $this->_view->objCategoriasCNT= count($this->_view->objCategorias);
            
            
            $objHotel= $hoteles->getHotel($EH_codHotel);
            if($objHotel)
            {
                $this->_view->EH_hotel= $objHotel[0]->getHotel();
                $this->_view->EH_cat= $objHotel[0]->getCat();
                $this->_view->EH_lat= $objHotel[0]->getLat();
                $this->_view->EH_lon= $objHotel[0]->getLon();
                $this->_view->EH_direc= $objHotel[0]->getDirec();
                $this->_view->EH_web= $objHotel[0]->getSitioWeb();
                
                $this->_view->EH_imgEnc= $objHotel[0]->getImgEnc();
                $this->_view->EH_imgCont= $objHotel[0]->getImgCont();
                $this->_view->EH_imgCont2= $objHotel[0]->getImgCont2();
                $this->_view->EH_imgCont3= $objHotel[0]->getImgCont3();
                $this->_view->EH_imgCont4= $objHotel[0]->getImgCont4();
                
                /* SERVICIOS HOTEL*/
                if($objHotel[0]->getRestaurante()==1){ $this->_view->EH_rest='checked="checked"'; }
                if($objHotel[0]->getLavanderia()==1){ $this->_view->EH_lavan='checked="checked"'; }
                if($objHotel[0]->getBar()==1){ $this->_view->EH_bar='checked="checked"'; }
                if($objHotel[0]->getCafeteria()==1){ $this->_view->EH_cafe='checked="checked"'; }
                if($objHotel[0]->getServHab()==1){ $this->_view->EH_servHab='checked="checked"'; }
                if($objHotel[0]->getBusiness()==1){ $this->_view->EH_business='checked="checked"'; }
                if($objHotel[0]->getInterHotel()==1){ $this->_view->EH_intHot='checked="checked"'; }
                if($objHotel[0]->getEstaciona()==1){ $this->_view->EH_est='checked="checked"'; }
                if($objHotel[0]->getPiscinaCub()==1){ $this->_view->EH_pCub='checked="checked"'; }
                if($objHotel[0]->getPiscinaDes()==1){ $this->_view->EH_pDes='checked="checked"'; }
                if($objHotel[0]->getGym()==1){ $this->_view->EH_gym='checked="checked"'; }
                if($objHotel[0]->getSpa()==1){ $this->_view->EH_spa='checked="checked"'; }
                if($objHotel[0]->getTenis()==1){ $this->_view->EH_tenis='checked="checked"'; }
                if($objHotel[0]->getGuarderia()==1){ $this->_view->EH_guard='checked="checked"'; }
                if($objHotel[0]->getSalasReu()==1){ $this->_view->EH_salas='checked="checked"'; }
                if($objHotel[0]->getJardin()==1){ $this->_view->EH_jardin='checked="checked"'; }
                if($objHotel[0]->getDiscapacitados()==1){ $this->_view->EH_disca='checked="checked"'; }
                if($objHotel[0]->getBoutique()==1){ $this->_view->EH_bou='checked="checked"'; }
                
                
                /* SERVICIOS HABITACION */
                if($objHotel[0]->getAcondicionado()==1){ $this->_view->EH_acon='checked="checked"'; }
                if($objHotel[0]->getCalefaccion()==1){ $this->_view->EH_cale='checked="checked"'; }
                if($objHotel[0]->getNoFuma()==1){ $this->_view->EH_noFuma='checked="checked"'; }
                if($objHotel[0]->getCajaFuerte()==1){ $this->_view->EH_cajaF='checked="checked"'; }
                if($objHotel[0]->getMiniBar()==1){ $this->_view->EH_mBar='checked="checked"'; }
                if($objHotel[0]->getTV()==1){ $this->_view->EH_tv='checked="checked"'; }
                if($objHotel[0]->getTvCable()==1){ $this->_view->EH_tvC='checked="checked"'; }
                if($objHotel[0]->getInterHab()==1){ $this->_view->EH_intHab='checked="checked"'; }
                if($objHotel[0]->getSecador()==1){ $this->_view->EH_seca='checked="checked"'; }
                if($objHotel[0]->getBarraSeg()==1){ $this->_view->EH_barra='checked="checked"'; }
                if($objHotel[0]->getTelefono()==1){ $this->_view->EH_fono='checked="checked"'; }            
            }
            
            $this->_view->renderingCenterBox('editarHotel');
        }
        else
        {
            throw new Exception('Error al tratar de editar el hotel');
        }
    }
    
    
    public function modificarHotel()
    {
        if(strtolower($this->getServer('HTTP_X_REQUESTED_WITH'))=='xmlhttprequest')
        {
            $MH_nombreHotel= $this->getTexto('txtEH_nombreHotel');
            $MH_direc= $this->getTexto('txtEH_direc');
            $MH_cate= $this->getTexto('cmbEH_categoria');
            $MH_lat= $this->getTexto('txtEH_latitud');
            $MH_lon= $this->getTexto('txtEH_longitud');
            $MH_sitWeb= $this->getTexto('txtEH_sitioWeb');
            
            
            if(!$MH_nombreHotel)
            {
                echo 'Debe ingresar un nombre de hotel'; exit;
            }
            else if(!$MH_cate)
            {
                echo 'El hotel debe tener una categor&iacute;a'; exit;
            }
            else if(!$MH_direc)
            {
                echo 'Debe ingresar una direcci&oacute;n para el hotel'; exit;
            }
            
            
            
            $MH_Hotel= $this->loadModel('hotel');
            $this->getLibrary('upload' . DS . 'class.upload');
            $rutaImg= ROOT . 'public' . DS . 'img' . DS .'hoteles' . DS;

            
            for($i=1; $i<=5; $i++)
            {
                if(isset($_FILES['flImagen' . $i]['name']))
                {
                    if($_FILES['flImagen' . $i]['name'])
                    {
                        if(Functions::validaFoto($_FILES['flImagen' . $i]['type'])==false)
                        {
                            echo 'La Imagen '. $i .' debe ser formato [.JPG] [.GIF] [.PNG]';
                            exit;
                        }

                        if($_FILES['flImagen' . $i]['size'] > 524288) //512KB
                        {
                            echo 'La Imagen '. $i .' debe ser menor a <b>500kb</b>';
                            exit;
                        }
                    }
                }
            }
            
            
            
            
            
            //Servicios Hotel
            $MH_chkRest= Functions::validaChk($this->getTexto('chkEH_rest'));
            $MH_chkLavan= Functions::validaChk($this->getTexto('chkEH_lavan'));
            $MH_chkPisDesc= Functions::validaChk($this->getTexto('chkEH_pisDesc'));
            $MH_chkCanTenis= Functions::validaChk($this->getTexto('chkEH_cTenis'));
            $MH_chkBar= Functions::validaChk($this->getTexto('chkEH_bar'));
            $MH_chkBusCen= Functions::validaChk($this->getTexto('chkEH_busCen'));
            $MH_chkSpa= Functions::validaChk($this->getTexto('chkEH_spa'));
            $MH_chkGuard= Functions::validaChk($this->getTexto('chkEH_guarderia'));
            $MH_chkCafe= Functions::validaChk($this->getTexto('chkEH_cafe'));
            $MH_chkInterHot= Functions::validaChk($this->getTexto('chkEH_interHot'));
            $MH_chkGym= Functions::validaChk($this->getTexto('chkEH_gym'));
            $MH_chkSaReu= Functions::validaChk($this->getTexto('chkEH_sReu'));
            $MH_chkServHab= Functions::validaChk($this->getTexto('chkEH_servHab'));
            $MH_chkEst= Functions::validaChk($this->getTexto('chkEH_estaciona'));
            $MH_chkPisCub= Functions::validaChk($this->getTexto('chkEH_pisCub'));
            $MH_chkJar= Functions::validaChk($this->getTexto('chkEH_jardin'));
            $MH_chkDisca= Functions::validaChk($this->getTexto('chkEH_disca'));
            $MH_chkBou= Functions::validaChk($this->getTexto('chkEH_bou'));


            //Servicios Habitacion
            $MH_chkAirAcond= Functions::validaChk($this->getTexto('chkEH_airAcond'));
            $MH_chkCaFuerte= Functions::validaChk($this->getTexto('chkEH_cFuerte'));
            $MH_chkTvCable= Functions::validaChk($this->getTexto('chkEH_tvCable'));
            $MH_chkSecPelo= Functions::validaChk($this->getTexto('chkEH_sPelo'));
            $MH_chkCalef= Functions::validaChk($this->getTexto('chkEH_calefac'));
            $MH_chkMinBar= Functions::validaChk($this->getTexto('chkEH_mBar'));
            $MH_chkFono= Functions::validaChk($this->getTexto('chkEH_fono'));
            $MH_chkBarraSeg= Functions::validaChk($this->getTexto('chkEH_barraSeg'));
            $MH_chkNoFumar= Functions::validaChk($this->getTexto('chkEH_noFumar'));
            $MH_chkTV= Functions::validaChk($this->getTexto('chkEH_tv'));
            $MH_chkInterHab= Functions::validaChk($this->getTexto('chkEH_interHab'));


            $MH_sql='UPDATE hotel 
                    SET hotel="'.mb_convert_encoding($MH_nombreHotel, "ISO-8859-1", "UTF-8").'", direc="'.mb_convert_encoding($MH_direc, "ISO-8859-1", "UTF-8").'", cat="'.$MH_cate.'", SWEB="'.$MH_sitWeb.'", estado="", 
                    lat="'.$MH_lat.'", lon="'.$MH_lon.'", restaurante='.$MH_chkRest.', bar='.$MH_chkBar.', cafeteria='.$MH_chkCafe.', 
                    s_habitacion='.$MH_chkServHab.', busness_center='.$MH_chkBusCen.', internet_hotel='.$MH_chkInterHot.', estacionamiento='.$MH_chkEst.', 
                    piscina_cub='.$MH_chkPisCub.', piscina_des='.$MH_chkPisDesc.', gym='.$MH_chkGym.', spa='.$MH_chkSpa.', tenis='.$MH_chkCanTenis.', 
                    guarderia='.$MH_chkGuard.', salas_reunion='.$MH_chkSaReu.', jardin='.$MH_chkJar.', discapacitados='.$MH_chkDisca.', 
                    bautique='.$MH_chkBou.', acondicionado='.$MH_chkAirAcond.', calefaccion='.$MH_chkCalef.', no_fuma='.$MH_chkNoFumar.', 
                    caja_fuerte='.$MH_chkCaFuerte.', mini_bar='.$MH_chkMinBar.', television='.$MH_chkTV.', tv_cable='.$MH_chkTvCable.', 
                    inter_hab='.$MH_chkInterHab.',	secador_pelo='.$MH_chkSecPelo.', barra_seguridad='.$MH_chkBarraSeg.', 
                    lavanderia='.$MH_chkLavan.', telefono='.$MH_chkFono;

            

            
            for($i=1; $i<=5; $i++)
            {
                if(isset($_FILES['flImagen' . $i]['name']))
                {
                    if($_FILES['flImagen' . $i]['name'])
                    {
                        $upload= new upload($_FILES['flImagen' . $i], 'es_ES');
                        $upload->allowed= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                        $upload->file_max_size = '524288'; // 512KB
                        $upload->file_new_name_body= 'upl_' . sha1(uniqid());
                        $upload->process($rutaImg);

                        if($upload->processed)
                        {   //THUMBNAILS
                            $imagen= $upload->file_dst_name; //nombre de la imagen
                            //$MH_sql.= ', foto' . $i . '= "' . $imagen . '" ';

                            $thumb= new upload($upload->file_dst_pathname);
                            $thumb->image_resize= true;
                            $thumb->image_x= 150;
                            $thumb->image_y= 150;
                            $thumb->file_name_body_pre= 'thumb_';
                            $thumb->process($rutaImg . 'thumb' . DS);
                            
                            if($i==1)
                            {	
                                $MH_sql.=', img_encabezado = "'.$imagen.'", mini_img_encabezado = "'.$imagen.'" ';
                            }
                            else if($i==2)
                            {	
                                $MH_sql.=', img_contenido = "'.$imagen.'", mini_img_contenido = "'.$imagen.'" ';
                            }
                            else
                            {
                                $MH_sql.=', img_contenido'.($i-1).' = "'.$imagen.'", mini_img_contenido'.($i-1).' = "'.$imagen.'" ';
                            }
                        }
                        else
                        {
                            echo '(Imagen ' . $i . ')'.$upload->error . '<br>';
                        }
                    }
                }
                else
                {
                    if($i==1)
                    {	
                        if($this->getTexto('chkEH_flImagen' . $i)=='on')
                        {
                            //Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            //Functions::eliminaFile($rutaImg . 'thumb' . DS . Session::get('sessMOD_DTH_img' . $i));
                            $MH_sql.=', img_encabezado = "", mini_img_encabezado = "" ';
                        }
                    }
                    else if($i==2)
                    {	
                        if($this->getTexto('chkEH_flImagen' . $i)=='on')
                        {
                            //Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            //Functions::eliminaFile($rutaImg . 'thumb' . DS . Session::get('sessMOD_DTH_img' . $i));
                            $MH_sql.=', img_contenido = "", mini_img_contenido = "" ';
                        }
                    }
                    else
                    {
                        if($this->getTexto('chkEH_flImagen' . $i)=='on')
                        {
                            //Functions::eliminaFile($rutaImg . Session::get('sessMOD_DTH_img' . $i));
                            Functions::eliminaFile($rutaImg . 'thumb' . DS . Session::get('sessMOD_DTH_img' . $i));
                            $MH_sql.=', img_contenido'.($i-1).' = "", mini_img_contenido'.($i-1).' = "" ';
                        }
                    }
                    
                }
            }

            
            $MH_sql.=' WHERE codigo='.$_SESSION['sessMOD_EH_codHotel'];
            
            //echo $MH_sql; exit;
            $MH_Hotel->exeSQL($MH_sql);
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