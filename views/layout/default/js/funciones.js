// JavaScript Document
function procesoEnviaForm(classFrm, php, btn, div)
{
    $("#"+btn).attr('disabled', 'disabled');

    initLoad();

    var formData= new FormData($("."+classFrm)[0]);
    
    //hacemos la peticion ajax  
    $.ajax({
        url: php,  
        type: 'POST',
        //Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){},
        //una vez finalizado correctamente
        success: function(data)
        {
            endLoad();
            if(data==='OK')
            {
                $("#"+div).delay(1500).queue(function(n)
                {
                    $("#"+div).html('<div class="alert alert-dismissable alert-success"><strong>Terminado</strong><br/><img src="' + RUTA_IMG_JS + 'ok.png" width="32" border="0" /> Proceso realizado con &eacute;xito.</div>');
                    n();
                });
            }
            else
            { 	
                $('#mensajeWar').html(data);
                $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
                $('#divAlertWar').animate({
                        'display': 'block'
                });

                $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
                $('#divAlertWar').animate({
                                            'display': 'none'
                                        });

                $("#"+btn).delay(2000).queue(function(m)
                {
                    $("#"+btn).removeAttr("disabled");
                    m();
                });	
            }
        },

        //si ha ocurrido un error
        error: function()
        {
            endLoad();

            $('#mensajeWar').html('Error error');
            $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
            $('#divAlertWar').animate({
                    'display': 'block'
            });

            $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
            $('#divAlertWar').animate({
                                        'display': 'none'
                                    });
        }
    });
}











function procesoCargaDiv(valor, div, php)
{
    $("#"+div).html('');
    if(valor!==0)
    {
        $.post(php, 
        {
                _PCD_: valor
        }, function(data)
        {
                $("#"+div).html(data);
        });
    }
}






function procesoConServ(classFrm, php, btn)
{
    $("#"+btn).attr('disabled', 'disabled');

    initLoad();


    //alertError(btn, 'Error al tratar de confirmar ', 2000);
    //return false;

    /*for(rP=1; rP>=1; rP++)
    {
        txtPasaporte= document.getElementById("rP_chkPas_"+rP);
        txtRut= document.getElementById("rP_txtRut_"+rP);
        if(txtRut!=null)
        {
            if($.trim($("#rP_txtNom_"+rP).val())=='')
            {
                alertError(btn, 'Debe ingresar un nombre', 2000);
                $("#rP_txtNom_"+rP).focus();
                return false;
                break;
            }
        }
        else
        {
                break;
        }
    }*/


    var formData= new FormData($("."+classFrm)[0]);
    //hacemos la petición ajax  
    $.ajax({
            url: php,  
            type: 'POST',
            //Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){},
            //una vez finalizado correctamente
            success: function(data)
            {
                var myArrayData= data.split('&');
                if($.trim(myArrayData[0])=='OK')
                {
                    endLoad();

                    $('#divAlertExito').delay( 1000 ).fadeIn( 500 );
                    $('#divAlertExito').animate({
                            'display': 'block'
                    });

                    $('#divAlertExito').delay( 1000 ).fadeOut( 500 );
                    $('#divAlertExito').animate({
                                                            'display': 'none'
                                                    });
                }
                else
                { 	
                    alertError(btn, $.trim(myArrayData[1]), 5000);
                }
            },

            //si ha ocurrido un error
            error: function()
            {
                    endLoad();

                    $('#mensajeWar').html('Error error');
                    $('#divAlertWar').delay( 1000 ).fadeIn( 500 );
                    $('#divAlertWar').animate({
                            'display': 'block'
                    });

                    $('#divAlertWar').delay( 5000 ).fadeOut( 500 );
                    $('#divAlertWar').animate({
                                                            'display': 'none'
                                                    });
            }
    });
}


function alertError(btn, msg, time)
{
	endLoad();
				
	$('#mensajeWar').html(msg);
	$('#divAlertWar').delay( 1000 ).fadeIn( 500 );
	$('#divAlertWar').animate({
		'display': 'block'
	});
	
	$('#divAlertWar').delay( time ).fadeOut( 500 );
	$('#divAlertWar').animate({
						'display': 'none'
					});
					
	$("#"+btn).delay(2500).queue(function(m)
	{
		$("#"+btn).removeAttr("disabled");
		m();
	});		
}


function initLoad()
{
    $('#divAlertInfo').fadeIn( 500 );
    $('#divAlertInfo').animate({
                            'display': 'block'
                    });
}

function endLoad()
{
    $('#divAlertInfo').delay( 100 ).fadeOut( 500 );
    $('#divAlertInfo').animate({
                                'display': 'none'
                            });
}


function validaReserva(classFrm, php, div, divTit, titulo)
{
	initLoad();

	$("#"+div).html("");
	$("#"+divTit).html(titulo);
	var formData= new FormData($("."+classFrm)[0]);
	//hacemos la peticion ajax  
	$.ajax({
		url: php,  
		type: 'POST',
		//Form data
		//datos del formulario
		data: formData,
		//necesario para subir archivos via ajax
		cache: false,
		contentType: false,
		processData: false,
		//mientras enviamos el archivo
		beforeSend: function(){},
		//una vez finalizado correctamente
		success: function(data)
		{
			$("#"+div).html(data);
			endLoad();
		},
		
		//si ha ocurrido un error
		error: function()
		{
			$("#"+div).html("Ha ocurrido un error");
		}
	});
}









function buscarCiudad(ciudad, frmBus, ob, id)
{

    var span= document.getElementById(ob);
    var length = ciudad.length;

    if(length >= 3)
    {
        $.post("process/procesoObtieneCiudad.php", 
        {
            post_ciudad: ciudad, 
            post_frmBus: frmBus,
            post_span: ob,
            post_idTxt: id
        }, function(data){
            $("#"+ob).html(data);
            span.style.display='block';
        });
    }
    else
    {
        span.style.display='none'; 
        ciudad= '';
            $.post("process/procesoObtieneCiudad.php", { post_ciudad: ciudad, post_frmBus: frmBus }, function(data){
            $("#"+ob).html(data);
        });
    }
}








function habitaciones(table, num)
{
    for(var x=1;x<=3;x++)
    {
            document.getElementById(table+'_'+x).style.display="none";
    }

    for(var x=1;x<=num;x++)
    {
        var id=table+'_'+x;
        mostrado=0;
        elem = document.getElementById(id);
        if(elem.style.display=="block")
        {
            mostrado=1;
            elem.style.display="none";
        }
        if(mostrado!=1)
        {
            //elem.style.display="block";
            $('#'+table+'_'+x).fadeIn( 1000 );
            $('#'+table+'_'+x).animate({
                    'display': 'block'
            });
        }		
    }
}




function habilitaEdadChild(id,hab)
{
    var i, x;
    status_1 = new Array (true, false, false); 
    status_2 = new Array (true, true, false); 

    for(i=0; i<3; i++)
    {
        if(id==i)
        {
            for(x=1; x<4; x++)
            {
                if(hab==x)
                {
                    document.getElementById('mL_edadChild_1_'+x).disabled = status_1[i];
                    document.getElementById('mL_edadChild_2_'+x).disabled = status_2[i];
                }
            }
        }
    }
}

function soloRut(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    //alert(charCode);
    if ((charCode >= 48 && charCode<= 57) || (charCode == 45) || (charCode == 107) || (charCode == 75)){
            return true;
    }else{ 
            return false;
    }
}


function checkServ(idChk, nConf, fPPago)
{   
    if($("#"+idChk).is(':checked')) {  
        if($.trim($("#"+nConf).val())==="" && $.trim($("#"+fPPago).val())==="")
        {
            $("#"+idChk).prop("checked", "");
        }
    } else {  
        if($.trim($("#"+nConf).val())!=="" || $.trim($("#"+fPPago).val())!=="")
        {
            $("#"+idChk).prop("checked", "checked");
        }
    }
}

function muestraOculta(id, estado)
{
    if(estado===1)
    {
        $('#'+id).delay( 10 ).fadeIn( 500 );
        $('#'+id).animate({
                'display': 'block'
        });
    }
    else
    {
        $('#'+id).delay( 10 ).fadeOut( 500 );
        $('#'+id).animate({
                            'display': 'none'
                        });
    }
}

function abrePopup(div, docPHP, idTitulo, titulo, val)
{
    initLoad();
    $("#" + div).html('');
    $("#" + idTitulo ).html(titulo);
    $.post(docPHP, 
    {
        varCenterBox: val
    }, function(data)
    {
        $("#" + div).html(data);
        endLoad();
    });
}





    /*BEGIN: Busqueda de Programas */
    $('#btnBuscarProgramas').on('click',function()
    {
        var mL_Error=0;
        $("#btnBuscarProgramas").attr('disabled', 'disabled');
        if($('#mL_txtCiudadDestino').val() != '' && $('#mL_txtCiudadDestino').val() != 'Ingrese ciudad de destino')
        {
            if($('#ML_cmbHab').val() != 0)
            {
                $(document).skylo('start');

                setTimeout(function(){
                        $(document).skylo('set',50);
                },1000);

                setTimeout(function(){
                        $(document).skylo('end');
                },1500);
                setTimeout(function(){
                   document.getElementById('frmBuscarProgramas').submit();
                },2500);
            }
            else
            {
                mL_Error=1;
                $('#mensajeWar').html('Debe seleccionar la cantidad de habitaciones');
            }
        }
        else
        {
            mL_Error=1;
            $('#mensajeWar').html('Debe ingresar una ciudad de destino');	
        }




        if( mL_Error==1 )
        {
            $('#divAlertWar').delay( 10 ).fadeIn( 500 );
            $('#divAlertWar').animate({
                    'display': 'block'
            });

            $('#divAlertWar').delay( 2000 ).fadeOut( 500 );
            $('#divAlertWar').animate({
                                        'display': 'none'
                                    });

            $("#btnBuscarProgramas").delay(2000).queue(function(dis)
            {
                $("#btnBuscarProgramas").removeAttr("disabled");
                dis();
            });	
        }
		
    });
    /*END: Busqueda de Programas*/
    
    
    
    
    
    
    
    $('#menuConsRes').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'system/consultarReserva';
        },2500);
    });
    
    
    
    $('#menuHoteles').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'system/hoteles';
        },2500);
    });
    
    
    $('#menuAdminProg').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'system/adminProgramas';
        },2500);
    });
    
    
    $('#menuImagenes').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'system/imagenes';
        },2500);
    });
    
    
    $('#menuContacto').on('click',function(){
        $(document).skylo('start');

        setTimeout(function(){
            $(document).skylo('set',50);
        },1000);

        setTimeout(function(){
            $(document).skylo('end');
        },1500);
		setTimeout(function(){
            window.location.href = BASE_URL_JS + 'system/contacto';
        },2500);
    });
    
    
    
    /* ADMIN PROGRAMAS */
    $('#btnAdmProg').on('click',function(){
        
        if($('#AP_cmbCiudadDestino').val()===0)
        {
            $('#divAlertWar').fadeIn( 1500 );
            $('#divAlertWar').animate({
                    'display': 'block'
            });
        }
        else
        {
            $(document).skylo('start');

            setTimeout(function(){
                    $(document).skylo('set',50);
            },1000);

            setTimeout(function(){
                    $(document).skylo('end');
            },1500);
            setTimeout(function(){
                    document.getElementById('frmAdmProg').submit();
            },2500);
        }
    });
