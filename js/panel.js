
class Usuario{
    constructor(){
        this.idEdit = 0;
        this.metodo = 0; //1: guardar; 2: modificar
        this.formulario;
        this.editURLimg = 0;
        this.btn_img;
    }

    listar(){
        $.ajax({
            url: "backend/panel/usuarios/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_usuarios").html('');
                $("#load_table_usuarios").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.doc_nro}</td>
                                                <td>${datos.apellido_pat + " " + datos.apellido_mat + " " + datos.nombre}</td>
                                                <td>${datos.privilegios}</td>
                                               
                                    `; 
                    
                    if(datos.habilitado=="SI"){
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }else{
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }
                     
                    
                    contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("usuarios",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                }); 

                $("#load_table_usuarios").html('');
                $("#load_data_usuarios").html(contenido_ajax);

            }
        });
    }

    registrar(){ 

        this.formulario.append("editURLimg",this.editURLimg); 

        $.ajax({
            type: 'POST',
            url: 'backend/panel/usuarios/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        user.listar();
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        user.editURLimg = 0;
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }

    editar(id){
        document.getElementById("formulario-usuarios").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Editar Usuario");
        
        $.ajax({
            url: "backend/panel/usuarios/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                $('#inputPRIV').val(datos[0].privilegios);
                $('#inputAP').val(datos[0].apellido_pat);
                $('#inputAM').val(datos[0].apellido_mat);
                $('#inputNOM').val(datos[0].nombre);
                $('#inputDNI').val(datos[0].doc_nro);
                $('#inputUSER').val(datos[0].usuario);
                $('#inputPASS').val(datos[0].pass);
                $('#inputNAC').val(datos[0].nacimiento);
                $('#inputGRADO').val(datos[0].grado);
                $('#inputEC').val(datos[0].estado_civil);
                $('#inputLN').val(datos[0].lugar_nacimiento);
                $('#inputCOM').val(datos[0].comentarios);
                $('#inputTEL').val(datos[0].telefono);
                $('#inputDIR').val(datos[0].direccion);
                $('#inputREF').val(datos[0].referencia);
                $('#inputDIS').val(datos[0].distrito);
                $('#inputPROV').val(datos[0].provincia);
                $('#inputEMAIL').val(datos[0].correo);  
                
                if(datos[0].url_foto!=null && datos[0].url_foto!=""){
                    $("#load_foto_modal").html(`
                        <img src="img/upload/usuarios/${datos[0].url_foto}" width="100%">
                    `);
                }else{
                    $("#load_foto_modal").html(`
                        <img src="img/user.png" width="100%">
                    `);
                }

                if(datos[0].habilitado=='SI'){
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-danger btn_modals" onclick="user.habilitar(${id},0);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Bloquear</button>
                    `);
                }else{
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-primary btn_modals" onclick="user.habilitar(${id},1);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Desbloquear</button>
                    `);
                }


            }
        });
    }

    editarSave(id){
     
        this.formulario.append("id",id);   
        this.formulario.append("editURLimg",this.editURLimg);   

        $.ajax({
            url: "backend/panel/usuarios/ajax_editar.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Actualización Correcta!
                            </div>
                        `);
                        setTimeout(()=>{
                            user.listar();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            user.editURLimg = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }

    habilitar(id,operacion){
        $.ajax({
            url: "backend/panel/usuarios/ajax_habilitar.php",
            type: "POST",
            data: {id: id, operacion:operacion},
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        setTimeout(()=>{
                            user.listar();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            user.editURLimg = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },700);
                    }else{
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }

    buscar_usuario(clave){

        var tipo_bus = $("#usuarios_buscar_tipo").val();

        $.ajax({
            url: "backend/panel/usuarios/ajax_buscar_usuario.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_usuarios").html('');
                $("#load_table_usuarios").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.doc_nro}</td>
                                                <td>${datos.apellido_pat + " " + datos.apellido_mat + " " + datos.nombre}</td>
                                                <td>${datos.privilegios}</td>
                                               
                                    `; 
                    
                    if(datos.habilitado=="SI"){
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }else{
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }
                     
                    
                    contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("usuarios",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                }); 

                $("#load_table_usuarios").html('');
                $("#load_data_usuarios").html(contenido_ajax);

            }
        });
    }

    validar(id){
        $.ajax({
            url: "backend/panel/usuarios/ajax_validar.php",
            type: "POST",
            data: {consulta: "buscar",id:id},
            success: function(response){
                console.log(response);
            }
        });
    }
}

class Cliente{
    constructor(){
        this.idEdit = 0;
        this.metodo = 0; //1: guardar; 2: modificar
        this.formulario;
        this.editURLimg = 0;
        this.editURLimg2 = 0;
        this.btn_img;
        this.btn_img2;
    }

    listar(){
        $.ajax({
            url: "backend/panel/clientes/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_clientes").html('');
                $("#load_table_clientes").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.dni}</td>
                                                <td>${datos.apellido_pat + " " + datos.apellido_mat + " " + datos.nombre}</td>
                                                <td>${datos.direccion}</td>
                                                <td>${datos.telefono}</td>
                                    `; 
                    
                    switch(datos.calificacion){
                        case 'BUENO':   
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-success">${datos.calificacion}</span></center></td>
                                        `;
                                        break;
                        case 'REGULAR': 
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-warning">${datos.calificacion}</span></center></td>
                                        `;
                                        break;
                        case 'MALO': 
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-danger">${datos.calificacion}</span></center></td>
                                        `;
                                        break;
                        default: 
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-secondary text-uppercase">Sin evaluar</span></center></td>
                                        `;
                                        break;
                    }

                    contenido_ajax += `
                                        <td class="text-center"><center><span id="load_cred${datos.id}" class="load_cred text-uppercase"></span></center></td>
                    `;
                    
                    if(datos.habilitado=="SI"){
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }else{
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }
                     
                    
                    contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("clientes",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                        <!--<button style="width:110px;" type="button" class="btn btn-danger" onclick="modalsDelete('slide',${datos.id},'${datos.url_foto}');"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                }); 
            
                $("#load_table_clientes").html('');
                $("#load_data_clientes").html(contenido_ajax);   
                
                
                $.ajax({
                    url: "backend/panel/clientes/ajax_ver_creditos.php",
                    type: "GET",
                    data: {consulta: "buscar"},
                    beforeSend: function(){
                        //$(".load_cred").html(`<span class="badge badge-pill badge-success">Sin deudas</span>`);
                    },
                    success: function(response){
                        var datos = JSON.parse(response);
                        console.log(datos)
                 

                        datos.forEach( datos => {               
                            
                            //$("#load_cred"+datos.id).html(``);
                            switch(datos.estado){
                                case "REGISTRADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-secondary">${datos.estado}</span>`); break;
                                case "PREAPROBADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-secondary">${datos.estado}</span>`); break;
                                case "APROBADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-secondary">${datos.estado}</span>`); break;
                                case "DESEMBOLSADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-warning">Deuda</span>`); break;
                                case "TERMINADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-success">Sin deuda</span>`); break;
                            }
                            
                        }); 
                    }
                });
                
            }
        });
    }

    registrar(){ 

        this.formulario.append("editURLimg",this.editURLimg); 
        this.formulario.append("editURLimg2",this.editURLimg2);

        $.ajax({
            type: 'POST',
            url: 'backend/panel/clientes/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        cliente.listar();
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        cliente.editURLimg = 0;
                        cliente.editURLimg2 = 0;
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }

    editar(id){
        document.getElementById("formulario-clientes").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Editar Cliente");
        
        $.ajax({
            url: "backend/panel/clientes/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                

                $('#inputINS').val(datos[0].inscripcion);
                $('#inputAP').val(datos[0].apellido_pat);
                $('#inputAM').val(datos[0].apellido_mat);
                $('#inputNOM').val(datos[0].nombre);
                $('#inputDNI').val(datos[0].dni);
                $('#inputOCUPACION_TIPO').val(datos[0].ocupacion_tipo);
                $('#inputOCUPACION_DES').val(datos[0].ocupacion_des);
                $('#inputNAC').val(datos[0].nacimiento);
                $('#inputNH').val(datos[0].hijos);
                $('#inputGRADO').val(datos[0].grado_ins);
                $('#inputEC').val(datos[0].estado_civ);
                $('#inputLN').val(datos[0].lugar_nac);
                $('#inputCOM').val(datos[0].comentario);

                $('#inputTEL').val(datos[0].telefono);
                $('#inputDIR').val(datos[0].direccion);
                $('#inputREF').val(datos[0].referencia);
                $('#inputDIS').val(datos[0].distrito);
                $('#inputPROV').val(datos[0].provincia);
                $('#inputDOM').val(datos[0].tipo_viv);
                $('#inputTR').val(datos[0].tiempo_viv); 
                $('#inputOBS').val(datos[0].observaciones); 
                
                if(datos[0].url_foto!=null && datos[0].url_foto!=""){
                    $("#load_foto_modal").html(`
                        <img src="img/upload/clientes/${datos[0].url_foto}" width="100%">
                    `);
                }else{
                    $("#load_foto_modal").html(`
                        <img src="img/user.png" width="100%">
                    `);
                }

                if(datos[0].habilitado=='SI'){
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-danger btn_modals" onclick="cliente.habilitar(${id},0);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Bloquear</button>
                    `);
                }else{
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-primary btn_modals" onclick="cliente.habilitar(${id},1);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Desbloquear</button>
                    `);
                }


            }
        });

        conyugue.listar(id);
        negocio.listar(id);
        negocio.listarConsumo(id);
    }

    editarSave(id){
     
        this.formulario.append("id",id);   
        this.formulario.append("editURLimg",this.editURLimg);   
        this.formulario.append("editURLimg2",this.editURLimg2);

        $.ajax({
            url: "backend/panel/clientes/ajax_editar.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Actualización Correcta!
                            </div>
                        `);
                        setTimeout(()=>{
                            cliente.listar();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            cliente.editURLimg = 0;
                            cliente.editURLimg2 = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }

    habilitar(id,operacion){
        $.ajax({
            url: "backend/panel/clientes/ajax_habilitar.php",
            type: "POST",
            data: {id: id, operacion:operacion},
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        setTimeout(()=>{
                            cliente.listar();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            cliente.editURLimg = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },700);
                    }else{
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }

    buscar_cliente(clave){

        var tipo_bus = $("#clientes_buscar_tipo").val();

        $.ajax({
            url: "backend/panel/clientes/ajax_buscar_cliente.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_clientes").html('');
                $("#load_table_clientes").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.dni}</td>
                                                <td>${datos.apellido_pat + " " + datos.apellido_mat + " " + datos.nombre}</td>
                                                <td>${datos.direccion}</td>
                                                <td>${datos.telefono}</td>
                                    `; 
                    
                    switch(datos.calificacion){
                        case 'BUENO':   
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-success">${datos.calificacion}</span></center></td>
                                        `;
                                        break;
                        case 'REGULAR': 
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-warning">${datos.calificacion}</span></center></td>
                                        `;
                                        break;
                        case 'MALO': 
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-danger">${datos.calificacion}</span></center></td>
                                        `;
                                        break;
                        default: 
                                        contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-secondary text-uppercase">Sin evaluar</span></center></td>
                                        `;
                                        break;
                    }

                    contenido_ajax += `
                                        <td class="text-center"><center><span id="load_cred${datos.id}" class="load_cred text-uppercase"></span></center></td>
                    `;
                    
                    if(datos.habilitado=="SI"){
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }else{
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 20px;">${datos.habilitado}</span></td>
                                    `;
                    }
                     
                    
                    contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("clientes",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                        <!--<button style="width:110px;" type="button" class="btn btn-danger" onclick="modalsDelete('slide',${datos.id},'${datos.url_foto}');"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                }); 
            
                $("#load_table_clientes").html('');
                $("#load_data_clientes").html(contenido_ajax);   
                
                
                $.ajax({
                    url: "backend/panel/clientes/ajax_ver_creditos.php",
                    type: "GET",
                    data: {consulta: "buscar"},
                    beforeSend: function(){
                        //$(".load_cred").html(`<span class="badge badge-pill badge-success">Sin deudas</span>`);
                    },
                    success: function(response){
                        var datos = JSON.parse(response);
                        //console.log(datos)
                 

                        datos.forEach( datos => {               
                            
                            $("#load_cred"+datos.id).html(``);
                            switch(datos.estado){
                                case "REGISTRADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-secondary">${datos.estado}</span>`); break;
                                case "PREAPROBADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-secondary">${datos.estado}</span>`); break;
                                case "APROBADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-secondary">${datos.estado}</span>`); break;
                                case "DESEMBOLSADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-warning">Deuda</span>`); break;
                                case "TERMINADO": $("#load_cred"+datos.id).append(`<span class="badge badge-pill badge-success">Sin deuda</span>`); break;
                            }
                            
                        }); 
                    }
                });
                
            }
        });
    }
}

class Conyugue{
    constructor(){
        this.idEdit = 0;
        this.metodo = 0; //1: guardar; 2: modificar
        this.formulario;
        this.tipo = "";
    }

    listar(id){
        $.ajax({
            url: "backend/panel/clientes/conyugue/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar",id:id},
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.dni}</td>
                                                <td>${datos.nombre + " " + datos.apellido_pat + " " + datos.apellido_mat}</td>
                                                <td>${datos.tipo}</td>
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("conyugue",${datos.id},"${datos.tipo}");'><i class="fas fa-edit"></i> Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                });
            
                $("#load_data_conyugue").html(contenido_ajax);
                                      
            }
        });
    }

    registrar(id_cliente){ 

        this.formulario.append("id_cliente",id_cliente); 
        
        $.ajax({
            type: 'POST',
            url: 'backend/panel/clientes/conyugue/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#conyugue-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#conyugue-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        conyugue.listar(id_cliente);
                        $('#modal-add-conyugue').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        setTimeout(()=>{$("#conyugue-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#conyugue-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#conyugue-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#conyugue-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#conyugue-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }

    editar(id,tipo){
        this.tipo = tipo;
        document.getElementById("formulario-conyugue").reset();
        $('#modal-add-conyugue').modal('show'); 
        $('#modal-add-conyugue h4').html("Editar Conyugue");
        
        $.ajax({
            url: "backend/panel/clientes/conyugue/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id, tipo: tipo},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]); 

                $('#input_con_AP').val(datos[0].apellido_pat);
                $('#input_con_AM').val(datos[0].apellido_mat);
                $('#input_con_NOM').val(datos[0].nombre);
                $('#input_con_DNI').val(datos[0].dni);
                $('#input_con_SEXO').val(datos[0].sexo);  
                $('#input_con_FN').val(datos[0].nacimiento);
                $('#input_con_DIR').val(datos[0].direccion);
                $('#input_con_REF').val(datos[0].referencia);
                $('#input_con_OCUP').val(datos[0].ocupacion);
                $('#input_con_DIRT').val(datos[0].dir_trabajo);
                $('#input_con_PT').val(datos[0].parentesco);
                $('#input_con_IDCLI').val(datos[0].idcliente);

                //$('#input_con_CA').val(datos[0].tipo);
                $("input[name=input_con_CA][value="+datos[0].tipo+"]").prop("checked",true);

                if(datos[0].habilitado=='SI'){
                    $(".modal-btn-cont-2").html(`
                        <button type="button" class="btn btn-danger btn_modals" onclick="conyugue.habilitar(${id},0,'${datos[0].tipo}');" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Bloquear</button>
                    `);
                }else{
                    $(".modal-btn-cont-2").html(`
                        <button type="button" class="btn btn-primary btn_modals" onclick="conyugue.habilitar(${id},1,'${datos[0].tipo}');" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Desbloquear</button>
                    `);
                }


            }
        });
    }

    editarSave(id,tipo){
     
        this.formulario.append("id",id);
        this.formulario.append("tipo",tipo);   

        $.ajax({
            url: "backend/panel/clientes/conyugue/ajax_editar.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#conyugue-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#conyugue-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Actualización Correcta!
                            </div>
                        `);
                        setTimeout(()=>{
                            conyugue.listar(cliente.idEdit);
                            conyugue.tipo = null;
                            $('#modal-add-conyugue').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#conyugue-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#conyugue-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#conyugue-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#conyugue-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#conyugue-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }

    habilitar(id,operacion,tipo){
        $.ajax({
            url: "backend/panel/clientes/conyugue/ajax_habilitar.php",
            type: "POST",
            data: {id: id, operacion:operacion, tipo: tipo},
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#conyugue-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#conyugue-ajax-result").html(`
                            <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        setTimeout(()=>{
                            conyugue.listar(cliente.idEdit);
                            $('#modal-add-conyugue').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#conyugue-ajax-result").html("");},700);
                        },700);
                    }else{
                        $("#conyugue-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#conyugue-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }
}

class Negocio{
    constructor(){
        this.idEdit = 0;
        this.metodo = 0; //1: guardar; 2: modificar
        this.formulario;
        this.tipo = 0;

        this.editURLimg = 0;
        this.btn_img;
        this.editURLimg2 = 0;
        this.btn_img2;
    }

    listar(id){
        $.ajax({
            url: "backend/panel/clientes/negocio/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar",id:id},
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax_negocio = "";
                var contenido_ajax_transporte = "";
                var conteo_negocio = 0;
                var conteo_transporte = 0;

                datos.forEach( datos => {

                    if(datos.tipo=="NEGOCIO"){
                        conteo_negocio++;
                        contenido_ajax_negocio += `
                                                <tr>
                                                    <th scope="row">${conteo_negocio}</th>
                                                    <td style="padding: 5px 13px;">${datos.norm_tipo}</td>
                                                    <td style="padding: 5px 13px;">${datos.norm_tipo_negocio}</td>
                                                    <td style="padding: 5px 13px;">
                                                        <div class="col text-center"> 
                                                            <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("negocio",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                        </div>
                                                    </td>
                                                </tr>
                        `;  
                    }else{
                        conteo_transporte++;
                        contenido_ajax_transporte += `
                                                <tr>
                                                    <th scope="row">${conteo_transporte}</th>
                                                    <td style="padding: 5px 13px;">${datos.trans_tipo}</td>
                                                    <td style="padding: 5px 13px;">${datos.trans_empresa}</td>
                                                    <td style="padding: 5px 13px;">
                                                        <div class="col text-center"> 
                                                            <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("transporte",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                        </div>
                                                    </td>
                                                </tr>
                        `;  
                    }


                     
                });
            
                $("#load_data_negocio_normal").html(contenido_ajax_negocio);
                $("#load_data_negocio_transporte").html(contenido_ajax_transporte);
                                      
            }
        });
    }

    listarConsumo(id){
        $.ajax({
            url: "backend/panel/clientes/negocio/ajax_ver_consumo.php",
            type: "GET",
            data: {consulta: "buscar",id:id},
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;

                datos.forEach( datos => {

                        conteo++;
                        contenido_ajax += `
                                                <tr>
                                                    <th scope="row">${conteo}</th>
                                                    <td style="padding: 5px 13px;">${datos.dedicacion}</td>
                                                    <td style="padding: 5px 13px;">${datos.ingreso}</td>
                                                    <td style="padding: 5px 13px;">${datos.lugar_trabajo}</td>
                                                    <td style="padding: 5px 13px;">
                                                        <div class="col text-center"> 
                                                            <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit("consumo",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                        </div>
                                                    </td>
                                                </tr>
                        `;  
                    


                     
                });
            
                $("#load_data_credito_consumo").html(contenido_ajax);
                                      
            }
        });
    }

    registrar(id_cliente){ 

        this.formulario.append("editURLimg",this.editURLimg); 
        this.formulario.append("editURLimg2",this.editURLimg2); 
        this.formulario.append("id_cliente",id_cliente);
        this.formulario.append("tipo",this.tipo); 
        
        if(this.tipo=="NEGOCIO"){
            $.ajax({
                type: 'POST',
                url: 'backend/panel/clientes/negocio/ajax_registrar.php',
                data: this.formulario,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#negocio-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#negocio-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Registro Correcto!
                                </div>
                        `);
                        setTimeout(()=>{
                            negocio.listar(id_cliente);
                            $('#modal-add-negocio').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#negocio-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#negocio-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#negocio-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#negocio-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }     
                    }
                           
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#negocio-ajax-result").html(`
                                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                                </div>
                    `);      
                }
            });
        }else{
            $.ajax({
                type: 'POST',
                url: 'backend/panel/clientes/negocio/ajax_registrar.php',
                data: this.formulario,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#transporte-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#transporte-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Registro Correcto!
                                </div>
                        `);
                        setTimeout(()=>{
                            negocio.listar(id_cliente);
                            $('#modal-add-transporte').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#transporte-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#transporte-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#transporte-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#transporte-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }     
                    }
                           
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#transporte-ajax-result").html(`
                                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                                </div>
                    `);      
                }
            });
        }
        
    }

    registrarConsumo(id_cliente){ 

        this.formulario.append("id_cliente",id_cliente);
        
        $.ajax({
                type: 'POST',
                url: 'backend/panel/clientes/negocio/ajax_registrar_consumo.php',
                data: this.formulario,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#consumo-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#consumo-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Registro Correcto!
                                </div>
                        `);
                        setTimeout(()=>{
                            negocio.listarConsumo(id_cliente);
                            $('#modal-add-consumo').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#consumo-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#consumo-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#consumo-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#consumo-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }     
                    }
                           
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#consumo-ajax-result").html(`
                                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                                </div>
                    `);      
                }
        });
        
        
    }

    editar(id){
        if(this.tipo=="NEGOCIO"){
            $.ajax({
                url: "backend/panel/clientes/negocio/ajax_ver.php",
                type: "GET",
                data: {consulta: "editar", id: id},
                success: function(response){
                    var datos = JSON.parse(response);
                    //console.log(datos[0]); 
                    $('#input_neg_TIPO').val(datos[0].norm_tipo);
                    $('#input_neg_TIPOLOC').val(datos[0].norm_tipo_local);
                    $('#input_neg_SECTOR').val(datos[0].norm_tipo_negocio);
                    $('#input_neg_TIEMPO').val(datos[0].tiempo); 
                }
            });
        }else{
            $.ajax({
                url: "backend/panel/clientes/negocio/ajax_ver.php",
                type: "GET",
                data: {consulta: "editar", id: id},
                success: function(response){
                    var datos = JSON.parse(response);
                    //console.log(datos[0]); 
                    $('#input_trans_TIPO').val(datos[0].trans_tipo);
                    $('#input_trans_PLACA').val(datos[0].trans_placa);
                    $('#input_trans_EMP').val(datos[0].trans_empresa);
                    $('#input_trans_DIR').val(datos[0].trans_direccion); 
                    $('#input_trans_SOAT').val(datos[0].trans_soat); 
                    $('#input_trans_SOAT_CAD').val(datos[0].trans_soat_cad); 
                    $('#input_trans_TARJETA').val(datos[0].trans_tarjeta); 
                    $('#input_trans_TARJETA_CAD').val(datos[0].trans_tarjeta_cad); 
                    $('#input_trans_TIEMPO').val(datos[0].tiempo); 

                    if($("#input_trans_SOAT").val()=="SI"){
                        $("#input_trans_SOAT_CAD").removeAttr("readonly");
                        $("#input_trans_SOAT_CAD").prop('required',true);
                    }else{
                        $("#input_trans_SOAT_CAD").attr("readonly","readonly");
                        $("#input_trans_SOAT_CAD").prop('required',false);
                        $("#input_trans_SOAT_CAD").val('');
                    }

                    if($("#input_trans_TARJETA").val()=="SI"){
                        $("#input_trans_TARJETA_CAD").removeAttr("readonly");
                        $("#input_trans_TARJETA_CAD").prop('required',true);
                    }else{
                        $("#input_trans_TARJETA_CAD").attr("readonly","readonly");
                        $("#input_trans_TARJETA_CAD").prop('required',false);
                        $("#input_trans_TARJETA_CAD").val('');
                    }

                }
            });
        }
        
    }

    editarConsumo(id){
            $.ajax({
                url: "backend/panel/clientes/negocio/ajax_ver_consumo.php",
                type: "GET",
                data: {consulta: "editar", id: id},
                success: function(response){
                    var datos = JSON.parse(response);
                    //console.log(datos[0]); 

                    $("#input_cons_DEDICA").val(datos[0].dedicacion);
                    $("#input_cons_TIEMPO").val(datos[0].tiempo);
                    $("#input_cons_INGRESO").val(datos[0].ingreso);
                    $("#input_cons_TRABAJO").val(datos[0].lugar_trabajo);
                    $("#input_cons_PROFESION").val(datos[0].profesion);
                   
                }
            });
        
    }

    editarSave(id){
     
        this.formulario.append("id",id);  
        this.formulario.append("editURLimg",this.editURLimg); 
        this.formulario.append("editURLimg2",this.editURLimg2); 
        this.formulario.append("tipo",this.tipo);  

        if(this.tipo=="NEGOCIO"){
            $.ajax({
                url: "backend/panel/clientes/negocio/ajax_editar.php",
                type: "POST",
                data: this.formulario,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#negocio-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                        //console.log(response);
                        if(response==200){                      
                            $("#negocio-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Actualización Correcta!
                                </div>
                            `);
                            setTimeout(()=>{
                                negocio.listar(cliente.idEdit);
                                $('#modal-add-negocio').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                setTimeout(()=>{$("#negocio-ajax-result").html("");},700);
                            },600);
                        }else{
                            $('.btn_modals').prop('disabled', false);
                            if(response==301){                      
                                $("#negocio-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error al subir el archivo al servidor!
                                    </div>
                                `);
                            }else{
                                if(response==302){    
                                    $("#negocio-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            Se produjo un error con la base de datos!
                                        </div>
                                    `);
                                }else{
                                    $("#negocio-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            `+response+`
                                        </div>
                                    `);
                                }
                            }
                        }   
                    },
                    timeout: 30000,
                    error: function(xhr, status){
                        $('.btn_modals').prop('disabled', false);
                        $("#negocio-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                    </div>
                        `);
                        
                    }
            });
        }else{
            $.ajax({
                url: "backend/panel/clientes/negocio/ajax_editar.php",
                type: "POST",
                data: this.formulario,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#transporte-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                        //console.log(response);
                        if(response==200){                      
                            $("#transporte-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Actualización Correcta!
                                </div>
                            `);
                            setTimeout(()=>{
                                negocio.listar(cliente.idEdit);
                                $('#modal-add-transporte').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                setTimeout(()=>{$("#transporte-ajax-result").html("");},700);
                            },600);
                        }else{
                            $('.btn_modals').prop('disabled', false);
                            if(response==301){                      
                                $("#transporte-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error al subir el archivo al servidor!
                                    </div>
                                `);
                            }else{
                                if(response==302){    
                                    $("#transporte-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            Se produjo un error con la base de datos!
                                        </div>
                                    `);
                                }else{
                                    $("#transporte-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            `+response+`
                                        </div>
                                    `);
                                }
                            }
                        }   
                    },
                    timeout: 30000,
                    error: function(xhr, status){
                        $('.btn_modals').prop('disabled', false);
                        $("#transporte-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                    </div>
                        `);
                        
                    }
            });
        }

        
    }

    editarSaveConsumo(id){
     
        this.formulario.append("id",id);   

            $.ajax({
                url: "backend/panel/clientes/negocio/ajax_editar_consumo.php",
                type: "POST",
                data: this.formulario,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#consumo-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                        //console.log(response);
                        if(response==200){                      
                            $("#consumo-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Actualización Correcta!
                                </div>
                            `);
                            setTimeout(()=>{
                                negocio.listarConsumo(cliente.idEdit);
                                $('#modal-add-consumo').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                setTimeout(()=>{$("#consumo-ajax-result").html("");},700);
                            },600);
                        }else{
                            $('.btn_modals').prop('disabled', false);
                            if(response==301){                      
                                $("#consumo-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error al subir el archivo al servidor!
                                    </div>
                                `);
                            }else{
                                if(response==302){    
                                    $("#consumo-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            Se produjo un error con la base de datos!
                                        </div>
                                    `);
                                }else{
                                    $("#consumo-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            `+response+`
                                        </div>
                                    `);
                                }
                            }
                        }   
                    },
                    timeout: 30000,
                    error: function(xhr, status){
                        $('.btn_modals').prop('disabled', false);
                        $("#consumo-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                    </div>
                        `);
                        
                    }
            });
        
    }

}

class Credito{
    constructor(){
        this.idEdit = 0;
        this.metodo = 0; //1: guardar; 2: modificar
        this.formulario;
   
    }

    listarSolicitudes(){
        //console.log("listando")
        $.ajax({
            url: "../backend/panel/creditos/solicitudes/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_solicitudes").html('');
                $("#load_table_solicitudes").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.idcredito}</td>
                                                <td>${datos.cli_apellido_pat + ' ' + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td>${datos.usu_apellido_pat + ' ' + datos.usu_apellido_mat + " " + datos.usu_nombre}</td>
                                                <td>S/. ${datos.monto_prop}</td>
                                    `;

                    if(datos.monto_aprob==null || datos.monto_aprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>                  
                        `;
                    }else{
                        contenido_ajax += `
                                                <td>S/. ${datos.monto_aprob}</td> 
                        `;
                    }
                                                
                    
                    contenido_ajax += `
                                                <td>${datos.n_cuotas}</td>
                                                <td>${datos.interes + " %"}</td>          
                                    `;

                    if(datos.fecha_preaprob==null || datos.fecha_preaprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>
                        `;
                    }else{
                        contenido_ajax += `
                                                <td>${datos.fecha_preaprob}</td>
                        `;
                    }

                    switch(datos.estado){
                        case "REGISTRADO":      
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "PREAPROBADO":     
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-info">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "APROBADO":        
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-primary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "DESEMBOLSADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "FINALIZADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;
                    }

                    
                    if(datos.estado=="REGISTRADO"){
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit_credito("solicitud",${datos.idsolicitud});'><i class="fas fa-edit"></i> Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }else{
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:130px;" type="button" class="btn btn-warning" onClick='btn_ver_credito("solicitud",${datos.idsolicitud});'><i class="fas fa-eye"></i> Ver detalles</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }                             
                });
            
                $("#load_table_solicitudes").html('');
                $("#load_data_solicitudes").html(contenido_ajax);
                                      
            }
        });
    }
    listarAprobaciones(){
        //console.log("listando")
        $.ajax({
            url: "../backend/panel/creditos/aprobaciones/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_aprobaciones").html('');
                $("#load_table_aprobaciones").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.idcredito}</td>
                                                <td>${datos.cli_apellido_pat + ' ' + datos.cli_apellido_mat + ' ' + datos.cli_nombre}</td>
                                                <td>${datos.usu_ases_apellido_pat + ' ' + datos.usu_ases_apellido_mat + ' ' + datos.usu_ases_nombre}</td>
                                                <td>S/. ${datos.monto_prop}</td>
                                    `;

                    if(datos.monto_aprob==null || datos.monto_aprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>                  
                        `;
                    }else{
                        contenido_ajax += `
                                                <td>S/. ${datos.monto_aprob}</td> 
                        `;
                    }
                                                
                    
                    contenido_ajax += `
                                                <td>${datos.fecha_preaprob}</td>      
                    `;
                    if(datos.fecha_aprob==null || datos.fecha_aprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>      
                    `;
                    }else{
                        contenido_ajax += `
                                                <td>${datos.fecha_preaprob}</td>      
                    `;
                    }

                    switch(datos.estado){
                        case "REGISTRADO":      
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "PREAPROBADO":     
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-info">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "APROBADO":        
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-primary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "DESEMBOLSADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                            `;
                                            break;
                    }

                    
                    if(datos.estado=="PREAPROBADO"){
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:140px;" type="button" class="btn btn-success" onClick='btn_edit_credito("aprobacion",${datos.idaprobacion});'><i class="fas fa-lg fa-clipboard"></i> Ver Crédito</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }else{
                        if(datos.estado=='APROBADO'){
                                contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button type="button" class="btn btn-warning btn_modals" onclick="btn_ver_credito('aprobacion',${datos.idaprobacion});" style="width:130px;"><i class="fas fa-eye"></i> Ver detalles</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                        }
                    }                             
                });

                if(datos=="" || datos==null){
                    contenido_ajax = `
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>                    
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>                    
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>                    
                                    </tr>
                                    `;
                }
            
                $("#load_table_aprobaciones").html('');
                $("#load_data_aprobaciones").html(contenido_ajax);
                                      
            }
        });
    }
    listarDesembolsos(){
        //console.log("listando")
        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_desembolsos").html('');
                $("#load_table_desembolsos").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.cli_apellido_pat + ' ' + datos.cli_apellido_mat + ' ' + datos.cli_nombre}</td>
                                                <td>${datos.usu_ases_apellido_pat + ' ' + datos.usu_ases_apellido_mat + ' ' + datos.usu_ases_nombre}</td>
                                                <td>S/. ${datos.monto_aprob}</td>
                                    `;

                    switch(datos.estado){
                        case "REGISTRADO":      
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;
                
                        case "PREAPROBADO":     
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-info">${datos.estado}</span></td>
                                            `;
                                            break;
                
                        case "APROBADO":        
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-primary">${datos.estado}</span></td>
                                            `;
                                            break;
                
                        case "DESEMBOLSADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "FINALIZADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;
                    }

                    

                    
                    if(datos.estado=="APROBADO"){
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:155px;" type="button" class="btn btn-success" onclick='btn_edit_credito("desembolso",${datos.iddesembolso});'><i class="fas fa-lg fa-coins"></i> Desembolsar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }else{
                        if(datos.estado=='DESEMBOLSADO'){
                            if(datos.user_privilegios=="ADMINISTRADOR" || datos.user_privilegios=="ROOT"){
                                if(datos.hoy==datos.fecha_desem){
                                    contenido_ajax += `
                                                    <td>
                                                        <div class="col text-center"> 
                                                            <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                            <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                            <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                                            <button style="width:120px;margin-top:3px;" type="button" class="btn btn-danger" onclick='btn_edit_credito("extornar",${datos.iddesembolso});'><i class="fas fa-lg fa-history"></i> Extornar</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `;
                                }else{
                                    contenido_ajax += `
                                                    <td>
                                                        <div class="col text-center"> 
                                                            <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                            <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                            <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `;
                                }
                                
                            }else{
                                contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                        <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                        <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                            }
                        }else{
                            if(datos.estado=='FINALIZADO'){
                                contenido_ajax += `
                                        <td>
                                            <div class="col text-center"> 
                                                <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            }
                        }
                    }                             
                });
            
                $("#load_table_desembolsos").html('');
                $("#load_data_desembolsos").html(contenido_ajax);
                                      
            }
        });
    }
    listarVoucherPago(id){
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_pagos.php",
            type: "GET",
            data: {consulta: "buscar", idcredito:id},
            beforeSend: function(){
                $("#load_data_modal_pagos").html('');
                $("#load_table_modal2").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.monto}</td>
                                    `;

                    if(datos.tipo_vp=="" || datos.tipo_vp==null){
                        contenido_ajax += `
                                                <td>PAGO</td>
                        `;
                    }else{
                        contenido_ajax += `
                            <td>${datos.tipo_vp}</td>
                        `;
                    }
                    
                                                
                    contenido_ajax += `
                                                <td>${datos.fecha}</td>
                                                <td><button type="button" class="btn btn-primary" onclick='btn_pago_print("voucher",${datos.id});'><i class="fas fa-lg fa-ticket-alt"></i></button></td>
                                            </tr>
                                    `;                      
                });
            
                $("#load_table_modal2").html('');
                $("#load_data_modal_pagos").html(contenido_ajax);
                                      
            }
        }); 
    }
    listarVoucherPagoCondonacion(id){
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_pagos.php",
            type: "GET",
            data: {consulta: "buscar", idcredito:id},
            beforeSend: function(){
                $("#load_data_modal_pagos-c").html('');
                $("#load_table_modal2-c").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.monto}</td>
                                    `;

                    if(datos.tipo_vp=="" || datos.tipo_vp==null){
                        contenido_ajax += `
                                                <td>PAGO</td>
                        `;
                    }else{
                        contenido_ajax += `
                            <td>${datos.tipo_vp}</td>
                        `;
                    }
                    
                                                
                    contenido_ajax += `
                                                <td>${datos.fecha}</td>
                                                <td><button type="button" class="btn btn-primary" onclick='btn_pago_print("voucher",${datos.id});'><i class="fas fa-lg fa-ticket-alt"></i></button></td>
                                            </tr>
                                    `;                      
                });
            
                $("#load_table_modal2-c").html('');
                $("#load_data_modal_pagos-c").html(contenido_ajax);
                                      
            }
        }); 
    }

    buscarCliente(clave){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_cliente.php",
            type: "GET",
            data: {clave: clave},
            success: function(response){
                var resultados = JSON.parse(response);
                $("#clientes").html("");
                //console.log(resultados);    
            
                resultados.forEach( resultados => {
                    $("#clientes").append(`
                        <option data-id="${resultados.id}" value="${resultados.nombre + ' ' + resultados.apellido_pat + ' ' + resultados.apellido_mat}"></option>
                    `);

                });  
            }
        });
    }
    buscarConyugue(clave){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_conyugue.php",
            type: "GET",
            data: {clave: clave, idcliente: $('#inputCLIENT-hidden').val()},
            success: function(response){
                var resultados = JSON.parse(response);
                $("#conyugue-list-ajax").html("");
                //console.log(resultados);    
            
                resultados.forEach( resultados => {
                    $("#conyugue-list-ajax").append(`
                        <option data-id="${resultados.id}" value="${resultados.nombre + ' ' + resultados.apellido_pat + ' ' + resultados.apellido_mat}"></option>
                    `);

                });  
            }
        });
    }
    buscarAval(clave){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_aval.php",
            type: "GET",
            data: {clave: clave, idcliente: $('#inputCLIENT-hidden').val()},
            success: function(response){
                var resultados = JSON.parse(response);
                $("#aval-list-ajax").html("");
                //console.log(resultados);    
            
                resultados.forEach( resultados => {
                    $("#aval-list-ajax").append(`
                        <option data-id="${resultados.id}" value="${resultados.nombre + ' ' + resultados.apellido_pat + ' ' + resultados.apellido_mat}"></option>
                    `);

                });  
            }
        });
    }
    buscarUsuario(){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_asesor.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
        
                if(datos!="" && datos!=null){
                    $("#inputASES").removeClass("is-invalid");
                    $("#inputASES").addClass("is-valid");
                    $("#inputASES-hidden").val(datos[0].idusuario);
                    $("#inputASES").val(datos[0].nombre + " " + datos[0].apellido_pat + " " + datos[0].apellido_mat);
                }else{
                    $("#inputASES").removeClass("is-valid");
                    $("#inputASES").addClass("is-invalid");
                }
            }
        });
    }
    buscarAdmin(){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_admin.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
        
                if(datos!="" && datos!=null){
                    $("#inputADMIN").removeClass("is-invalid");
                    $("#inputADMIN").addClass("is-valid");
                    $("#inputADMIN-hidden").val(datos[0].idadm);
                    $("#inputADMIN").val(datos[0].nombre + " " + datos[0].apellido_pat + " " + datos[0].apellido_mat);
                }else{
                    $("#inputADMIN").removeClass("is-valid");
                    $("#inputADMIN").addClass("is-invalid");
                }
            }
        });
    }
    buscarCaja(){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_caja.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
        
                if(datos!="" && datos!=null){
                    $("#inputCAJA").removeClass("is-invalid");
                    $("#inputCAJA").addClass("is-valid");
                    $("#inputCAJA-hidden").val(datos[0].idcaja);
                    $("#inputCAJA").val(datos[0].nombre + " " + datos[0].apellido_pat + " " + datos[0].apellido_mat);
                }else{
                    $("#inputCAJA").removeClass("is-valid");
                    $("#inputCAJA").addClass("is-invalid");
                }
            }
        });
    }
    buscarResponsable(){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_caja.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
        
                if(datos!="" && datos!=null){
                    $("#inputCAJA-c").removeClass("is-invalid");
                    $("#inputCAJA-c").addClass("is-valid");
                    $("#inputCAJA-hidden-c").val(datos[0].idcaja);
                    $("#inputCAJA-c").val(datos[0].nombre + " " + datos[0].apellido_pat + " " + datos[0].apellido_mat);
                }else{
                    $("#inputCAJA-c").removeClass("is-valid");
                    $("#inputCAJA-c").addClass("is-invalid");
                }
            }
        });
    }

    buscar_cliente_cobranza(clave){
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_buscar_cliente.php",
            type: "GET",
            data: {clave: clave},
            beforeSend: function(){
                $("#load_data_cobranza").html('');
                $("#load_table_cobranza").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var resultados = JSON.parse(response);
                //console.log(resultados);    
                // $("#load_data_cobranza").html("");
                var cont = 0;
                var ajax_cont;

                resultados.forEach( resultados => {
                    cont ++;

                    ajax_cont += `
                                <tr>
                                    <th scope="row">${cont}</th>
                                    <td>${resultados.nombre + " " + resultados.apellido_pat + " " + resultados.apellido_mat}</td>
                                    <td>S/.${resultados.monto_aprob}</td>
                                    <td>S/.${resultados.deuda}</td>
                                `;
                    
                    if(resultados.mora==null || resultados.mora==""){
                        ajax_cont += `<td></td>`;
                    }else{
                        ajax_cont += `<td>S/.${resultados.mora}</td>`;
                    }

                    if(resultados.pagado==null || resultados.pagado==""){
                        ajax_cont += `<td></td>`;
                    }else{
                        ajax_cont += `<td>S/.${resultados.pagado}</td>`;
                    }
                        
                    if(resultados.user_privilegios=="ROOT"){
                        ajax_cont += `   
                                <td>
                                    <div class="col text-center"> 
                                        <button style="width:160px;" type="button" class="btn btn-primary" onClick="btn_edit_cobranza(${resultados.idcredito},${resultados.idcliente});"><i class="fas fa-lg fa-donate"></i> Registrar Pago</button>
                                        <button style="width:180px;" type="button" class="btn btn-danger" onClick="btn_condonar_cobranza(${resultados.idcredito},${resultados.idcliente});"><i class="fas fa-lg fa-stamp"></i> Condonar Deuda</button>
                                        <!--<button style="width:110px;" type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                    </div>
                                </td>
                            </tr>
                        `;
                    }else{
                        ajax_cont += `   
                                <td>
                                    <div class="col text-center"> 
                                        <button style="width:160px;" type="button" class="btn btn-primary" onClick="btn_edit_cobranza(${resultados.idcredito},${resultados.idcliente});"><i class="fas fa-lg fa-donate"></i> Registrar Pago</button>
                                        <!--<button style="width:110px;" type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                    
                           
                });  

                $("#load_table_cobranza").html('');
                $("#load_data_cobranza").html(ajax_cont);

            }
        });
    }
    buscar_cliente_cobranza_refresh(clave){
        
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_buscar_cliente_refresh.php",
            type: "GET",
            data: {clave: clave},
            success: function(response){
                var resultados = JSON.parse(response);
                console.log(resultados);    
               // $("#load_data_cobranza").html("");
                var cont = 0;
                var ajax_cont = "";

                resultados.forEach( resultados => {
                    cont ++;

                    ajax_cont += `
                                <tr>
                                    <th scope="row">${cont}</th>
                                    <td>${resultados.nombre + " " + resultados.apellido_pat + " " + resultados.apellido_mat}</td>
                                    <td>S/.${resultados.monto_aprob}</td>
                                    <td>S/.${resultados.deuda}</td>
                                `;
                    
                    if(resultados.mora==null || resultados.mora==""){
                        ajax_cont += `<td></td>`;
                    }else{
                        ajax_cont += `<td>S/.${resultados.mora}</td>`;
                    }

                    if(resultados.pagado==null || resultados.pagado==""){
                        ajax_cont += `<td></td>`;
                    }else{
                        ajax_cont += `<td>S/.${resultados.pagado}</td>`;
                    }
                        
                    if(resultados.user_privilegios=="ROOT"){
                        ajax_cont += `   
                                <td>
                                    <div class="col text-center"> 
                                        <button style="width:160px;" type="button" class="btn btn-primary" onClick="btn_edit_cobranza(${resultados.idcredito},${resultados.idcliente});"><i class="fas fa-lg fa-donate"></i> Registrar Pago</button>
                                        <button style="width:180px;" type="button" class="btn btn-danger" onClick="btn_condonar_cobranza(${resultados.idcredito},${resultados.idcliente});"><i class="fas fa-lg fa-stamp"></i> Condonar Deuda</button>
                                        <!--<button style="width:110px;" type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                    </div>
                                </td>
                            </tr>
                        `;
                    }else{
                        ajax_cont += `   
                                <td>
                                    <div class="col text-center"> 
                                        <button style="width:160px;" type="button" class="btn btn-primary" onClick="btn_edit_cobranza(${resultados.idcredito},${resultados.idcliente});"><i class="fas fa-lg fa-donate"></i> Registrar Pago</button>
                                        <!--<button style="width:110px;" type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                    
                           
                }); 

                if(resultados=="" || resultados==null){
                    ajax_cont = "";
                    console.log("blanco")
                }

                $("#load_data_cobranza").html(ajax_cont);

            }
        });
    }
    buscar_cliente_cobranza_autocomplete(clave){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_cliente_id.php",
            type: "GET",
            data: {clave: clave},
            success: function(response){
                var resultados = JSON.parse(response);
                //console.log(resultados[0].nombre);    
                $("#inputCLIENT").addClass("is-valid");
                $("#inputCLIENT").val(resultados[0].nombre + " " + resultados[0].apellido_pat + " " + resultados[0].apellido_mat);
                $("#inputCLIENT-hidden").val(resultados[0].id);
              
            }
        });
    }
    buscar_cliente_condonacion_autocomplete(clave){
        $.ajax({
            url: "../backend/panel/creditos/ajax_buscar_cliente_id.php",
            type: "GET",
            data: {clave: clave},
            success: function(response){
                var resultados = JSON.parse(response);
                //console.log(resultados[0].nombre);    
                $("#inputCLIENT-c").addClass("is-valid");
                $("#inputCLIENT-c").val(resultados[0].nombre + " " + resultados[0].apellido_pat + " " + resultados[0].apellido_mat);
                $("#inputCLIENT-hidden-c").val(resultados[0].id);
              
            }
        });
    }

    buscarCuota(idpago){

        this.idEdit = idpago;

        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_cuota.php",
            type: "GET",
            data: {idpago: idpago},
            success: function(response){
                var resultados = JSON.parse(response);
                //console.log(resultados[0]);    
               
                $("#pago_monto").val(resultados[0].cuota_programada);
                $("#pago_vencimiento").val(resultados[0].fecha_programada);

                if(resultados[0].mora==null || resultados[0].mora==""){
                    $("#pago_mora").val(0);
                    $("#pago_total").val(parseFloat(resultados[0].cuota_programada) + 0);
                }else{
                    $("#pago_mora").val(resultados[0].mora);
                    $("#pago_total").val(parseFloat(resultados[0].cuota_programada) + parseFloat(resultados[0].mora));
                }
         
              
            }
        });
    }
   


    registrarSolicitud(){ 

        

        $.ajax({
            type: 'POST',
            url: '../backend/panel/creditos/solicitudes/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    console.log("registrado");
                    setTimeout(()=>{
                        credito.listarSolicitudes();
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        credito.idEdit = 0;
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }
    

    editar(id){
        document.getElementById("formulario-solicitud").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Modificar Solicitud");
        
        $.ajax({
            url: "../backend/panel/creditos/solicitudes/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                

                $("#inputASES").removeClass("is-invalid");
                $("#inputASES").addClass("is-valid");
                $("#inputCLIENT").removeClass("is-invalid");
                $("#inputCLIENT").addClass("is-valid");

                $('#inputASES').val(datos[0].usu_nombre + " " + datos[0].usu_apellido_pat + " " + datos[0].usu_apellido_mat);
                $('#inputASES-hidden').val(datos[0].idusuario);
                $('#inputCLIENT').val(datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat);
                $('#inputCLIENT-hidden').val(datos[0].idcliente);

               
                

                if(datos[0].idconyugue==null || datos[0].idconyugue==""){
                    $("#inputCONY").prop('checked',false);
                }else{
                    $("#inputCONY").prop('checked',true);
                    $('#inputCONY_AJAX').val(datos[0].con_nombre + " " + datos[0].con_apellido_pat + " " + datos[0].con_apellido_mat);
                    $('#inputCONY_AJAX-hidden').val(datos[0].idconyugue);
                    $("#inputCONY_AJAX").removeAttr("readonly");
                    $("#inputCONY_AJAX").addClass("is-valid");
                }
                if(datos[0].idaval==null || datos[0].idaval==""){
                    $("#inputAVAL").prop('checked',false);
                }else{
                    $("#inputAVAL").prop('checked',true);
                    $('#inputAVAL_AJAX').val(datos[0].ava_nombre + " " + datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat);
                    $('#inputAVAL_AJAX-hidden').val(datos[0].idaval);
                    $("#inputAVAL_AJAX").removeAttr("readonly");
                    $("#inputAVAL_AJAX").addClass("is-valid");
                }

                $("#sol_NEGOCIO").val(datos[0].negocio);
               

                $('#sol_MONTO').val(datos[0].monto_prop);
                $('#sol_MONTO_APRO').val(datos[0].monto_aprob);
                $('#sol_CUOTAS').val(datos[0].n_cuotas);
                $('#sol_CUOTAS_APRO').val(datos[0].n_cuotas_aprob);
                $('#sol_INTERES').val(datos[0].interes);
                $('#sol_INTERES_APRO').val(datos[0].interes_aprob);
                $('#sol_FRECUENCIA').val(datos[0].frecuencia);
                $('#sol_INICIO').val(datos[0].fecha_inicio);

                $('#sol_cal_CUOTAS').val(datos[0].m_cuotas);
                $('#sol_cal_CUOTAS_APRO').val(datos[0].m_cuotas_aprob);
                $('#sol_cal_INTERES').val(datos[0].m_interes);
                $('#sol_cal_INTERES_APRO').val(datos[0].m_interes_aprob);
                $('#sol_cal_TOTAL').val(datos[0].m_total);
                $('#sol_cal_TOTAL_APRO').val(datos[0].m_total_aprob);
             
                
                
                

                if(datos[0].estado=='REGISTRADO'){
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-primary btn_modals" onclick="credito.preAprobar(${id},1);" style="width:220px"><i class="fas fa-lg fa-check"></i> Pre-aprobar Crédito</button>
                        <button type="button" class="btn btn-danger btn_modals" style="width:140px;" onClick='credito.eliminarSolicitud(${datos[0].idsolicitud});'><i class="fas fa-trash-alt"></i> Eliminar</button>
                    `);
                }

                if(datos[0].estado=='REGISTRADO' || datos[0].estado=='PREAPROBADO'){
                    solicitud_monto = datos[0].monto_prop;
                    solicitud_cuotas = datos[0].n_cuotas;
                    solicitud_frecuencia = datos[0].frecuencia;
                    solicitud_interes = datos[0].interes;
                    solicitud_inicio = datos[0].fecha_inicio;
                    solicitud_calendario();
                }else{
                    solicitud_monto = datos[0].monto_aprob;
                    solicitud_cuotas = datos[0].n_cuotas_aprob;
                    solicitud_frecuencia = datos[0].frecuencia;
                    solicitud_interes = datos[0].interes_aprob;
                    solicitud_inicio = datos[0].fecha_inicio;
                    solicitud_calendario_adm();
                }

            }
        });
    }
    editarAprobacion(id){
        document.getElementById("formulario-aprobacion").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Aprobar/Desaprobar solicitud de Crédito");
        
        $.ajax({
            url: "../backend/panel/creditos/aprobaciones/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                
                $("#inputADMIN").removeClass("is-invalid");
                $("#inputADMIN").addClass("is-valid");
                $("#inputASES").removeClass("is-invalid");
                $("#inputASES").addClass("is-valid");
                $("#inputCLIENT").removeClass("is-invalid");
                $("#inputCLIENT").addClass("is-valid");

                
                $('#inputASES').val(datos[0].usu_ases_nombre + " " + datos[0].usu_ases_apellido_pat + " " + datos[0].usu_ases_apellido_mat);
                $('#inputASES-hidden').val(datos[0].idases);
                $('#inputCLIENT').val(datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat);
                $('#inputCLIENT-hidden').val(datos[0].idcliente);

               
                

                if(datos[0].idconyugue==null || datos[0].idconyugue==""){
                    $("#inputCONY").prop('checked',false);
                }else{
                    $("#inputCONY").prop('checked',true);
                    $('#inputCONY_AJAX').val(datos[0].con_nombre + " " + datos[0].con_apellido_pat + " " + datos[0].con_apellido_mat);
                    $('#inputCONY_AJAX-hidden').val(datos[0].idconyugue);
                    $("#inputCONY_AJAX").attr("readonly","readonly");
                    $("#inputCONY_AJAX").addClass("is-valid");
                }
                if(datos[0].idaval==null || datos[0].idaval==""){
                    $("#inputAVAL").prop('checked',false);
                }else{
                    $("#inputAVAL").prop('checked',true);
                    $('#inputAVAL_AJAX').val(datos[0].ava_nombre + " " + datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat);
                    $('#inputAVAL_AJAX-hidden').val(datos[0].idaval);
                    $("#inputAVAL_AJAX").attr("readonly","readonly");
                    $("#inputAVAL_AJAX").addClass("is-valid");
                }

                $("#sol_NEGOCIO").val(datos[0].negocio);

                $('#sol_MONTO').val(datos[0].monto_prop);
                $('#sol_MONTO_APRO').val(datos[0].monto_aprob);
                $('#sol_CUOTAS').val(datos[0].n_cuotas);
                $('#sol_CUOTAS_APRO').val(datos[0].n_cuotas_aprob);
                $('#sol_INTERES').val(datos[0].interes);
                $('#sol_INTERES_APRO').val(datos[0].interes_aprob);
                $('#sol_FRECUENCIA').val(datos[0].frecuencia);
                $('#sol_INICIO').val(datos[0].fecha_inicio);

                $('#sol_cal_CUOTAS').val(datos[0].m_cuotas);
                $('#sol_cal_CUOTAS_APRO').val(datos[0].m_cuotas_aprob);
                $('#sol_cal_INTERES').val(datos[0].m_interes);
                $('#sol_cal_INTERES_APRO').val(datos[0].m_interes_aprob);
                $('#sol_cal_TOTAL').val(datos[0].m_total);
                $('#sol_cal_TOTAL_APRO').val(datos[0].m_total_aprob);
             
                
                solicitud_monto = datos[0].monto_prop;
                solicitud_cuotas = datos[0].n_cuotas;
                solicitud_frecuencia = datos[0].frecuencia;
                solicitud_interes = datos[0].interes;
                solicitud_inicio = datos[0].fecha_inicio;
                solicitud_calendario();

                if(datos[0].estado=='PREAPROBADO'){
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-primary btn_modals" onclick="credito.aprobar(${id},1);" style="width:180px"><i class="fas fa-lg fa-check-double"></i> Aprobar Crédito</button>
                        <button type="button" class="btn btn-danger btn_modals" onclick="credito.aprobar(${id},0);" style="width:200px"><i class="fas fa-lg fa-window-close"></i> Desaprobar Crédito</button>
                    `);
                }

                

            }
        });
    }
    editarDesembolso(id){
        document.getElementById("formulario-desembolso").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Desembolsar Crédito");
        
        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                
                
                $("#inputADMIN").removeClass("is-invalid");
                $("#inputADMIN").addClass("is-valid");
                $("#inputASES").removeClass("is-invalid");
                $("#inputASES").addClass("is-valid");
                $("#inputCLIENT").removeClass("is-invalid");
                $("#inputCLIENT").addClass("is-valid");


                $('#inputADMIN').val(datos[0].usu_adm_nombre + " " + datos[0].usu_adm_apellido_pat + " " + datos[0].usu_adm_apellido_mat);
                $('#inputAADMIN-hidden').val(datos[0].idadm);
                $('#inputASES').val(datos[0].usu_ases_nombre + " " + datos[0].usu_ases_apellido_pat + " " + datos[0].usu_ases_apellido_mat);
                $('#inputASES-hidden').val(datos[0].idases);
                $('#inputCLIENT').val(datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat);
                $('#inputCLIENT-hidden').val(datos[0].idcliente);

               
                

                if(datos[0].idconyugue==null || datos[0].idconyugue==""){
                    $("#inputCONY").prop('checked',false);
                }else{
                    $("#inputCONY").prop('checked',true);
                    $('#inputCONY_AJAX').val(datos[0].con_nombre + " " + datos[0].con_apellido_pat + " " + datos[0].con_apellido_mat);
                    $('#inputCONY_AJAX-hidden').val(datos[0].idconyugue);
                    $("#inputCONY_AJAX").attr("readonly","readonly");
                    $("#inputCONY_AJAX").addClass("is-valid");
                }
                if(datos[0].idaval==null || datos[0].idaval==""){
                    $("#inputAVAL").prop('checked',false);
                }else{
                    $("#inputAVAL").prop('checked',true);
                    $('#inputAVAL_AJAX').val(datos[0].ava_nombre + " " + datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat);
                    $('#inputAVAL_AJAX-hidden').val(datos[0].idaval);
                    $("#inputAVAL_AJAX").attr("readonly","readonly");
                    $("#inputAVAL_AJAX").addClass("is-valid");
                }


                $('#sol_MONTO').val(datos[0].monto_aprob);
                //$('#sol_MONTO_APRO').val(datos[0].monto_aprob);
                $('#sol_CUOTAS').val(datos[0].n_cuotas_aprob);
                //$('#sol_CUOTAS_APRO').val(datos[0].n_cuotas_aprob);
                $('#sol_INTERES').val(datos[0].interes_aprob);
                //$('#sol_INTERES_APRO').val(datos[0].interes_aprob);
                $('#sol_FRECUENCIA').val(datos[0].frecuencia);
                $('#sol_INICIO').val(datos[0].fecha_inicio);

                $('#sol_cal_CUOTAS').val(datos[0].m_cuotas_aprob);
                //$('#sol_cal_CUOTAS_APRO').val(datos[0].m_cuotas_aprob);
                $('#sol_cal_INTERES').val(datos[0].m_interes_aprob);
                //$('#sol_cal_INTERES_APRO').val(datos[0].m_interes_aprob);
                $('#sol_cal_TOTAL').val(datos[0].m_total_aprob);
                //$('#sol_cal_TOTAL_APRO').val(datos[0].m_total_aprob);
             
                
                solicitud_monto = datos[0].monto_aprob;
                solicitud_cuotas = datos[0].n_cuotas_aprob;
                solicitud_frecuencia = datos[0].frecuencia;
                solicitud_interes = datos[0].interes_aprob;
                solicitud_inicio = datos[0].fecha_inicio;
                solicitud_calendario();

                if(datos[0].estado=='APROBADO'){
                    $(".modal-btn-cont").html(`
                        <button type="submit" class="btn btn-success btn_modals" style="width:200px"><i class="fas fa-lg fa-coins"></i> Desembolsar</button>
                        <button type="button" class="btn btn-danger btn_modals" onclick="credito.desembolsar(${id},0);" style="width:220px"><i class="fas fa-lg fa-times-circle"></i> Remover desembolso</button>
                    `);
                }

                
            }
        });
    }
    editarExtorno(id){
        document.getElementById("formulario-desembolso").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Extornar Desembolso");
        
        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                
                
                $("#inputADMIN").removeClass("is-invalid");
                $("#inputADMIN").addClass("is-valid");
                $("#inputASES").removeClass("is-invalid");
                $("#inputASES").addClass("is-valid");
                $("#inputCLIENT").removeClass("is-invalid");
                $("#inputCLIENT").addClass("is-valid");


                $('#inputADMIN').val(datos[0].usu_adm_nombre + " " + datos[0].usu_adm_apellido_pat + " " + datos[0].usu_adm_apellido_mat);
                $('#inputAADMIN-hidden').val(datos[0].idadm);
                $('#inputASES').val(datos[0].usu_ases_nombre + " " + datos[0].usu_ases_apellido_pat + " " + datos[0].usu_ases_apellido_mat);
                $('#inputASES-hidden').val(datos[0].idases);
                $('#inputCLIENT').val(datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat);
                $('#inputCLIENT-hidden').val(datos[0].idcliente);

               
                

                if(datos[0].idconyugue==null || datos[0].idconyugue==""){
                    $("#inputCONY").prop('checked',false);
                }else{
                    $("#inputCONY").prop('checked',true);
                    $('#inputCONY_AJAX').val(datos[0].con_nombre + " " + datos[0].con_apellido_pat + " " + datos[0].con_apellido_mat);
                    $('#inputCONY_AJAX-hidden').val(datos[0].idconyugue);
                    $("#inputCONY_AJAX").attr("readonly","readonly");
                    $("#inputCONY_AJAX").addClass("is-valid");
                }
                if(datos[0].idaval==null || datos[0].idaval==""){
                    $("#inputAVAL").prop('checked',false);
                }else{
                    $("#inputAVAL").prop('checked',true);
                    $('#inputAVAL_AJAX').val(datos[0].ava_nombre + " " + datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat);
                    $('#inputAVAL_AJAX-hidden').val(datos[0].idaval);
                    $("#inputAVAL_AJAX").attr("readonly","readonly");
                    $("#inputAVAL_AJAX").addClass("is-valid");
                }


                $('#sol_MONTO').val(datos[0].monto_aprob);
                //$('#sol_MONTO_APRO').val(datos[0].monto_aprob);
                $('#sol_CUOTAS').val(datos[0].n_cuotas_aprob);
                //$('#sol_CUOTAS_APRO').val(datos[0].n_cuotas_aprob);
                $('#sol_INTERES').val(datos[0].interes_aprob);
                //$('#sol_INTERES_APRO').val(datos[0].interes_aprob);
                $('#sol_FRECUENCIA').val(datos[0].frecuencia);
                $('#sol_INICIO').val(datos[0].fecha_inicio);

                $('#sol_cal_CUOTAS').val(datos[0].m_cuotas_aprob);
                //$('#sol_cal_CUOTAS_APRO').val(datos[0].m_cuotas_aprob);
                $('#sol_cal_INTERES').val(datos[0].m_interes_aprob);
                //$('#sol_cal_INTERES_APRO').val(datos[0].m_interes_aprob);
                $('#sol_cal_TOTAL').val(datos[0].m_total_aprob);
                //$('#sol_cal_TOTAL_APRO').val(datos[0].m_total_aprob);
             
                
                solicitud_monto = datos[0].monto_aprob;
                solicitud_cuotas = datos[0].n_cuotas_aprob;
                solicitud_frecuencia = datos[0].frecuencia;
                solicitud_interes = datos[0].interes_aprob;
                solicitud_inicio = datos[0].fecha_inicio;
                solicitud_calendario();

                if(datos[0].estado=='DESEMBOLSADO'){
                    $(".modal-btn-cont").html(`
                        <button style="width:140px;" type="button" class="btn btn-danger btn_modals" onclick='credito.extornar(${datos[0].iddesembolso});'><i class="fas fa-lg fa-history"></i> Extornar</button>
                    `);
                }

                
            }
        });
    }
    editarCobranza(idcredito,idcliente){
  
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Modulo de Cobranza");
            
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", idcredito: idcredito},
            beforeSend: function(){
                $("#load_data_modal").html('');
                $("#load_table_modal1").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                $("#pago_n_cuota").html('');
                $("#load_data_modal").html('');
                //console.log(datos)

                //var cont_ajax_01 = "<option value='' disabled selected>--Seleccionar--</option>";
                var cont_ajax_02;

                datos.forEach( datos => {

                    //cont_ajax_01 += `<option value="${datos.idpago}">${datos.n_cuota_programada}</option>`;


                    cont_ajax_02 += `
                                    <tr>
                                        <th scope="row">${datos.n_cuota_programada}</th>
                                        <td>${datos.fecha_programada}</td>
                                        <td>S/.${datos.cuota_programada}</td>
                                    `;

                    if(datos.mora==null || datos.mora==""){
                        cont_ajax_02 += `<td></td>`;
                    }else{
                        cont_ajax_02 += `<td>S/.${datos.mora}</td>`;
                    }

                    cont_ajax_02 += `<td class="font-weight-bold font-italic">S/.${datos.deuda}</td>`;


                    if(datos.monto==null || datos.monto==""){
                        cont_ajax_02 += `
                                        <td></td>
                                        <td></td>
                                        `;
                    }else{
                        cont_ajax_02 += `
                                        <td class="font-weight-bold font-italic">S/.${Math.ceil10(datos.monto,-1)}</td>
                                        <td>${datos.fecha}</td>
                                        `;
                    }

                    /*
                    if(datos.monto==null || datos.monto==""){
                        cont_ajax_02 += `
                                            <td></td>
                                        </tr>
                        `;
                    }else{
                        cont_ajax_02 += `
                                            <td><button type="button" class="btn btn-primary" onclick='btn_pago_print("voucher",${datos.idpago});'><i class="fas fa-lg fa-ticket-alt"></i></button></td>
                                        </tr>
                                            `;
                    }
                    */
                    

                });

                //$("#pago_n_cuota").html(cont_ajax_01);
                $("#load_table_modal1").html('');
                $("#load_data_modal").html(cont_ajax_02);
              
             
                
        

                
            }
        });
          
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_deuda.php",
            type: "GET",
            data: {consulta: "editar", idcredito: idcredito},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $("#pago_deuda").val(datos[0].deuda_credito);
                $("#pago_pagado").val(datos[0].pagado);
                $("#pago_mora").val(datos[0].deuda_moras);
                $("#pago_d_total").val(datos[0].deuda_total);

            }
        });
    
    }
    editarCondonacion(idcredito,idcliente){
  
        $('#modal-condonar').modal('show'); 
        $('#modal-condonar h4').html("Modulo de Condonaciones");
            
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", idcredito: idcredito},
            beforeSend: function(){
                $("#load_data_modal-c").html('');
                $("#load_table_modal1-c").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                $("#pago_n_cuota-c").html('');
                $("#load_data_modal-c").html('');
                //console.log(datos)

                var cont_ajax_02;

                datos.forEach( datos => {

                    cont_ajax_02 += `
                                    <tr>
                                        <th scope="row">${datos.n_cuota_programada}</th>
                                        <td>${datos.fecha_programada}</td>
                                        <td>S/.${datos.cuota_programada}</td>
                                    `;

                    if(datos.mora==null || datos.mora==""){
                        cont_ajax_02 += `<td></td>`;
                    }else{
                        cont_ajax_02 += `<td>S/.${datos.mora}</td>`;
                    }

                    cont_ajax_02 += `<td class="font-weight-bold font-italic">S/.${datos.deuda}</td>`;


                    if(datos.monto==null || datos.monto==""){
                        cont_ajax_02 += `
                                        <td></td>
                                        <td></td>
                                        `;
                    }else{
                        cont_ajax_02 += `
                                        <td class="font-weight-bold font-italic">S/.${datos.monto}</td>
                                        <td>${datos.fecha}</td>
                                        `;
                    }
          

                });

                $("#load_table_modal1-c").html('');
                $("#load_data_modal-c").html(cont_ajax_02);
              
             
                
        

                
            }
        });
          
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_deuda.php",
            type: "GET",
            data: {consulta: "editar", idcredito: idcredito},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $("#pago_deuda-c").val(datos[0].deuda_credito);
                $("#pago_pagado-c").val(datos[0].pagado);
                $("#pago_mora-c").val(datos[0].deuda_moras);
                $("#pago_d_total-c").val(datos[0].deuda_total);
                $("#pago_monto-c").val(datos[0].deuda_total);
            }
        });
    
    }

    editarSaveSolicitud(id){

        this.formulario.append("id",id);   

        $.ajax({
            url: "../backend/panel/creditos/solicitudes/ajax_editar.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Actualización Correcta!
                            </div>
                        `);
                        setTimeout(()=>{
                            credito.listarSolicitudes();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            credito.idEdit = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }
    editarSaveAprobacion(id){

        this.formulario.append("id",id);   

        $.ajax({
            url: "../backend/panel/creditos/aprobaciones/ajax_editar.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Actualización Correcta!
                            </div>
                        `);
                        setTimeout(()=>{
                            credito.listarAprobaciones();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            credito.idEdit = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }
    

    preAprobar(id,operacion){

        $.ajax({
            url: "../backend/panel/creditos/solicitudes/ajax_preaprobar.php",
            type: "POST",
            data: {
                id: id, 
                operacion:operacion,
                inputASES_hidden: $("#inputASES-hidden").val(),
                inputCLIENT_hidden: $("#inputCLIENT-hidden").val(),
                inputCONY_AJAX_hidden: $("#inputCONY_AJAX-hidden").val(),
                inputAVAL_AJAX_hidden: $("#inputAVAL_AJAX-hidden").val(),
                sol_MONTO: $("#sol_MONTO").val(),
                sol_CUOTAS: $("#sol_CUOTAS").val(),
                sol_INTERES: $("#sol_INTERES").val(),
                sol_FRECUENCIA: $("#sol_FRECUENCIA").val(),
                sol_INICIO: $("#sol_INICIO").val(),
                sol_NEGOCIO: $("#sol_NEGOCIO").val(),
                sol_cal_CUOTAS: $("#sol_cal_CUOTAS").val(),
                sol_cal_INTERES: $("#sol_cal_INTERES").val(),
                sol_cal_TOTAL: $("#sol_cal_TOTAL").val()
            
            },
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        setTimeout(()=>{
                            credito.listarSolicitudes();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            credito.idEdit = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },700);
                    }else{
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }
    aprobar(id,operacion){  

        if(operacion){
            if($("#sol_MONTO_APRO").val()=="" || $("#sol_CUOTAS_APRO").val()=="" || $("#sol_INTERES_APRO").val()==""){
                $("#msg-ajax-result").html(`
                            <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                Completa los campos requeridos!
                            </div>
                `);
            }else{
                $.ajax({
                    url: "../backend/panel/creditos/aprobaciones/ajax_aprobar.php",
                    type: "POST",
                    data: {
                        id: id, 
                        operacion:operacion, 
                        idadm: $("#inputADMIN-hidden").val(),
                        monto_aprob: $("#sol_MONTO_APRO").val(),
                        n_cuotas_aprob: $("#sol_CUOTAS_APRO").val(),
                        interes_aprob: $("#sol_INTERES_APRO").val(),
                        total_cuotas_aprob: $("#sol_cal_CUOTAS_APRO").val(),
                        total_interes_aprob: $("#sol_cal_INTERES_APRO").val(),
                        total_total_aprob: $("#sol_cal_TOTAL_APRO").val()
                    },
                    beforeSend: function(){
                        $('.btn_modals').prop('disabled', true);
                        $("#msg-ajax-result").html(`
                            <div style="">
                                <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        `); 
                    },
                    success: function(response){
                            //console.log(response);
                            if(response==200){                      
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                        Se completo la operación!
                                    </div>
                                `);
                                setTimeout(()=>{
                                    credito.listarAprobaciones();
                                    $('#modal-add').modal('hide');
                                    $('.btn_modals').prop('disabled', false);
                                    credito.idEdit = 0;
                                    setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                                },700);
                            }else{
                                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                `+response+`
                                            </div>
                                `);
                            }   
                    },
                    timeout: 30000,
                    error: function(xhr, status){
                            $('.btn_modals').prop('disabled', false);
                            $("#msg-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                        </div>
                            `);
                            
                    }
                });
            }
        }else{
            $.ajax({
                url: "../backend/panel/creditos/aprobaciones/ajax_aprobar.php",
                type: "POST",
                data: {
                    id: id, 
                    operacion:operacion, 
                    idadm: $("#inputADMIN-hidden").val(),
                    monto_aprob: $("#sol_MONTO_APRO").val(),
                    n_cuotas_aprob: $("#sol_CUOTAS_APRO").val(),
                    interes_aprob: $("#sol_INTERES_APRO").val(),
                    total_cuotas_aprob: $("#sol_cal_CUOTAS_APRO").val(),
                    total_interes_aprob: $("#sol_cal_INTERES_APRO").val(),
                    total_total_aprob: $("#sol_cal_TOTAL_APRO").val()
                },
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#msg-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                        //console.log(response);
                        if(response==200){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Se completo la operación!
                                </div>
                            `);
                            setTimeout(()=>{
                                credito.listarAprobaciones();
                                $('#modal-add').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                credito.idEdit = 0;
                                setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                            },700);
                        }else{
                            $("#msg-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            `+response+`
                                        </div>
                            `);
                        }   
                },
                timeout: 30000,
                error: function(xhr, status){
                        $('.btn_modals').prop('disabled', false);
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                    </div>
                        `);
                        
                }
            });
        }
    }
    desembolsar(id,operacion){
        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_desembolso.php",
            type: "POST",
            data: {
                id: id, 
                operacion:operacion, 
                idcaja: $("#inputCAJA-hidden").val(),
                movimiento_caja: $("#movimiento_caja").val(),
                sol_MONTO: $("#sol_MONTO").val(),
                idcliente: $("#inputCLIENT-hidden").val()
            },
            
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);

                    if(response==200){ 

                        if(operacion){
                            solicitud_calendario_pagos(id); 
                        }else{
                            setTimeout(()=>{
                                $('#modal-add').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                $("#msg-ajax-result").html("");
                            },1000);
                        }
                                            

                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);

                        credito.listarDesembolsos();
                        credito.idEdit = 0;
                        
                    }else{
                        if(response=="600"){
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    No hay fondos suficientes en la Caja!.
                                </div>
                            `);
                            setTimeout(()=>{
                                $('.btn_modals').prop('disabled', false);
                            },1000);

                        }else{
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                        
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }
    cobranza(id){
        this.formulario.append("id",id);   

        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_cobranza.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Se registro el pago correctamente!
                            </div>
                        `);
                        credito.terminarCredito(id,$("#inputCLIENT-hidden").val());
                        setTimeout(()=>{
                            //credito.buscar_cliente_cobranza_refresh($("#inputCLIENT-hidden").val());
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            credito.idEdit = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
            },
            timeout: 30000,
            error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
            }
        });
    }
    condonar(id){
        this.formulario.append("id",id);   

        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_condonar.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result-c").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result-c").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Se hizo la condonación de deuda correctamente!
                            </div>
                        `);
                       
                        setTimeout(()=>{
                            credito.buscar_cliente_cobranza_refresh($("#inputCLIENT-hidden-c").val());
                            $('#modal-condonar').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            credito.idEdit = 0;
                            setTimeout(()=>{$("#msg-ajax-result-c").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result-c").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result-c").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result-c").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
            },
            timeout: 30000,
            error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result-c").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
            }
        });
    }
    extornar(id){
        if($("#movimiento_caja").val()==null || $("#movimiento_caja").val()==""){
            $("#msg-ajax-result").html(`   
                <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                    Seleccione una Caja para realizar el Extorno del Desembolso.
                </div>     
            `); 
        }else{
            $.ajax({
                url: "../backend/panel/creditos/desembolsos/ajax_extornar.php",
                type: "POST",
                data: {
                    id: id,
                    movimiento_caja: $("#movimiento_caja").val(),
                    sol_MONTO: $("#sol_MONTO").val()
                },
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#msg-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                        //console.log(response);
                        if(response==200){ 
    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Se completo la operación!
                                </div>
                            `);
                            setTimeout(()=>{
                                $('#modal-add').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                $("#msg-ajax-result").html("");
                            },1000);
                                                
                            credito.listarDesembolsos();
                            credito.idEdit = 0;
                            
                        }else{
                            if(response=="600"){
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        No hay una Caja activa!.
                                    </div>
                                `);
                                setTimeout(()=>{
                                    $('.btn_modals').prop('disabled', false);
                                },1000);
    
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                            
                        }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                }
            });
        }

        
    }

    terminarCredito(id,idcli){
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_terminar_credito.php",
            type: "POST",
            data: {id:id},
            success: function(response){
                
                
                console.log(response)
                credito.buscar_cliente_cobranza_refresh(idcli); 
            },
            timeout: 30000,
            error: function(xhr, status){
                   
                    
            }
        });
    }
    

    verDetalles(id){
        document.getElementById("formulario-solicitud-view").reset();
        $('#modal-add-view').modal('show'); 
        $('#modal-add-view h4').html("Detalles de la Solicitud");
        
        $.ajax({
            url: "../backend/panel/creditos/solicitudes/ajax_ver_des.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                

                $("#inputASES-w").removeClass("is-invalid");
                $("#inputASES-w").addClass("is-valid");
                $("#inputCLIENT-w").removeClass("is-invalid");
                $("#inputCLIENT-w").addClass("is-valid");

                $('#inputASES-w').val(datos[0].usu_nombre + " " + datos[0].usu_apellido_pat + " " + datos[0].usu_apellido_mat);
                $('#inputASES-hidden-w').val(datos[0].idusuario);
                $('#inputCLIENT-w').val(datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat);
                $('#inputCLIENT-hidden-w').val(datos[0].idcliente);

               
                

                if(datos[0].idconyugue==null || datos[0].idconyugue==""){
                    $("#inputCONY-w").prop('checked',false);
                }else{
                    $("#inputCONY-w").prop('checked',true);
                    $('#inputCONY_AJAX-w').val(datos[0].con_nombre + " " + datos[0].con_apellido_pat + " " + datos[0].con_apellido_mat);
                    $('#inputCONY_AJAX-hidden-w').val(datos[0].idconyugue);
                    $("#inputCONY_AJAX-w").addClass("is-valid");
                }
                if(datos[0].idaval==null || datos[0].idaval==""){
                    $("#inputAVAL-w").prop('checked',false);
                }else{
                    $("#inputAVAL-w").prop('checked',true);
                    $('#inputAVAL_AJAX-w').val(datos[0].ava_nombre + " " + datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat);
                    $('#inputAVAL_AJAX-hidden-w').val(datos[0].idaval);
                    $("#inputAVAL_AJAX-w").addClass("is-valid");
                }

                $('#sol_NEGOCIO-w').val(datos[0].negocio);
                $('#sol_PREAPROB-w').val(datos[0].fecha_preaprob);
                
                $('#sol_MONTO-w').val(datos[0].monto_prop);
                $('#sol_MONTO_APRO-w').val(datos[0].monto_aprob);
                $('#sol_CUOTAS-w').val(datos[0].n_cuotas);
                $('#sol_CUOTAS_APRO-w').val(datos[0].n_cuotas_aprob);
                $('#sol_INTERES-w').val(datos[0].interes);
                $('#sol_INTERES_APRO-w').val(datos[0].interes_aprob);
                $('#sol_FRECUENCIA-w').val(datos[0].frecuencia);
                $('#sol_INICIO-w').val(datos[0].fecha_inicio);

                $('#sol_cal_CUOTAS-w').val(datos[0].m_cuotas);
                $('#sol_cal_CUOTAS_APRO-w').val(datos[0].m_cuotas_aprob);
                $('#sol_cal_INTERES-w').val(datos[0].m_interes);
                $('#sol_cal_INTERES_APRO-w').val(datos[0].m_interes_aprob);
                $('#sol_cal_TOTAL-w').val(datos[0].m_total);
                $('#sol_cal_TOTAL_APRO-w').val(datos[0].m_total_aprob);
             
                
               

                if(datos[0].estado=='REGISTRADO' || datos[0].estado=='PREAPROBADO'){
                    solicitud_monto = datos[0].monto_prop;
                    solicitud_cuotas = datos[0].n_cuotas;
                    solicitud_frecuencia = datos[0].frecuencia;
                    solicitud_interes = datos[0].interes;
                    solicitud_inicio = datos[0].fecha_inicio;
                    solicitud_calendario();
                }else{
                    solicitud_monto = datos[0].monto_aprob;
                    solicitud_cuotas = datos[0].n_cuotas_aprob;
                    solicitud_frecuencia = datos[0].frecuencia;
                    solicitud_interes = datos[0].interes_aprob;
                    solicitud_inicio = datos[0].fecha_inicio;
                    solicitud_calendario_adm();
                }


            }
        });
    }
    verDetallesADM(id){
        document.getElementById("formulario-aprobacion-view").reset();
        $('#modal-add-view').modal('show'); 
        $('#modal-add-view h4').html("Detalles de la Aprobación");
        
        $.ajax({
            url: "../backend/panel/creditos/aprobaciones/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $("#inputADMIN-w").removeClass("is-invalid");
                $("#inputADMIN-w").addClass("is-valid");
                $("#inputASES-w").removeClass("is-invalid");
                $("#inputASES-w").addClass("is-valid");
                $("#inputCLIENT-w").removeClass("is-invalid");
                $("#inputCLIENT-w").addClass("is-valid");

                $('#inputADMIN-w').val(datos[0].usu_adm_nombre + " " + datos[0].usu_adm_apellido_pat + " " + datos[0].usu_adm_apellido_mat);
                $('#inputAADMIN-hidden-w').val(datos[0].idadm);
                $('#inputASES-w').val(datos[0].usu_ases_nombre + " " + datos[0].usu_ases_apellido_pat + " " + datos[0].usu_ases_apellido_mat);
                $('#inputASES-hidden-w').val(datos[0].idases);
                $('#inputCLIENT-w').val(datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat);
                $('#inputCLIENT-hidden-w').val(datos[0].idcliente);

               
                

                if(datos[0].idconyugue==null || datos[0].idconyugue==""){
                    $("#inputCONY-w").prop('checked',false);
                }else{
                    $("#inputCONY-w").prop('checked',true);
                    $('#inputCONY_AJAX-w').val(datos[0].con_nombre + " " + datos[0].con_apellido_pat + " " + datos[0].con_apellido_mat);
                    $('#inputCONY_AJAX-hidden-w').val(datos[0].idconyugue);
                    $("#inputCONY_AJAX-w").attr("readonly","readonly");
                    $("#inputCONY_AJAX-w").addClass("is-valid");
                }
                if(datos[0].idaval==null || datos[0].idaval==""){
                    $("#inputAVAL-w").prop('checked',false);
                }else{
                    $("#inputAVAL-w").prop('checked',true);
                    $('#inputAVAL_AJAX-w').val(datos[0].ava_nombre + " " + datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat);
                    $('#inputAVAL_AJAX-hidden-w').val(datos[0].idaval);
                    $("#inputAVAL_AJAX-w").attr("readonly","readonly");
                    $("#inputAVAL_AJAX-w").addClass("is-valid");
                }


                $('#sol_MONTO-w').val(datos[0].monto_prop);
                $('#sol_MONTO_APRO-w').val(datos[0].monto_aprob);
                $('#sol_CUOTAS-w').val(datos[0].n_cuotas);
                $('#sol_CUOTAS_APRO-w').val(datos[0].n_cuotas_aprob);
                $('#sol_INTERES-w').val(datos[0].interes);
                $('#sol_INTERES_APRO-w').val(datos[0].interes_aprob);
                $('#sol_FRECUENCIA-w').val(datos[0].frecuencia);
                $('#sol_INICIO-w').val(datos[0].fecha_inicio);

                $('#sol_cal_CUOTAS-w').val(datos[0].m_cuotas);
                $('#sol_cal_CUOTAS_APRO-w').val(datos[0].m_cuotas_aprob);
                $('#sol_cal_INTERES-w').val(datos[0].m_interes);
                $('#sol_cal_INTERES_APRO-w').val(datos[0].m_interes_aprob);
                $('#sol_cal_TOTAL-w').val(datos[0].m_total);
                $('#sol_cal_TOTAL_APRO-w').val(datos[0].m_total_aprob);
             
                

                if(datos[0].estado=='REGISTRADO' || datos[0].estado=='PREAPROBADO'){
                    solicitud_monto = datos[0].monto_prop;
                    solicitud_cuotas = datos[0].n_cuotas;
                    solicitud_frecuencia = datos[0].frecuencia;
                    solicitud_interes = datos[0].interes;
                    solicitud_inicio = datos[0].fecha_inicio;
                    solicitud_calendario();
                }else{
                    solicitud_monto = datos[0].monto_aprob;
                    solicitud_cuotas = datos[0].n_cuotas_aprob;
                    solicitud_frecuencia = datos[0].frecuencia;
                    solicitud_interes = datos[0].interes_aprob;
                    solicitud_inicio = datos[0].fecha_inicio;
                    solicitud_calendario_adm();
                }



            }
        });
    }

    voucher(id){
        $("#voucher-datos01").html("");
        $('#modal-ticket').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_voucher.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $("#voucher-datos01").html(`
                    <tr>
                        <td>FECHA:</td>
                        <td>:</td>
                        <td>${datos[0].fecha_desem}</td>
                    </tr>
                    <tr>
                        <td>DIRECCION:</td>
                        <td>:</td>
                        <td>Jr. Parra del Riego 585</td>
                    </tr>
                    <tr>
                        <td>CREDITO:</td>
                        <td>:</td>
                        <td>${datos[0].monto_aprob}</td>
                    </tr>
                    <tr>
                        <td>DNI:</td>
                        <td>:</td>
                        <td>${datos[0].cli_dni}</td>
                    </tr>
                    <tr>
                        <td>NOMBRES:</td>
                        <td>:</td>
                        <td>${datos[0].cli_nombre}</td>
                    </tr>
                    <tr>
                        <td>APELLIDOS:</td>
                        <td>:</td>
                        <td>${datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat}</td>
                    </tr>
                    <tr>
                        <td>MONTO:</td>
                        <td>:</td>
                        <td>S/. ${datos[0].monto_aprob}</td>
                    </tr>
                    <tr>
                        <td>N° CUOTAS:</td>
                        <td>:</td>
                        <td>${datos[0].n_cuotas_aprob}</td>
                    </tr>
                    <tr>
                        <td>ESTADO:</td>
                        <td>:</td>
                        <td>${datos[0].estado}</td>
                    </tr>
                    <tr>
                        <td>ASESOR:</td>
                        <td>:</td>
                        <td>${datos[0].usu_ases_nombre + " " + datos[0].usu_ases_apellido_pat + " " + datos[0].usu_ases_apellido_mat}</td>
                    </tr>
                    <tr>
                        <td>VENTANILLA:</td>
                        <td>:</td>
                        <td>${datos[0].usu_caja_nombre + " " + datos[0].usu_caja_apellido_pat + " " + datos[0].usu_caja_apellido_mat}</td>
                    </tr>
                `);

                $("#voucher-datos02").html(`
                    ${datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat}
                `);

            }
        });
    }
    voucherPago(id){
        $("#voucher-datos01").html("");
        $("#voucher-datos02").html("");
        $('#modal-ticket').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/creditos/cobranza/ajax_voucher.php",
            type: "GET",
            data: {idvoucher: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                var ajax_cont;

                ajax_cont += `
                    <tr>
                        <td>FECHA</td>
                        <td>:</td>
                        <td>${datos[0].fecha_pagado}</td>
                    </tr>
                    <tr>
                        <td>DIRECCION</td>
                        <td>:</td>
                        <td>Jr. Parra del Riego 585</td>
                    </tr>
                    
                    <tr>
                        <td>DNI</td>
                        <td>:</td>
                        <td>${datos[0].cli_dni}</td>
                    </tr>
                    <tr>
                        <td>NOMBRES</td>
                        <td>:</td>
                        <td>${datos[0].cli_nombre}</td>
                    </tr>
                    <tr>
                        <td>APELLIDOS</td>
                        <td>:</td>
                        <td>${datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat}</td>
                    </tr>

                    <tr>
                        <td>CREDITO</td>
                        <td>:</td>
                        <td>S/.${datos[0].monto_aprob} <BR> (${datos[0].n_cuotas_aprob}) cuotas ${datos[0].frecuencia}</td>
                    </tr>

                    `;

               
                


                ajax_cont += `
                    <tr>
                        <td>MONTO PAGADO</td>
                        <td>:</td>
                        <td>S/.${datos[0].monto_pagado}</td>
                    </tr>
                    <tr>
                        <td>VENTANILLA</td>
                        <td>:</td>
                        <td>${datos[0].usu_nombre + " " + datos[0].usu_apellido_pat + " " + datos[0].usu_apellido_mat}</td>
                    </tr>
                `;

                $("#voucher-datos01").html(ajax_cont);
                $("#voucher-datos02").html(`
                    ${datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat}
                `);

                

            }
        });
    }
    cronograma(id){
        //$("#voucher-datos01").html("");
        $('#modal-cronograma').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_calendario.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                console.log(datos[0]);
                
                $("#cronograma-datos01").html(`
                                            <tr>
                                                <td> COD. CLIENTE</td>
                                                <td>:</td>
                                                <td>${datos[0].cli_dni}</td>
                                            </tr>
                                            <tr>
                                                <td>N° CREDITO</td>
                                                <td>:</td>
                                                <td>${datos[0].nrocredito}</td>
                                            </tr>
                `);

                $("#cronograma-datos02").html(`
                                                    <tr>
                                                        <th>CLIENTE</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat + " " + datos[0].cli_nombre}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>TELÉFONO</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].cli_telefono}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>FECHA DE DESEMBOLSO</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].fecha_desem}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>DIRECCION</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].cli_direccion}</th>
                                                    </tr>
                `);

                $("#cronograma-datos03").html(`
                                                    <tr>
                                                        <th>MONTO</th>
                                                        <th class="font-weight-normal pl-2">S/. ${datos[0].monto_aprob}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>INTERÉS</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].interes_aprob}%</th>
                                                    </tr>
                                                    
                                                `);
                
                switch(datos[0].frecuencia){
                    case "DIARIO":      $("#cronograma-datos03").append(`
                                                    <tr><th>PLAZO</th><th class="font-weight-normal pl-2">${datos[0].n_cuotas_aprob} DIAS</th></tr>
                                        `);
                                        break;
                    case "SEMANAL":     $("#cronograma-datos03").append(`
                                                    <tr><th>PLAZO</th><th class="font-weight-normal pl-2">${datos[0].n_cuotas_aprob} SEMANAS</th></tr>
                                        `);
                                        break;
                    case "QUINCENAL":   $("#cronograma-datos03").append(`
                                                    <tr><th>PLAZO</th><th class="font-weight-normal pl-2">${datos[0].n_cuotas_aprob} QUINCENAS</th></tr>
                                        `);
                                        break;
                    case "MENSUAL":     $("#cronograma-datos03").append(`
                                                    <tr><th>PLAZO</th><th class="font-weight-normal pl-2">${datos[0].n_cuotas_aprob} MESES</th></tr>
                                        `);
                                        break;
                }
                                          
                $("#cronograma-datos03").append(`
                                                    <tr>
                                                        <th>INSCRIPCIÓN</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].inscripcion}</th>
                                                    </tr>
                `);

                $("#cronograma-datos04").html(`
                                                    <tr>
                                                        <th>ANALISTA</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].usu_ases_nombre + " " + datos[0].usu_ases_apellido_pat + " " + datos[0].usu_ases_apellido_mat}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>TELÉFONOS</th>
                                                        <th class="font-weight-normal pl-2">${datos[0].usu_ases_telefono}</th>
                                                    </tr>
                `);



                
               

            }
        });

        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_cronograma.php",
            type: "GET",
            data: {consulta: "editar", iddesembolso: id},
            success: function(response){
                var datos = JSON.parse(response);
               
                $("#load_data_modal-cronograma").html('');

                var cont_ajax_02;

                datos.forEach( datos => {



                    cont_ajax_02 += `
                                    <tr>
                                        <th scope="row">${datos.n_cuota_programada}</th>
                                        <td>${datos.fecha_programada}</td>
                                        <td>S/.${datos.cuota_programada}</td>
                                    `;

                    if(datos.mora==null || datos.mora==""){
                        cont_ajax_02 += `<td></td>`;
                    }else{
                        cont_ajax_02 += `<td>S/.${datos.mora}</td>`;
                    }

                    if(datos.monto==null || datos.monto==""){
                        cont_ajax_02 += `
                                        <td></td>
                                        <td></td>
                                        `;
                    }else{
                        cont_ajax_02 += `
                                        <td>${datos.fecha}</td>
                                        <td>S/.${datos.monto}</td>
                                        `;
                    }

                    cont_ajax_02 += `
                                        <td></td>
                                    </tr>
                                    `;
                    

                });

                $("#load_data_modal-cronograma").html(cont_ajax_02);
                  
            }
        });
    }
    contrato(id){
        //$("#voucher-datos01").html("");
        $('#modal-contrato').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_contrato.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                var nom_plazo;
                var aval_cont = '';

                if(datos[0].idaval!="" && datos[0].idaval!=null){
                    aval_cont = `ASI MISMO TIENE COMO <b>GARANTE</b> AL SEÑOR ${datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat + " " + datos[0].ava_nombre}, CON DNI N° ${datos[0].ava_dni}, POR EL MONTO TOTAL DE LA DEUDA CONTRAIDA, `;
                }

                switch(datos[0].frecuencia){
                    case "DIARIO":      nom_plazo = "DIAS";
                                        break;
                    case "SEMANAL":     nom_plazo = "SEMANAS";
                                        break;
                    case "QUINCENAL":   nom_plazo = "QUINCENAS";
                                        break;
                    case "MENSUAL":     nom_plazo = "MESES";
                                        break;
                }

                solicitud_monto = datos[0].monto_aprob;
                solicitud_cuotas = datos[0].n_cuotas_aprob;
                solicitud_frecuencia = datos[0].frecuencia;
                solicitud_interes = datos[0].interes_aprob;
                solicitud_inicio = datos[0].fecha_inicio;
                solicitud_calendario_contrato();
            

                $("#contrato-datos01").html(`

                    <div class="col-12">
                        <center><h4><ins>CONTRATO DE PRÉSTAMO DINERARIO</ins></h4></center>
                        <br>
                        <p class="text-justify text-uppercase">
                            CONSTE POR EL PRESENTE DOCUMENTO, EN CONTRATO DE PRÉSTAMO DINERARIO QUE CELEBRAN DE UNA PARTE <b>ANDY PERALTA RIVEROS, CON DNI N°47726338</b> CON DOMICILIO EN EL JR. PARRA DEL RIEGO N° 585 - DISTRITO DE EL TAMBO, PROVINCIA DE HUANCAYO, DEPARTAMENTO DE JUNÍN, QUIEN PROCEDE EN CALIDAD DE PRESIDENTE DE LA ASOCIACIÓN "ACIR", EN ADELANTE DENOMINADO "EL ACREEDOR" Y DE LA OTRA PARTE <b>${datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat + ", CON DNI N° " + datos[0].cli_dni}</b>; CON DOMICILIO EN ${datos[0].cli_direccion}, DISTRITO ${datos[0].cli_distrito}, PROVINCIA DE ${datos[0].cli_provincia}, DENOMINADO EN ADELANTE "EL DEUDOR" EN LOS TERMINOS Y CONDICIONES SIGUIENTES: 
                        </p>
                        <h5>1.- ANTECEDENTE Y OBJETO.-</h5>
                        <p class="text-justify text-uppercase">EL ACREEDOR, ES UNA PERSONA JURÍDICA A PRESTAR SERVICIOS RELACIONADOS CON LA LEY CON GARANTÍAS MOBILIARIAS Y EL DEUDOR ES UNA PERSONA NATURAL QUE A LA FECHA NECESITA UN PRÉSTAMO DINERARIO; QUIEN DECLARA QUE EN LA FECHA EL ACREEDOR LE OTORGA EN CALIDAD DE PRÉSTAMO LA SUMA DE <b>S/. ${datos[0].monto_aprob}.00 (00/100 SOLES).</b> LOS MISMOS QUE GENERAN MENSUALMENTE LOS INTERESES COMPENSATORIOS Y MORATORIOS (DE SER EL CASO), COMISIONES, IMPUESTOS Y GASTOS ADMINISTRATIVOS QUE EL ACREEDOR TIENE VIGENTE PARA ESTE TIPO DE OPERACIONES QUE HAN SIDO EXPLICADAS DETALLADAMENTE AL DEUDOR Y QUE SERÁN POR TODO CONCEPTO, CONFORME SE DETALLA MAS ADELANTE.</p>

                        <h5>2.- PLAZA Y PAGO DEL PRÉSTAMO.-</h5>
                        <p class="text-justify text-uppercase">EL DEUDOR TIENE EL PLAZO MÁXIMO DE <b>${datos[0].n_cuotas_aprob + " " + nom_plazo}</b> CALENDARIOS PARA QUE CUMPLA CON CANCELAR EL PRÉSTAMO MATERIA DE ESTE CONTRATO, REPARTIDOS EN <b>${datos[0].n_cuotas_aprob} PAGOS ${datos[0].frecuencia}</b> CONTADOS A PARTIR DEL DÍA <b>${datos[0].fecha_inicio_nombre}</b>, MES QUE CANCELARA EL CAPITAL MAS LOS INTERESES GENERADOS Y PACTADOS EN FORMA MENSUAL, HASTA LA CANCELACIÓN TOTAL DE LA DEUDA MAS LOS INTERESES.</p>
                        
                        <h5>3.- GARANTÍA.-</h5>
                        <p class="text-justify text-uppercase">EL DEUDOR ACEPTA <b>FIRMAR UNA LETRA DE CAMBIO</b> PARA EL CUMPLIMIENTO DEL PAGO DEL PRÉSTAMO, INTERÉS, COMISIONES, GASTOS IMPUESTOS SEÑALADOS EN LA CLAUSULA PRIMERA, ASÍ COMO CUALQUIER OTRA OBLIGACIÓN FRENTE AL ACREEDOR, PRESENTE O FUTURA, ${aval_cont} LA DEUDA TIENE COMO FECHA DE VENCIMIENTO A <b><span id="fecha_vencimiento"></span>.</b></p>

                        <h5>4.- INTERESES, COMISIONES Y GASTOS.-</h5> 
                        <p class="text-justify text-uppercase">EL DEUDOR SE OBLIGA A PAGAR UNA TASA DE INTERÉS APLICABLE AL PRÉSTAMO CONCEDIDO DEL <b>${datos[0].interes_aprob}% ${datos[0].frecuencia}</b>; EL ACREEDOR COBRARA AL DEUDOR LOS INTERESES COMPENSATORIOS, MORAS O PENALIDADES (DE SER EL CASO), COMISIÓN, IMPUESTOS Y GASTOS EN LOS PORCENTAJES. EL DEUDOR RECONOCE HABER SIDO INSTRUIDO SOBRE LA FORMA DE CALCULO, OPORTUNIDAD DE COBRO Y EL MONTO DE LOS CONCEPTOS MENCIONADOS EN EL PÁRRAFO ANTERIOR, MANIFESTANDO SU ACEPTACIÓN Y CONFORMIDAD CON LOS MISMOS, QUEDA EXPRESAMENTE PACTADO QUE LA DEMORA EN PAGOS DE CUALES QUIERA DE LAS OBLIGACIONES ASUMIDAS POR EL DEUDOR DETERMINARA LAS SUMAS EN <b>EL INTERÉS MORATORIO DIARIO</b> O PENALIDADES (DE SER EL CASO) EN FORMA ADICIONAL AL INTERÉS COMPENSATORIO PACTADO.</p>

                        <h5>5.- DE LA CESIÓN DE POSICIÓN CONTRACTUAL.-</h5> 
                        <p class="text-justify text-uppercase">EL DEUDOR PRESTA SU CONFORMIDAD Y EXPRESAMENTE AUTORIZA AL ACREEDOR PARA CEDER O TRANSMITIR TOTAL O PARCIALMENTE TODOS LOS DERECHOS Y OBLIGACIONES DERIVADOS A ESTE CONTRATO EN FAVOR DE UN TERCERO NO SERA NECESARIO LA COMUNICACIÓN DE FECHA CIERTA AL DEUDOR PARA QUE LA CESIÓN SURTA EFECTOS ESTE PACTO COMPRENDE TANTO LA CESIÓN DE DERECHOS COMO LA CESIÓN DE POSICIÓN CONTRACTUAL. ASIMISMO EL ACREEDOR PODRÁ EFECTUAR O DAR EN GARANTÍA. CUALQUIER SEA LA FORMA QUE ESTA REVISTA LOS DERECHOS QUE ESTE CONTRATO CONFIERE.</p>

                        <h5>6.- DOMICILIO Y CONVENIO ARBITRAL.-</h5> 
                        <p class="text-justify text-uppercase">PARA LA VALIDEZ DE TODAS LAS COMUNICACIONES Y NOTIFICACIONES CON MOTIVO DE LA EJECUCIÓN DE ESTE CONTRATO. AMBAS PARTES SEÑALAN COMO SUS DOMICILIOS LOS INDICADOS EN LA PARTE INTRODUCTORIA DE ESTE DOCUMENTO EL CAMBIO DE DOMICILIO DE CUALQUIERA DE LAS PARTES SOLO SURTIRÁ EFECTOS DESDE LA FECHA DE COMUNICACIÓN A LA OTRA PARTE, POR CUALQUIER MEDIO ESCRITO, CON PLAZO ANTICIPACIÓN O MENOS A CINCO DÍAS. ASIMISMO, TODA LA CONTROVERSIA RELACIONADA A LA VALIDEZ, NULIDAD, INTERPRETACIÓN Y/O EJECUCIÓN DEL PRESENTE CONTRATO SERA SOMETIDO AL ARBITRAJE DE DERECHO SEGÚN Y CONFORME AL PROCEDIMIENTO PREVISTO EN EL PRESENTE CONTRATO SERA DE APLICACIÓN LA LEY DE GARANTÍA MOBILIARIA.</p>

                        <h5>7.- DATOS PERSONALES.-</h5> 
                        <p class="text-justify text-uppercase">EL DEUDOR RECONOCE QUE EN EL MARCO DE LA RELACIÓN QUE ESTE CONTRATO GENERAL A ENTREGADO AL ACREEDOR INFORMACIÓN Y/O DOCUMENTACIÓN SOBRE SU SITUACIÓN PERSONAL, FINANCIERA Y CREDITICIA, QUE PUDIERA SER CALIFICADA COMO DATOS PERSONALES CONFORME A LA LEGISLACIÓN DE LA MATERIA. LA MISMA QUE POR LA PRESENTE CLAUSULA AUTORIZA EXPRESAMENTE AL PRESTAMISTA A DAR TRATAMIENTO Y PROCESAR DE LA MANERA MAS AMPLIA PERMITIDA POR LA NORMAS PERTINENTE Y CONFORME A LOS PROCEDIMIENTOS QUE EL ACREEDOR DETERMINE EN EL MARCO DE SUS OPERACIONES HABITUALES.</p>

                        <p class="text-justify text-uppercase">EN SEÑAL DE CONFORMIDAD LOS INTERVINIENTES SUSCRIBEN EL PRESENTE CONTRATO EN LA CIUDAD DE HUANCAYO A LOS  <b>${datos[0].fecha_desem_nombre}</b></p>

                        <br><br><br><br>
                    </div>
                    <div class="col-6 text-center">
                        <div class="text-uppercase" style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">ANDY PERALTA RIVEROS<br>DNI Nº 47726338<br><b>ACREEDOR</b></div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="text-uppercase" style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">${datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat}<br>DNI Nº ${datos[0].cli_dni}<br><b>EL DEUDOR</b></div>
                    </div>
                          

                `);

                if(datos[0].idconyugue!="" && datos[0].idconyugue!=null){
                    $("#contrato-datos01").append(`
                        <div class="col-6 text-center">
                            <br><br><br>
                            <div class="text-uppercase" style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">${datos[0].con_nombre + " " + datos[0].con_apellido_pat + " " + datos[0].con_apellido_mat}<br>DNI Nº ${datos[0].con_dni}<br><b>GARANTE</b></div>
                        </div> 
                    `);
                }
                if(datos[0].idaval!="" && datos[0].idaval!=null){
                    $("#contrato-datos01").append(`
                        <div class="col-6 text-center">
                            <br><br><br>
                            <div class="text-uppercase" style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">${datos[0].ava_nombre + " " + datos[0].ava_apellido_pat + " " + datos[0].ava_apellido_mat}<br>DNI Nº ${datos[0].ava_dni}<br><b>GARANTE</b></div>
                        </div> 
                    `);
                }

                $("#contrato-datos01").append(`
                    <div class="col-12 text-center">
                        <br><br><br>
                        <div class="text-uppercase" style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">${datos[0].usu_ases_nombre + " " + datos[0].usu_ases_apellido_pat + " " + datos[0].usu_ases_apellido_mat}<br>DNI Nº ${datos[0].usu_ases_dni}<br><b>CRÉDITOS Y COBRANZAS</b></div>
                    </div> 
                `);
               

            }
        });

    }

    eliminarSolicitud(id){  
            $.ajax({
                url: "../backend/panel/creditos/solicitudes/ajax_eliminar.php",
                type: "POST",
                data: {id: id},
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#msg-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                        //console.log(response);
                        if(response==200){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                    Se elimino la solicitud!
                                </div>
                            `);
                            setTimeout(()=>{
                                credito.listarSolicitudes();
                                $('#modal-add').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                credito.idEdit = 0;
                                setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                            },700);
                        }else{
                            $("#msg-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            `+response+`
                                        </div>
                            `);
                        }   
                },
                timeout: 30000,
                error: function(xhr, status){
                        $('.btn_modals').prop('disabled', false);
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                    </div>
                        `);
                        
                }
            });
    }

    buscar_solicitud(clave){

        var tipo_bus = $("#solicitudes_buscar_tipo").val();

        $.ajax({
            url: "../backend/panel/creditos/solicitudes/ajax_buscar_solicitud.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_solicitudes").html('');
                $("#load_table_solicitudes").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.idcredito}</td>
                                                <td>${datos.cli_apellido_pat + ' ' + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td>${datos.usu_apellido_pat + ' ' + datos.usu_apellido_mat + " " + datos.usu_nombre}</td>
                                                <td>S/. ${datos.monto_prop}</td>
                                    `;

                    if(datos.monto_aprob==null || datos.monto_aprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>                  
                        `;
                    }else{
                        contenido_ajax += `
                                                <td>S/. ${datos.monto_aprob}</td> 
                        `;
                    }
                                                
                    
                    contenido_ajax += `
                                                <td>${datos.n_cuotas}</td>
                                                <td>${datos.interes + " %"}</td>          
                                    `;

                    if(datos.fecha_preaprob==null || datos.fecha_preaprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>
                        `;
                    }else{
                        contenido_ajax += `
                                                <td>${datos.fecha_preaprob}</td>
                        `;
                    }

                    switch(datos.estado){
                        case "REGISTRADO":      
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "PREAPROBADO":     
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-info">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "APROBADO":        
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-primary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "DESEMBOLSADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "FINALIZADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;
                    }

                    
                    if(datos.estado=="REGISTRADO"){
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit_credito("solicitud",${datos.idsolicitud});'><i class="fas fa-edit"></i> Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }else{
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:130px;" type="button" class="btn btn-warning" onClick='btn_ver_credito("solicitud",${datos.idsolicitud});'><i class="fas fa-eye"></i> Ver detalles</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }                             
                });
            
                $("#load_table_solicitudes").html('');
                $("#load_data_solicitudes").html(contenido_ajax);
                                      
            }
        });
    }
    buscar_aprobacion(clave){

        var tipo_bus = $("#aprobaciones_buscar_tipo").val();

        $.ajax({
            url: "../backend/panel/creditos/aprobaciones/ajax_buscar_aprobacion.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_aprobaciones").html('');
                $("#load_table_aprobaciones").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.idcredito}</td>
                                                <td>${datos.cli_apellido_pat + ' ' + datos.cli_apellido_mat + ' ' + datos.cli_nombre}</td>
                                                <td>${datos.usu_ases_apellido_pat + ' ' + datos.usu_ases_apellido_mat + ' ' + datos.usu_ases_nombre}</td>
                                                <td>S/. ${datos.monto_prop}</td>
                                    `;

                    if(datos.monto_aprob==null || datos.monto_aprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>                  
                        `;
                    }else{
                        contenido_ajax += `
                                                <td>S/. ${datos.monto_aprob}</td> 
                        `;
                    }
                                                
                    
                    contenido_ajax += `
                                                <td>${datos.fecha_preaprob}</td>      
                    `;
                    if(datos.fecha_aprob==null || datos.fecha_aprob==""){
                        contenido_ajax += `
                                                <td>Pendiente...</td>      
                    `;
                    }else{
                        contenido_ajax += `
                                                <td>${datos.fecha_preaprob}</td>      
                    `;
                    }

                    switch(datos.estado){
                        case "REGISTRADO":      
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "PREAPROBADO":     
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-info">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "APROBADO":        
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-primary">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "DESEMBOLSADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                            `;
                                            break;
                    }

                    
                    if(datos.estado=="PREAPROBADO"){
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:140px;" type="button" class="btn btn-success" onClick='btn_edit_credito("aprobacion",${datos.idaprobacion});'><i class="fas fa-lg fa-clipboard"></i> Ver Crédito</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }else{
                        if(datos.estado=='APROBADO'){
                                contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button type="button" class="btn btn-warning btn_modals" onclick="btn_ver_credito('aprobacion',${datos.idaprobacion});" style="width:130px;"><i class="fas fa-eye"></i> Ver detalles</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                        }
                    }                             
                });

                if(datos=="" || datos==null){
                    contenido_ajax = `
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>                    
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>                    
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>                    
                                    </tr>
                                    `;
                }
            
                $("#load_table_aprobaciones").html('');
                $("#load_data_aprobaciones").html(contenido_ajax);
                                      
            }
        });
    }
    buscar_desembolso(clave){

        var tipo_bus = $("#desembolsos_buscar_tipo").val();

        $.ajax({
            url: "../backend/panel/creditos/desembolsos/ajax_buscar_desembolso.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_desembolsos").html('');
                $("#load_table_desembolsos").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.cli_apellido_pat + ' ' + datos.cli_apellido_mat + ' ' + datos.cli_nombre}</td>
                                                <td>${datos.usu_ases_apellido_pat + ' ' + datos.usu_ases_apellido_mat + ' ' + datos.usu_ases_nombre}</td>
                                                <td>S/. ${datos.monto_aprob}</td>
                                    `;

                    switch(datos.estado){
                        case "REGISTRADO":      
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;
                
                        case "PREAPROBADO":     
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-info">${datos.estado}</span></td>
                                            `;
                                            break;
                
                        case "APROBADO":        
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-primary">${datos.estado}</span></td>
                                            `;
                                            break;
                
                        case "DESEMBOLSADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                            `;
                                            break;

                        case "FINALIZADO":    
                                            contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-secondary">${datos.estado}</span></td>
                                            `;
                                            break;
                    }

                    

                    
                    if(datos.estado=="APROBADO"){
                        contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:155px;" type="button" class="btn btn-success" onclick='btn_edit_credito("desembolso",${datos.iddesembolso});'><i class="fas fa-lg fa-coins"></i> Desembolsar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                    }else{
                        if(datos.estado=='DESEMBOLSADO'){
                            if(datos.user_privilegios=="ADMINISTRADOR" || datos.user_privilegios=="ROOT"){
                                if(datos.hoy==datos.fecha_desem){
                                    contenido_ajax += `
                                                    <td>
                                                        <div class="col text-center"> 
                                                            <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                            <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                            <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                                            <button style="width:120px;margin-top:3px;" type="button" class="btn btn-danger" onclick='btn_edit_credito("extornar",${datos.iddesembolso});'><i class="fas fa-lg fa-history"></i> Extornar</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `;
                                }else{
                                    contenido_ajax += `
                                                    <td>
                                                        <div class="col text-center"> 
                                                            <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                            <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                            <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `;
                                }
                                
                            }else{
                                contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                        <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                        <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `;
                            }
                        }else{
                            if(datos.estado=='FINALIZADO'){
                                contenido_ajax += `
                                        <td>
                                            <div class="col text-center"> 
                                                <button style="width:110px;" type="button" class="btn btn-info" onclick='btn_desembolso_print("voucher",${datos.iddesembolso});'><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                                <button style="width:138px;" type="button" class="btn btn-warning" onclick='btn_desembolso_print("cronograma",${datos.iddesembolso});'><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                                <button style="width:120px;" type="button" class="btn btn-dark" onclick='btn_desembolso_print("contrato",${datos.iddesembolso});'><i class="fas fa-lg fa-file-alt"></i> Contrato</button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            }
                        }
                    }                             
                });
            
                $("#load_table_desembolsos").html('');
                $("#load_data_desembolsos").html(contenido_ajax);
                                      
            }
        });
    }
}

class Caja{
    constructor(){
        this.idEdit = 0;
        this.metodo = 0; //1: guardar; 2: modificar
        this.formulario;
        this.cuadrarCaja = false;
    }

    listarCajas(){
        //console.log("listando")
        $.ajax({
            url: "../backend/panel/cajas/crear/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_cajas").html('');
                $("#load_table_cajas").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.nombre}</td>
                                              
                                    `;

                    if(datos.capital==null || datos.capital==""){
                        contenido_ajax += `
                                                <td></td>                  
                        `;
                    }else{
                        contenido_ajax += `
                                                <td>S/. ${datos.capital}</td> 
                        `;
                    }
                          
                    contenido_ajax += `
                                                <td>${datos.user_nombre + " " + datos.apellido_pat + " " + datos.apellido_mat}</td>
                                              
                                    `;

                    switch(datos.estado){
                        case "DESHABILITADO": contenido_ajax += `
                                                                <td class="text-center"><span class="badge badge-pill badge-danger">${datos.estado}</span></td>
                                                            `; break;
                        case "ABIERTO": contenido_ajax += `
                                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                                            `; break;
                        case "CERRADO": contenido_ajax += `
                                                                <td class="text-center"><span class="badge badge-pill badge-warning">${datos.estado}</span></td>
                                                            `; break;
                    }

                    contenido_ajax += `         
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:140px;" type="button" class="btn btn-primary" onClick='btn_edt_caja(${datos.idcaja},"CREAR");'><i class="fas fa-edit"></i> Modificar</button>
                                                    </div>
                                                </td>
                                            </tr>
                    `;

                             
                });
            
                $("#load_table_cajas").html('');
                $("#load_data_cajas").html(contenido_ajax);
                                      
            }
        });
    }

    listarAperturas(){
        //console.log("listando")
        $.ajax({
            url: "../backend/panel/cajas/aperturas/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_aperturas").html('');
                $("#load_table_aperturas").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.nombre}</td>
                                              
                                    `;


                    if(datos.capital==null || datos.capital==""){
                        contenido_ajax += `
                                                <td></td>                  
                        `;
                    }else{
                        if(datos.estado!="ABIERTO"){
                            contenido_ajax += `
                                                <td>S/. ${datos.capital}</td> 
                            `;
                        }else{
                            if(datos.privilegios=="CAJA"){
                                contenido_ajax += `
                                                <td>EN USO</td> 
                                `;
                            }else{
                                contenido_ajax += `
                                                <td>S/. ${datos.capital}</td> 
                                `;
                            }
                            
                        }
                        
                    }
                                
                    contenido_ajax += `
                                                <td>${datos.user_nombre + " " + datos.apellido_pat + " " + datos.apellido_mat}</td>       
                                    `;
                    

                    switch(datos.estado){
                        case "DESHABILITADO": contenido_ajax += `
                                                                <td class="text-center"><span class="badge badge-pill badge-danger">${datos.estado}</span></td>
                                                            `; break;
                        case "ABIERTO": contenido_ajax += `
                                                                <td class="text-center"><span class="badge badge-pill badge-success">${datos.estado}</span></td>
                                                                <td>
                                                                    <div class="col text-center"> 
                                                                        <button style="width:140px;" type="button" class="btn btn-danger" onClick='btn_edt_caja(${datos.idcaja},"CIERRE");'><i class="fas fa-lock"></i> Cerrar Caja</button>
                                                                    </div>
                                                                </td>
                                                            `; break;
                        case "CERRADO": contenido_ajax += `
                                                                <td class="text-center"><span class="badge badge-pill badge-warning">${datos.estado}</span></td>
                                                                <td>
                                                                    <div class="col text-center"> 
                                                                        <button style="width:140px;" type="button" class="btn btn-success" onClick='btn_edt_caja(${datos.idcaja},"APERTURA");'><i class="fas fa-lock-open"></i> Abrir Caja</button>
                                                                    </div>
                                                                </td>
                                                            `; break;
                    }

                    contenido_ajax += `
                                            </tr>
                    `;

                             
                });
            
                $("#load_table_aperturas").html('');
                $("#load_data_aperturas").html(contenido_ajax);
                                      
            }
        });
    }

    listarMovimientos(clave){
        
        $.ajax({
            url: "../backend/panel/cajas/movimientos/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar", clave:clave},
            beforeSend: function(){
                $("#load_data_movimientos").html('');
                $("#load_table_movimientos").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                //console.log(datos);
                datos.forEach( datos => {
                 
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.caja_nombre}</td>
                                        `;
                    
                    if(datos.tipo_mov=="INGRESO"){
                        contenido_ajax += `
                            <td><span class="badge badge-pill badge-success">${datos.tipo_mov}</span></td>
                        `;
                    }else{
                        contenido_ajax += `
                            <td><span class="badge badge-pill badge-danger">${datos.tipo_mov}</span></td>
                        `;
                    }

                    contenido_ajax += `
                    
                                                
                                                <td>S/. ${datos.monto}</td>
                                                <td>${datos.concepto}</td>
                                                <td>${datos.fecha_mov}</td>
                                                <td><center><button type="button" class="btn btn-primary" onclick='btn_movimientos_print("voucher",${datos.idmovimiento});'><i class="fas fa-lg fa-ticket-alt"></i></button></center></td>
                                              
                                    `;
                     
                    contenido_ajax += `
                                            </tr>
                    `;
                    
                             
                });
            
                $("#load_table_movimientos").html('');
                $("#load_data_movimientos").html(contenido_ajax);
                //console.log("listando")                 
            }
        });
    }

    listarTransferencias(clave){
        
        $.ajax({
            url: "../backend/panel/cajas/transferencias/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar", clave:clave},
            beforeSend: function(){
                $("#load_data_transferencias").html('');
                $("#load_table_transferencias").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                //console.log(datos);
                datos.forEach( datos => {
                 
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.caja_ori_nombre}</td>
                                        `;
                    
                 
                    contenido_ajax += `
                                                <td><center><span class="badge badge-pill badge-warning">${datos.tipo_mov}</span></center></td>
                    `;
                    

                    contenido_ajax += `                      
                                                <td>S/. ${datos.monto}</td>
                                                <td>${datos.caja_des_nombre}</td>
                                                <td>${datos.concepto}</td>
                                                <td>${datos.fecha_mov}</td>
                                                <td><center><button type="button" class="btn btn-primary" onclick='btn_transferencias_print("voucher",${datos.idtransferencia});'><i class="fas fa-lg fa-ticket-alt"></i></button></center></td>
                                              
                                    `;
                     
                    contenido_ajax += `
                                            </tr>
                    `;
                    
                             
                });
            
                $("#load_table_transferencias").html('');
                $("#load_data_transferencias").html(contenido_ajax);
                //console.log("listando")                 
            }
        });
    }

    crearCaja(){
        $.ajax({
            type: 'POST',
            url: '../backend/panel/cajas/crear/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        caja.listarCajas();
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }

    registrarMovimiento(){
        $.ajax({
            type: 'POST',
            url: '../backend/panel/cajas/movimientos/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        caja.listarMovimientos(0);
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            if(response=="600"){
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        No hay fondos suficientes en la Caja!.
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                            }
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }

    registrarTransferencia(){
        $.ajax({
            type: 'POST',
            url: '../backend/panel/cajas/transferencias/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
          
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        caja.listarTransferencias(0);
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            if(response=="600"){
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        No hay fondos suficientes en la Caja de Origen!.
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                            }
                        }
                    }     
                }
                
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }


    editCaja(id){
        document.getElementById("formulario-caja-edt").reset();
        $('#modal-add-edt').modal('show'); 
        $('#modal-add-edt h4').html("Modificar Caja");
        
        $.ajax({
            url: "../backend/panel/cajas/crear/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                

                $('#caja_nombre-edt').val(datos[0].nombre);
                $('#caja_capital-edt').val(datos[0].capital);
                $("#caja_hab_billetaje").val(datos[0].billetaje_reg);

                $('#caja_autor-edt').val(datos[0].user_nombre + " " + datos[0].apellido_pat + " " + datos[0].apellido_mat);
                $('#caja_autor-hidden-edt').val(datos[0].idusuario);

                $("#caja_autor-edt").removeClass("is-invalid");
                $("#caja_autor-edt").addClass("is-valid");
        

                if(datos[0].estado=='DESHABILITADO'){
                    $(".modal-btn-cont-edt").html(`
                        <button type="button" class="btn btn-primary btn_modals" onclick="caja.habilitar(${id},1);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Habilitar</button>
                    `);
                }else{
                    if(datos[0].estado=='CERRADO'){
                        $(".modal-btn-cont-edt").html(`
                            <button type="button" class="btn btn-danger btn_modals" onclick="caja.habilitar(${id},0);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Deshabilitar</button>
                        `);
                    }
                }


            }
        });
    }

    editApertura(id){
        document.getElementById("formulario-apertura").reset();
        $('#modal-add').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/cajas/aperturas/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]); 

                $('#caja_nombre').val(datos[0].nombre);

                if(datos[0].billetaje_reg=="SI"){
                    $(".caja_billetaje").attr("readonly","readonly");
                }else{
                    $(".caja_billetaje").removeAttr("readonly");
                    $('#caja_capital').val('');
                }
                

                $("#caja_b_200").val(datos[0].m200);
                $("#caja_b_100").val(datos[0].m100);
                $("#caja_b_50").val(datos[0].m50);
                $("#caja_b_20").val(datos[0].m20);
                $("#caja_b_10").val(datos[0].m10);
                $("#caja_b_5").val(datos[0].m5);
                $("#caja_b_2").val(datos[0].m2);
                $("#caja_b_1").val(datos[0].m1);
                $("#caja_b_0_5").val(datos[0].m0_5),
                $("#caja_b_0_2").val(datos[0].m0_2);
                $("#caja_b_0_1").val(datos[0].m0_1);

                
                caja.calcularBilletajeInput();


                if(datos[0].estado=='CERRADO'){
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-success btn_modals" onclick="caja.apertura(${datos[0].idcaja},1);" style="width:165px;"><i class="fas fa-lg fa-lock-open"></i> Aperturar Caja</button>
                    `);
                }else{ 
                    if(datos[0].billetaje_reg=="SI"){
                        $(".modal-btn-cont").html(`
                            <button type="button" class="btn btn-danger btn_modals" onclick="caja.apertura(${datos[0].idcaja},0);" style="width:165px;"><i class="fas fa-lg fa-user-lock"></i> Cerrar Caja</button>
                        `);   
                    }else{
                        $(".modal-btn-cont").html(`
                            <button type="button" class="btn btn-primary btn_modals" onclick="caja.registrarBilletaje(${datos[0].idcaja});" style="width:225px;"><i class="fas fa-lg fa-money-bill-wave"></i> Registrar Billetaje</button>
                        `); 
                    }  
                }


            }
        });
    }


    editarSaveCaja(id){

        this.formulario.append("id",id); 

        $.ajax({
            type: 'POST',
            url: '../backend/panel/cajas/crear/ajax_editar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals-edt').prop('disabled', true);
                $("#msg-ajax-result-edt").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result-edt").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        caja.listarCajas();
                        $('#modal-add-edt').modal('hide');
                        $('.btn_modals-edt').prop('disabled', false);
                        setTimeout(()=>{$("#msg-ajax-result-edt").html("");},700);
                    },600);
                }else{
                    $('.btn_modals-edt').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result-edt").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result-edt").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#msg-ajax-result-edt").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals-edt').prop('disabled', false);
                $("#msg-ajax-result-edt").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }

    
    buscarUserCajaResp(clave){
        $.ajax({
            url: "../backend/panel/cajas/ajax_buscar_cajero_all.php",
            type: "GET",
            data: {clave: clave},
            success: function(response){    
                var resultados = JSON.parse(response);
                //console.log(resultados);
                $("#cajeros_resp").html("");  
            
                resultados.forEach( resultados => {
                    $("#cajeros_resp").append(`
                        <option data-id="${resultados.id}" value="${resultados.nombre + ' ' + resultados.apellido_pat + ' ' + resultados.apellido_mat}">${resultados.privilegios}</option>
                    `);

                });  
            }
        });
    }
    buscarUserCajaRespEdit(clave){
        $.ajax({
            url: "../backend/panel/cajas/ajax_buscar_cajero_all.php",
            type: "GET",
            data: {clave: clave},
            success: function(response){    
                var resultados = JSON.parse(response);
                //console.log(resultados);
                $("#cajeros_resp-edt").html("");  
            
                resultados.forEach( resultados => {
                    $("#cajeros_resp-edt").append(`
                        <option data-id="${resultados.id}" value="(${resultados.id + '): ' + resultados.nombre + ' ' + resultados.apellido_pat + ' ' + resultados.apellido_mat}">${resultados.privilegios}</option>
                    `);

                });  
            }
        });
    }

    buscarUserCaja(){
        $.ajax({
            url: "../backend/panel/cajas/ajax_buscar_cajero.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
        
                if(datos!="" && datos!=null){
                    $("#caja_resp").removeClass("is-invalid");
                    $("#caja_resp").addClass("is-valid");
                    $("#caja_resp-hidden").val(datos[0].idcajero);
                    $("#caja_resp").val(datos[0].nombre + " " + datos[0].apellido_pat + " " + datos[0].apellido_mat);
                }else{
                    $("#caja_resp").removeClass("is-valid");
                    $("#caja_resp").addClass("is-invalid");
                }
            }
        });
    }
    buscarFechaHora(){
        $.ajax({
            url: "../backend/panel/solicitud_fecha_hora.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
                $('#caja_fecha').val(datos[0].fecha);
                $('#caja_hora').val(datos[0].hora);
            }
        });
    }
    buscarCajas(){
        $.ajax({
            url: "../backend/panel/cajas/ajax_buscar_cajas.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = `<option value="" selected disabled>--Seleccionar--</option>`;

                $("#movimiento_caja").html("");

                datos.forEach( datos => {
                    ajax_cont += `
                                <option value="${datos.idcaja}">${datos.nombre}</option>
                    `;
                });

                $("#movimiento_caja").html(ajax_cont);

            }
        });
    }
    buscarCajasTransferencias(){
        $.ajax({
            url: "../backend/panel/cajas/ajax_buscar_cajas.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = `<option value="" selected disabled>--Seleccionar--</option>`;

                $("#movimiento_caja_ori").html("");

                datos.forEach( datos => {
                    ajax_cont += `
                                <option value="${datos.idcaja}">${datos.nombre}</option>
                    `;
                });

                $("#movimiento_caja_ori").html(ajax_cont);

            }
        });
        $.ajax({
            url: "../backend/panel/cajas/ajax_buscar_cajas_all.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = `<option value="" selected disabled>--Seleccionar--</option>`;

                $("#movimiento_caja_des").html("");

                datos.forEach( datos => {
                    ajax_cont += `
                                <option value="${datos.idcaja}">${datos.nombre}</option>
                    `;
                });

                $("#movimiento_caja_des").html(ajax_cont);

            }
        });
    }
    buscarUserTransferencias(clave){

        $.ajax({
            url: "../backend/panel/cajas/ajax_buscar_resp_autorizacion.php",
            type: "GET",
            data: {clave:clave},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos)
                $("#admins-list").html('');

                datos.forEach( datos => {
                    $("#admins-list").append(`
                        <option data-id="${datos.idresp}" value="${datos.nombre + ' ' + datos.apellido_pat + ' ' + datos.apellido_mat}">${datos.privilegios}</option>
                    `);
                });
            }
        });
    }

    habilitar(id,operacion){
        $.ajax({
            url: "../backend/panel/cajas/crear/ajax_habilitar.php",
            type: "POST",
            data: {id: id, operacion:operacion},
            beforeSend: function(){
                $('.btn_modals-edt').prop('disabled', true);
                $("#msg-ajax-result-edt").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result-edt").html(`
                            <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        setTimeout(()=>{
                            caja.listarCajas();
                            $('#modal-add-edt').modal('hide');
                            $('.btn_modals-edt').prop('disabled', false);
                            caja.idEdit = 0;
                            setTimeout(()=>{$("#msg-ajax-result-edt").html("");},700);
                        },700);
                    }else{
                        $("#msg-ajax-result-edt").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals-edt').prop('disabled', false);
                    $("#msg-ajax-result-edt").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }

    apertura(id,operacion){
        
        if(operacion==1){
            $.ajax({
                url: "../backend/panel/cajas/aperturas/ajax_aperturar.php",
                type: "POST",
                data: {
                    idcaja: id, 
                    operacion:operacion, 
                    idusuario: $("#caja_resp-hidden").val(),
                    monto: $("#caja_capital").val()
    
                    /*
                    m200: $("#caja_b_200").val(),
                    m100: $("#caja_b_100").val(),
                    m50: $("#caja_b_50").val(),
                    m20: $("#caja_b_20").val(),
                    m10: $("#caja_b_10").val(),
                    m5: $("#caja_b_5").val(),
                    m2: $("#caja_b_2").val(),
                    m1: $("#caja_b_1").val(),
                    m0_5: $("#caja_b_0_5").val(),
                    m0_2: $("#caja_b_0_2").val(),
                    m0_1: $("#caja_b_0_1").val()
                    */
                },
                beforeSend: function(){
                    $('.btn_modals').prop('disabled', true);
                    $("#msg-ajax-result").html(`
                        <div style="">
                            <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `); 
                },
                success: function(response){
                        //console.log(response);
                        if(response==200){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Se completo la operación!
                                </div>
                            `);
                            caja.listarAperturas();
                            setTimeout(()=>{
                                $('#modal-add').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                            },1000);
                        }else{
                            $("#msg-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            `+response+`
                                        </div>
                            `);
                        }   
                },
                timeout: 30000,
                error: function(xhr, status){
                        $('.btn_modals').prop('disabled', false);
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                    </div>
                        `);
                        
                }
            });
        }else{
            caja.calcularBilletaje(id);
        }
        
    }

    registrarBilletaje(id){
        $.ajax({
            url: "../backend/panel/cajas/aperturas/ajax_registrar_billetaje.php",
            type: "POST",
            data: {
                idcaja: id, 
                idusuario: $("#caja_resp-hidden").val(),
                monto: $("#caja_capital").val(),

                m200: $("#caja_b_200").val(),
                m100: $("#caja_b_100").val(),
                m50: $("#caja_b_50").val(),
                m20: $("#caja_b_20").val(),
                m10: $("#caja_b_10").val(),
                m5: $("#caja_b_5").val(),
                m2: $("#caja_b_2").val(),
                m1: $("#caja_b_1").val(),
                m0_5: $("#caja_b_0_5").val(),
                m0_2: $("#caja_b_0_2").val(),
                m0_1: $("#caja_b_0_1").val()
            },
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        caja.listarAperturas();
                        setTimeout(()=>{
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },1000);
                    }else{
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
            },
            timeout: 30000,
            error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
            }
        });
    }

    voucher(id){
        $("#voucher-datos01").html("");
        $('#modal-ticket').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/cajas/movimientos/ajax_voucher.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                var cont_ajax = '';

                cont_ajax += `
                    <tr>
                        <td>FECHA:</td>
                        <td>:</td>
                        <td>${datos[0].fecha_mov}</td>
                    </tr>
                    <tr>
                        <td>DIRECCION:</td>
                        <td>:</td>
                        <td>Jr. Parra del Riego 585</td>
                    </tr>
             
                    <tr>
                        <td>TIPO DE MOVIMIENTO:</td>
                        <td>:</td>
                        <td>${datos[0].tipo_mov}</td>
                    </tr>
                    <tr>
                        <td>MONTO:</td>
                        <td>:</td>
                        <td>S/. ${datos[0].monto}</td>
                    </tr>
                    <tr>
                        <td>CONCEPTO:</td>
                        <td>:</td>
                        <td>${datos[0].concepto}</td>
                    </tr>
                    <tr>
                        <td>TIPO DE COMPROBANTE</td>
                        <td>:</td>
                        <td>${datos[0].tipo_comprobante}</td>
                    </tr>
                    <tr>
                        <td>NRO DE COMPROBANTE</td>
                        <td>:</td>
                        <td>${datos[0].nro_comprobante}</td>
                    </tr>
                `;

                if(datos[0].cli_id!=null && datos[0].cli_id!=""){
                    cont_ajax += `
                        <tr>
                            <td>CLIENTE:</td>
                            <td>:</td>
                            <td>${datos[0].cli_nombre + " " + datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat}</td>
                        </tr>
                    `;
                }
                    

                cont_ajax += `
                    <tr>
                        <td>AUTORIZA:</td>
                        <td>:</td>
                        <td>${datos[0].autoriza}</td>
                    </tr>
                    <tr>
                        <td>CAJA:</td>
                        <td>:</td>
                        <td>${datos[0].caja_nombre}</td>
                    </tr>
                   
                    <tr>
                        <td>CAJERO:</td>
                        <td>:</td>
                        <td>${datos[0].usu_nombre + " " + datos[0].usu_apellido_pat + " " + datos[0].usu_apellido_mat}</td>
                    </tr>
                `;


                $("#voucher-titulo").html(`VOUCHER DE ${datos[0].tipo_mov}`);
                $("#voucher-datos01").html(cont_ajax);
                $("#voucher-datos02").html(`
                   
                `);

            }
        });
    }

    voucherTransferencia(id){
        $("#voucher-datos01").html("");
        $('#modal-ticket').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/cajas/transferencias/ajax_voucher.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $("#voucher-titulo").html(`VOUCHER DE ${datos[0].tipo_mov}`);
                $("#voucher-datos01").html(`
                    <tr>
                        <td>FECHA:</td>
                        <td>:</td>
                        <td>${datos[0].fecha_mov}</td>
                    </tr>
                    <tr>
                        <td>DIRECCION:</td>
                        <td>:</td>
                        <td>Jr. Parra del Riego 585</td>
                    </tr>
             
                    <tr>
                        <td>TIPO DE MOVIMIENTO:</td>
                        <td>:</td>
                        <td>${datos[0].tipo_mov}</td>
                    </tr>
                    <tr>
                        <td>MONTO:</td>
                        <td>:</td>
                        <td>S/. ${datos[0].monto}</td>
                    </tr>
                    <tr>
                        <td>CONCEPTO:</td>
                        <td>:</td>
                        <td>${datos[0].concepto}</td>
                    </tr>
                    <tr>
                        <td>CAJA DE ORIGEN</td>
                        <td>:</td>
                        <td>${datos[0].caja_ori_nombre}</td>
                    </tr>
                    <tr>
                        <td>CAJA DE DESTINO</td>
                        <td>:</td>
                        <td>${datos[0].caja_des_nombre}</td>
                    </tr>
                    <tr>
                        <td>AUTORIZA:</td>
                        <td>:</td>
                        <td>${datos[0].autoriza_nombre + " " + datos[0].autoriza_apellido_pat + " " + datos[0].autoriza_apellido_mat}</td>
                    </tr>
                  
                   
                    <tr>
                        <td>CAJERO:</td>
                        <td>:</td>
                        <td>${datos[0].usu_nombre + " " + datos[0].usu_apellido_pat + " " + datos[0].usu_apellido_mat}</td>
                    </tr>
                `);

                $("#voucher-datos02").html(`
                   
                `);

            }
        });
    }

    calcularBilletaje(idcaja){
        caja.cuadrarCaja = false;
        var suma_billet;
        var total;

        $.ajax({
            url: "../backend/panel/cajas/aperturas/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: idcaja},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]); 

               total = datos[0].capital;
               //console.log(total);

               if($("#caja_b_200").val()!="" && $("#caja_b_200").val()!=null){
                var m200 = parseFloat($("#caja_b_200").val())*200;
                }else{
                    var m200 = 0;
                }
                if($("#caja_b_100").val()!="" && $("#caja_b_100").val()!=null){
                    var m100 = parseFloat($("#caja_b_100").val())*100;
                }else{
                    var m100 = 0;
                }
                if($("#caja_b_50").val()!="" && $("#caja_b_50").val()!=null){
                    var m50 = parseFloat($("#caja_b_50").val())*50;
                }else{
                    var m50 = 0;
                }
                if($("#caja_b_20").val()!="" && $("#caja_b_20").val()!=null){
                    var m20 = parseFloat($("#caja_b_20").val())*20;
                }else{
                    var m20 = 0;
                }
                if($("#caja_b_10").val()!="" && $("#caja_b_10").val()!=null){
                    var m10 = parseFloat($("#caja_b_10").val())*10;
                }else{
                    var m10 = 0;
                }
        
                if($("#caja_b_5").val()!="" && $("#caja_b_5").val()!=null){
                    var m5 = parseFloat($("#caja_b_5").val())*5;
                }else{
                    var m5 = 0;
                }
                if($("#caja_b_2").val()!="" && $("#caja_b_2").val()!=null){
                    var m2 = parseFloat($("#caja_b_2").val())*2;
                }else{
                    var m2 = 0;
                }
                if($("#caja_b_1").val()!="" && $("#caja_b_1").val()!=null){
                    var m1 = parseFloat($("#caja_b_1").val())*1;
                }else{
                    var m1 = 0;
                }
                if($("#caja_b_0_5").val()!="" && $("#caja_b_0_5").val()!=null){
                    var m0_5 = parseFloat($("#caja_b_0_5").val())*0.5;
                }else{
                    var m0_5 = 0;
                }
                if($("#caja_b_0_2").val()!="" && $("#caja_b_0_2").val()!=null){
                    var m0_2 = parseFloat($("#caja_b_0_2").val())*0.2;
                }else{
                    var m0_2 = 0;
                }
                if($("#caja_b_0_1").val()!="" && $("#caja_b_0_1").val()!=null){
                    var m0_1 = parseFloat($("#caja_b_0_1").val())*0.1;
                }else{
                    var m0_1 = 0;
                }
        
                suma_billet = m200 + m100 + m50 + m20 + m10 + m5 + m2 + m1 + m0_5 + m0_2 + m0_1;
                
                $("#billet_calculado").text("S/. " + suma_billet);
        
                if(suma_billet == total){
                    caja.cuadrarCaja = true;
                }else{
                   caja.cuadrarCaja = false;
                }

                if(caja.cuadrarCaja){
                    $.ajax({
                        url: "../backend/panel/cajas/aperturas/ajax_aperturar.php",
                        type: "POST",
                        data: {
                            idcaja: idcaja, 
                            operacion:0, 
                            idusuario: $("#caja_resp-hidden").val(),
                            monto: $("#caja_capital").val()
            
                            /*
                            m200: $("#caja_b_200").val(),
                            m100: $("#caja_b_100").val(),
                            m50: $("#caja_b_50").val(),
                            m20: $("#caja_b_20").val(),
                            m10: $("#caja_b_10").val(),
                            m5: $("#caja_b_5").val(),
                            m2: $("#caja_b_2").val(),
                            m1: $("#caja_b_1").val(),
                            m0_5: $("#caja_b_0_5").val(),
                            m0_2: $("#caja_b_0_2").val(),
                            m0_1: $("#caja_b_0_1").val()
                            */
                        },
                        beforeSend: function(){
                            $('.btn_modals').prop('disabled', true);
                            $("#msg-ajax-result").html(`
                                <div style="">
                                    <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            `); 
                        },
                        success: function(response){
                                //console.log(response);
                                if(response==200){                      
                                    $("#msg-ajax-result").html(`
                                        <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                            Se completo la operación!
                                        </div>
                                    `);
                                    caja.listarAperturas();
                                    setTimeout(()=>{
                                        $('#modal-add').modal('hide');
                                        $('.btn_modals').prop('disabled', false);
                                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                                    },1000);
                                }else{
                                    $("#msg-ajax-result").html(`
                                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                    `+response+`
                                                </div>
                                    `);
                                }   
                        },
                        timeout: 30000,
                        error: function(xhr, status){
                                $('.btn_modals').prop('disabled', false);
                                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                                `);
                                
                        }
                    });
        
                }else{
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                El billetaje no coincide con el monto de Caja!
                            </div>
                        `);
                }
                

            },
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                            </div>
                `);
                
        }
        });


        

    }

    calcularBilletajeInput(){
        var suma_billet;

        if($("#caja_b_200").val()!="" && $("#caja_b_200").val()!=null){
            var m200 = parseFloat($("#caja_b_200").val())*200;
        }else{
            var m200 = 0;
        }
        if($("#caja_b_100").val()!="" && $("#caja_b_100").val()!=null){
            var m100 = parseFloat($("#caja_b_100").val())*100;
        }else{
            var m100 = 0;
        }
        if($("#caja_b_50").val()!="" && $("#caja_b_50").val()!=null){
            var m50 = parseFloat($("#caja_b_50").val())*50;
        }else{
            var m50 = 0;
        }
        if($("#caja_b_20").val()!="" && $("#caja_b_20").val()!=null){
            var m20 = parseFloat($("#caja_b_20").val())*20;
        }else{
            var m20 = 0;
        }
        if($("#caja_b_10").val()!="" && $("#caja_b_10").val()!=null){
            var m10 = parseFloat($("#caja_b_10").val())*10;
        }else{
            var m10 = 0;
        }

        if($("#caja_b_5").val()!="" && $("#caja_b_5").val()!=null){
            var m5 = parseFloat($("#caja_b_5").val())*5;
        }else{
            var m5 = 0;
        }
        if($("#caja_b_2").val()!="" && $("#caja_b_2").val()!=null){
            var m2 = parseFloat($("#caja_b_2").val())*2;
        }else{
            var m2 = 0;
        }
        if($("#caja_b_1").val()!="" && $("#caja_b_1").val()!=null){
            var m1 = parseFloat($("#caja_b_1").val())*1;
        }else{
            var m1 = 0;
        }
        if($("#caja_b_0_5").val()!="" && $("#caja_b_0_5").val()!=null){
            var m0_5 = parseFloat($("#caja_b_0_5").val())*0.5;
        }else{
            var m0_5 = 0;
        }
        if($("#caja_b_0_2").val()!="" && $("#caja_b_0_2").val()!=null){
            var m0_2 = parseFloat($("#caja_b_0_2").val())*0.2;
        }else{
            var m0_2 = 0;
        }
        if($("#caja_b_0_1").val()!="" && $("#caja_b_0_1").val()!=null){
            var m0_1 = parseFloat($("#caja_b_0_1").val())*0.1;
        }else{
            var m0_1 = 0;
        }
       
        suma_billet = m200 + m100 + m50 + m20 + m10 + m5 + m2 + m1 + m0_5 + m0_2 + m0_1;

        $("#billet_calculado").text("S/. " + suma_billet);
        $("#caja_capital").val(suma_billet);
    }

}

class Reporte{
    constructor(){
        this.idEdit = 0;
        this.fecha;
        this.fecha_fin;
        this.caja = null;
        this.ingresos = null;
        this.egresos = null;
        this.billetes = null;
        this.monedas = null;
    }
    buscarCajas(){
        $.ajax({
            url: "../backend/panel/reportes/ajax_buscar_cajas.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = `<option value="" selected disabled>--Seleccionar--</option>`;
                var ajax_cont2 = `<option value="TODOS" selected>Todas las cajas</option>`;

                $("#reportes_cajas").html("");

                datos.forEach( datos => {
                    ajax_cont += `
                                <option value="${datos.idcaja}">${datos.nombre}</option>
                    `;
                    ajax_cont2 += `
                                <option value="${datos.idcaja}">${datos.nombre}</option>
                    `;
                });

                $("#reportes_cajas").html(ajax_cont);
                $("#reportes_capital").html(ajax_cont2);
            }
        });
    }

    listarFlujo(fecha,caja){
        reporte.caja = null;
        reporte.ingresos = null;
        reporte.egresos = null;
        reporte.billetes = null;
        reporte.monedas = null;

        reporte.fecha = "";
        reporte.diaSemana(fecha);

        $.ajax({
            url: "../backend/panel/reportes/ajax_flujo_caja_ingreso.php",
            type: "GET",
            data: {fecha:fecha, caja:caja},
            beforeSend: function(){
                $("#load_ingreso").html("");
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;
                //console.log(datos)

                ajax_cont += `
                        <br>
                        <center><h2 style="text-transform: uppercase;">${reporte.fecha}</h2></center>
                        <br>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark text-center table_titulo">
                                <th scope="col" colspan="6"><h5>COBRO DE CUOTAS</h5></th>
                            </thead>
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">COD</th>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">ASESOR</th>
                                    <th scope="col">DETALLE</th>
                                    <th scope="col">MODO</th>
                                    <th scope="col">MONTO</th>
                                </tr>
                            </thead>
                            <tbody id="suma_ingresos_cuotas">
                `;

                datos.forEach( datos => {
                    ajax_cont += `
                                <tr>
                                    <td>${datos.idmovimiento}</td>
                                    <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                    <td>${datos.usu_apellido_pat + " " + datos.usu_apellido_mat + " " + datos.usu_nombre}</td>
                                    <td>${datos.concepto}</td>
                                    <td>${datos.frecuencia}</td>
                                    <td>S/. ${datos.monto}</td>
                                <tr>      
                    `;
                });

                ajax_cont += `
                            </tbody>
                        </table>  
                `;

                $("#loader_reporte").html('');
                $("#load_ingreso").html(ajax_cont);


                $.ajax({
                    url: "../backend/panel/reportes/ajax_flujo_ingreso.php",
                    type: "GET",
                    data: {fecha:fecha, caja:caja},
                    success: function(response){
                        var datos = JSON.parse(response);
                        var ajax_cont = ``;
                        //console.log(datos)
                        datos.forEach( datos => {
                            if(datos.suma_cuotas!="" && datos.suma_cuotas!=null){
                                ajax_cont += `
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>TOTAL</b></td>
                                                    <td><b>S/. ${datos.suma_cuotas}</b></td>
                                                <tr>      
                                    `;
                            }
                        });
                        $("#suma_ingresos_cuotas").append(ajax_cont);
                    }
                });

            }
        });

        $.ajax({
            url: "../backend/panel/reportes/ajax_flujo_caja_egreso.php",
            type: "GET",
            data: {fecha:fecha, caja:caja},
            beforeSend: function(){
                $("#load_egreso").html("");
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;
                //console.log(datos)

                ajax_cont += `
                        <br>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark text-center table_titulo">
                                        <th scope="col" colspan="6"><h5>DESEMBOLSOS</h5></th>
                            </thead>
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">DETALLE</th>
                                    <th scope="col">MONTO</th>
                                </tr>
                            </thead>
                            <tbody id="suma_egresos_cuotas">
                `;

                datos.forEach( datos => {
                    ajax_cont += `
                                <tr>
                                    <td>${datos.idmovimiento}</td>
                                    <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                    <td class="text-center">${datos.concepto}<br>${datos.frecuencia}</td>
                                    <td>S/. ${datos.monto}</td>
                                <tr>      
                    `;
                });

                ajax_cont += `
                            </tbody>
                        </table>  
                `;

                $("#loader_reporte").html('');
                $("#load_egreso").html(ajax_cont);


                $.ajax({
                    url: "../backend/panel/reportes/ajax_flujo_egreso.php",
                    type: "GET",
                    data: {fecha:fecha, caja:caja},
                    success: function(response){
                        var datos = JSON.parse(response);
                        var ajax_cont = ``;
                        //console.log(datos)
                        datos.forEach( datos => {
                            if(datos.suma_cuotas!="" && datos.suma_cuotas!=null){
                                ajax_cont += `
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>TOTAL</b></td>
                                                    <td><b>S/. ${datos.suma_cuotas}</b></td>
                                                <tr>      
                                    `;
                            }
                        });
                        $("#suma_egresos_cuotas").append(ajax_cont);
                    }
                });

            }
        });

        $.ajax({
            url: "../backend/panel/reportes/ajax_flujo_caja_ingreso_otros.php",
            type: "GET",
            data: {fecha:fecha, caja:caja},
            beforeSend: function(){
                $("#load_ingreso_otros").html("");
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;
                //console.log(datos)

                ajax_cont += `
                        <br>          
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark text-center table_titulo">
                                        <th scope="col" colspan="6"><h5>OTROS INGRESOS</h5></th>
                            </thead>
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">T.</th>
                                    <th scope="col">N° DOC</th>
                                    <th scope="col">DETALLE</th>
                                    <th scope="col">MONTO</th>
                                </tr>
                            </thead>
                            <tbody id="suma_ingresos_otros">
                `;

                datos.forEach( datos => {
                    ajax_cont += `
                                <tr>
                                    <td>${datos.tipo_comprobante}</td>
                                    <td>${datos.nro_comprobante}</td>
                                    <td>${datos.concepto}</td>
                                    <td>S/. ${datos.monto}</td>
                                <tr>      
                    `;
                });

                ajax_cont += `
                            </tbody>
                        </table>  
                `;

                $("#loader_reporte").html('');
                $("#load_ingreso_otros").html(ajax_cont);


                $.ajax({
                    url: "../backend/panel/reportes/ajax_flujo_ingreso_otros.php",
                    type: "GET",
                    data: {fecha:fecha, caja:caja},
                    success: function(response){
                        var datos = JSON.parse(response);
                        var ajax_cont = ``;
                        //console.log(datos)
                        datos.forEach( datos => {
                            if(datos.suma_cuotas!="" && datos.suma_cuotas!=null){
                                ajax_cont += `
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>TOTAL</b></td>
                                                    <td><b>S/. ${datos.suma_cuotas}</b></td>
                                                <tr>      
                                    `;
                            }
                        });
                        $("#suma_ingresos_otros").append(ajax_cont);
                    }
                });

            }
        });

        $.ajax({
            url: "../backend/panel/reportes/ajax_flujo_caja_egreso_otros.php",
            type: "GET",
            data: {fecha:fecha, caja:caja},
            beforeSend: function(){
                $("#load_egreso_otros").html("");
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;
                //console.log(datos)

                ajax_cont += `
                        <br>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark text-center table_titulo">
                                        <th scope="col" colspan="6"><h5>OTROS EGRESOS</h5></th>
                            </thead>
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">T.</th>
                                    <th scope="col">N° DOC</th>
                                    <th scope="col">DETALLE</th>
                                    <th scope="col">MONTO</th>
                                </tr>
                            </thead>
                            <tbody id="suma_egresos_otros">
                `;

                datos.forEach( datos => {
                    ajax_cont += `
                                <tr>
                                    <td>${datos.tipo_comprobante}</td>
                                    <td>${datos.nro_comprobante}</td>
                                    <td>${datos.concepto}</td>
                                    <td>S/. ${datos.monto}</td>
                                <tr>      
                    `;
                });

                ajax_cont += `
                            </tbody>
                        </table>  
                `;

                $("#loader_reporte").html('');
                $("#load_egreso_otros").html(ajax_cont);


                $.ajax({
                    url: "../backend/panel/reportes/ajax_flujo_egreso_otros.php",
                    type: "GET",
                    data: {fecha:fecha, caja:caja},
                    success: function(response){
                        var datos = JSON.parse(response);
                        var ajax_cont = ``;
                        //console.log(datos)
                        datos.forEach( datos => {
                            if(datos.suma_cuotas!="" && datos.suma_cuotas!=null){
                                ajax_cont += `
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>TOTAL</b></td>
                                                    <td><b>S/. ${datos.suma_cuotas}</b></td>
                                                <tr>      
                                    `;
                            }
                        });
                        $("#suma_egresos_otros").append(ajax_cont);
                    }
                });

            }
        });


        $("#load_detalles").html(`
                        <br>
                        <center><h5>DETALLE DE CAJA</h5></center>
                        <table class="table table-striped table-bordered">
                            <tbody id="suma_detalles" class="text-center">
                            </tbody>
                        </table>
        `);


        $.ajax({
            url: "../backend/panel/reportes/ajax_flujo_detalle_inicio.php",
            type: "GET",
            data: {fecha:fecha, caja:caja},
            beforeSend: function(){
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;
                //console.log(response)
                datos.forEach( datos => {

                    reporte.caja = datos.monto_cierre;

                    ajax_cont += `
                                <tr>
                                    <td style="font-weight:bold;">TOTAL SALDO ANTERIOR</td>
                                    <td>S/. ${datos.monto_cierre}</td>
                                <tr>      
                    `;
                });
                $("#loader_reporte").html('');
                $("#suma_detalles").append(ajax_cont);

                $.ajax({
                    url: "../backend/panel/reportes/ajax_flujo_detalle_ingreso.php",
                    type: "GET",
                    data: {fecha:fecha, caja:caja},
                    beforeSend: function(){
                        $("#loader_reporte").html(`
                            <div style="">
                                <br>
                                <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                    <span class="sr-only">Loading...</span>
                                </div><br>
                                <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                            </div>
                        `); 
                    },
                    success: function(response){
                        var datos = JSON.parse(response);
                        var ajax_cont = ``;
                        //console.log(response)
                        datos.forEach( datos => {
                            if(datos.suma_ingresos!=null && datos.suma_ingresos!=""){
                                reporte.ingresos = datos.suma_ingresos;
                                ajax_cont += `
                                            <tr>
                                                <td style="font-weight:bold;">TOTAL INGRESOS</td>
                                                <td>S/. ${datos.suma_ingresos}</td>
                                            <tr>      
                                `;
                            }else{
                                reporte.ingresos = 0;
                                ajax_cont += `
                                            <tr>
                                                <td style="font-weight:bold;">TOTAL INGRESOS</td>
                                                <td>S/. 0</td>
                                            <tr>      
                                `;
                            }      
                        });
                        $("#loader_reporte").html('');
                        $("#suma_detalles").append(ajax_cont);

                        $.ajax({
                            url: "../backend/panel/reportes/ajax_flujo_detalle_egreso.php",
                            type: "GET",
                            data: {fecha:fecha, caja:caja},
                            beforeSend: function(){
                                $("#loader_reporte").html(`
                                    <div style="">
                                        <br>
                                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                                            <span class="sr-only">Loading...</span>
                                        </div><br>
                                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                                    </div>
                                `); 
                            },
                            success: function(response){
                                var datos = JSON.parse(response);
                                var ajax_cont = ``;
                                //console.log(response)
                                datos.forEach( datos => {
                                    if(datos.suma_egresos!=null && datos.suma_egresos!=""){
                                        reporte.egresos = datos.suma_egresos;
                                        ajax_cont += `
                                                    <tr>
                                                        <td style="font-weight:bold;">TOTAL EGRESOS</td>
                                                        <td>S/. ${datos.suma_egresos}</td>
                                                    <tr>      
                                        `;
                                    }else{
                                        reporte.egresos = 0;
                                        ajax_cont += `
                                                    <tr>
                                                        <td style="font-weight:bold;">TOTAL EGRESOS</td>
                                                        <td>S/. 0</td>
                                                    <tr>      
                                        `;
                                    }
                                });
                                $("#loader_reporte").html('');
                                $("#suma_detalles").append(ajax_cont);

                                if(reporte.caja!=null){
                                    $("#suma_detalles").append(`
                                        <tr>
                                            <td style="font-weight:bold;">TOTAL CAJA</td>
                                            <td>S/. ${parseFloat(reporte.caja) + parseFloat(reporte.ingresos) - parseFloat(reporte.egresos)}</td>
                                        <tr> 
                                    `);
                                }
                            }
                        });

                    }
                });

               

            }
        });


        $("#load_billetaje").html(`
                        <br>
                        <div class="row">
                            <div class="col-12"><center><h5>BILLETAJE EN SOLES</h5></center></div>
                            <div class="w-100"></div>
                            <div class="col-6">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th scope="col">BILLETES</th>
                                            <th scope="col">CANTIDAD</th>
                                            <th scope="col">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_billetaje_billetes" class="text-center">
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th scope="col">MONEDAS</th>
                                            <th scope="col">CANTIDAD</th>
                                            <th scope="col">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_billetaje_monedas" class="text-center">
                                    </tbody>
                                </table>
                            </div>
                        </row>
        `);
        
        $.ajax({
            url: "../backend/panel/reportes/ajax_flujo_billetaje.php",
            type: "GET",
            data: {fecha:fecha, caja:caja},
            beforeSend: function(){
                $("#tabla_billetaje_billetes").html("");
                $("#tabla_billetaje_monedas").html("");
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont1 = ``;
                var ajax_cont2 = ``;
                //console.log(datos)

                datos.forEach( datos => {
                    reporte.billetes = datos.t_billetes;
                    reporte.monedas = datos.t_monedas;
                    ajax_cont1 += `
                                <tr>
                                    <td>S/. 200</td>
                                    <td>${datos.m200}</td>
                                    <td>S/. ${datos.t200}</td>
                                <tr>
                                <tr>
                                    <td>S/. 100</td>
                                    <td>${datos.m100}</td>
                                    <td>S/. ${datos.t100}</td>
                                <tr> 
                                <tr>
                                    <td>S/. 50</td>
                                    <td>${datos.m50}</td>
                                    <td>S/. ${datos.t50}</td>
                                <tr> 
                                <tr>
                                    <td>S/. 20</td>
                                    <td>${datos.m20}</td>
                                    <td>S/. ${datos.t20}</td>
                                <tr> 
                                <tr>
                                    <td>S/. 10</td>
                                    <td>${datos.m10}</td>
                                    <td>S/. ${datos.t10}</td>
                                <tr>     
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">SUB TOTAL</td>   
                                    <td style="font-weight:bold;">S/. ${datos.t_billetes}</td>
                                <tr> 
                    `;
                    ajax_cont2 += `
                                <tr>
                                    <td>S/. 5</td>
                                    <td>${datos.m5}</td>
                                    <td>S/. ${datos.t5}</td>
                                <tr>
                                <tr>
                                    <td>S/. 2</td>
                                    <td>${datos.m2}</td>
                                    <td>S/. ${datos.t2}</td>
                                <tr> 
                                <tr>
                                    <td>S/. 1</td>
                                    <td>${datos.m1}</td>
                                    <td>S/. ${datos.t1}</td>
                                <tr> 
                                <tr>
                                    <td>S/. 0.50</td>
                                    <td>${datos.m0_5}</td>
                                    <td>S/. ${datos.t0_5}</td>
                                <tr> 
                                <tr>
                                    <td>S/. 0.20</td>
                                    <td>${datos.m0_2}</td>
                                    <td>S/. ${datos.t0_2}</td>
                                <tr>  
                                <tr>
                                    <td>S/. 0.10</td>
                                    <td>${datos.m0_1}</td>
                                    <td>S/. ${datos.t0_1}</td>
                                <tr>    
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">SUB TOTAL</td>   
                                    <td style="font-weight:bold;">S/. ${datos.t_monedas}</td>
                                <tr>     
                    `;
                });

                $("#loader_reporte").html('');
                $("#tabla_billetaje_billetes").html(ajax_cont1);
                $("#tabla_billetaje_monedas").html(ajax_cont2);

                $("#load_cierre").html(`
                                <br>
                                <table class="table table-striped table-bordered text-center">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight:bold;">TOTAL DE BILLETAJE</td>
                                            <td>S/. ${reporte.billetes + reporte.monedas}</td>
                                        <tr>
                                        <tr>
                                            <td style="font-weight:bold;">CIERRE DE CAJA</td>
                                            <td>S/. ${reporte.billetes + reporte.monedas}</td>
                                        <tr>
                                    </tbody>
                                </table>
                `);
            }
        });


        $("#load_hora").html(`
                        <br>
                        <center><h5>HORARIO DE APERTURA Y CIERRE DE CAJA</h5></center>
                        <table class="table table-striped table-bordered">
                            <tbody id="caja_horarios">
                            </tbody>
                        </table>
        `);

        $.ajax({
            url: "../backend/panel/reportes/ajax_flujo_horario.php",
            type: "GET",
            data: {fecha:fecha, caja:caja},
            beforeSend: function(){
                $("#caja_horarios").html("");
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;
                //console.log(datos)
                datos.forEach( datos => {
                 
                    ajax_cont += `
                                <tr>
                                    <td>HORA DE APERTURA DE CAJA</td>
                                    <td>${datos.fecha_apertura}</td>
                                <tr>
                                <tr>
                                    <td>HORA DE APERTURA DE CAJA</td>
                                    <td>${datos.fecha_cierre}</td>
                                <tr>
                               
                    `;
                   
                });

                $("#loader_reporte").html('');
                $("#caja_horarios").html(ajax_cont);
            }
        });


    }

    listarMoras(cliente){
        var tipo_bus = $("#mora_buscar_tipo").val();
        $.ajax({
            url: "../backend/panel/reportes/ajax_reporte_mora.php",
            type: "GET",
            data: {clave: cliente, tipo:tipo_bus},
            beforeSend: function(){
                $("#load_moras").html("");
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;
                //console.log(datos)

                var suma_prestamo = 0;
                var suma_capital_interes = 0;
                var suma_recaudado = 0;
                var suma_restante = 0;

                ajax_cont += `
    
                `;

                datos.forEach( datos => {
                    if(datos.atraso>0){
                        suma_prestamo += parseFloat(datos.monto);
                        suma_capital_interes += parseFloat(datos.capital_interes);
                        suma_recaudado += parseFloat(datos.recaudado);
                        suma_restante += parseFloat(datos.restante);

                        ajax_cont += `
                                    <tr class="text-center">
                                        <td>${datos.idcliente}</td>
                                        <td>${datos.idcredito}</td>
                                        <td>${datos.apellido_pat + " " + datos.apellido_mat + " " + datos.nombre}</td>
                                        <td>${datos.usu_apellido_pat + " " + datos.usu_apellido_mat + " " + datos.usu_nombre}</td>
                                        <td>${datos.fecha_desem}</td>
                                        <td class="rp_mora_1" style="background: rgb(207, 145, 166) !important;">S/.${datos.monto}</td>
                                        <td>${datos.interes}%</td>
                        `;

                        switch(datos.frecuencia){
                            case "DIARIO": 
                                                ajax_cont += `
                                                            <td>${datos.n_cuotas + " DIAS"}</td>
                                                `;
                                                break;    
                            case "SEMANAL": 
                                                ajax_cont += `
                                                            <td>${datos.n_cuotas + " SEMANAS"}</td>
                                                `;
                                                break;  
                            case "QUINCENAL": 
                                                ajax_cont += `
                                                            <td>${datos.n_cuotas + " QUINCENAS"}</td>
                                                `;
                                                break;  
                            case "MENSUAL": 
                                                ajax_cont += `
                                                            <td>${datos.n_cuotas + " MESES"}</td>
                                                `;
                                                break;  
                        }    

                        ajax_cont += `
                                        <td class="rp_mora_2" style="background: rgb(255, 187, 0) !important;">S/.${datos.capital_interes}</td>
                                        <td class="rp_mora_3" style="background: rgb(99, 255, 216) !important;">S/.${datos.recaudado}</td>
                                        <td class="rp_mora_4" style="background: rgb(237, 250, 55) !important;">S/.${datos.restante}</td>
                                        <td>${datos.hoy}</td>
                                        <td>${datos.atraso}</td>
                                        <td>S/.${datos.restante_mora}</td>
                                    <tr>      
                        `;
                    }

                });



                $("#loader_reporte").html('');
                $("#load_moras").html(ajax_cont);
                $("#load_moras").append(`
                                <tr class="text-center">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="rp_mora_1" style="background: rgb(207, 145, 166) !important;"><b>S/.${Math.ceil10(suma_prestamo,-1)}</b></td>
                                    <td></td>
                                    <td></td>
                                    <td class="rp_mora_2" style="background: rgb(255, 187, 0) !important;"><b>S/.${Math.ceil10(suma_capital_interes,-1)}</b></td>
                                    <td class="rp_mora_3" style="background: rgb(99, 255, 216) !important;"><b>S/.${Math.ceil10(suma_recaudado,-1)}</b></td>
                                    <td class="rp_mora_4" style="background: rgb(237, 250, 55) !important;"><b>S/.${Math.ceil10(suma_restante,-1)}</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <tr> 
                `);


            }
        });

    }

    listarCapital(caja){
        var suma_capital = 0;
       
        $.ajax({
            url: "../backend/panel/reportes/ajax_capital.php",
            type: "GET",
            data: {caja:caja},
            beforeSend: function(){
                $("#load_capital").html("");
                $("#loader_reporte_cap").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var ajax_cont = ``;

                ajax_cont += `
                        <br>
                        <center><h2 style="text-transform: uppercase;">REPORTE DE CAPITAL</h2></center>
                        <br>
                `;

                datos.forEach( datos => {
                    
                    suma_capital += parseFloat(datos.capital);
                    //console.log(suma_capital)
                    ajax_cont += `
                                <center>
                                <table class="col-6 table table-striped table-bordered tablas_rep_capital">
                                    <thead class="thead-dark text-center">
                                        <th scope="col" colspan="6" style="padding:3px;text-transform: uppercase;"><h5>${datos.nombre}</h5></th>
                                    </thead>
                                    <tbody class="thead-dark text-center">
                                        <tr>
                                            <td scope="col">CAPITAL DISPONIBLE</td>
                                            <td scope="col">S/. ${datos.capital}</td>
                                        </tr>
                                    </tbody>
                                </table> 
                                </center>
                    `;
                });


                ajax_cont += `
                            <br>
                            <center>
                            <table class="col-8 table table-striped table-bordered tablas_rep_capital">
                                <thead class="thead-dark text-center table_titulo">
                                    <th scope="col" colspan="6"><h5>CAPITAL DISPONIBLE</h5></th>
                                </thead>
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <td scope="col">TODAS LAS CAJAS</td>
                                        <td scope="col">S/. ${Math.ceil10(parseFloat(suma_capital),-1)}</td>
                                    </tr>
                                </thead>
                            </table> 
                            </center>
                `;

                $("#loader_reporte_cap").html('');
                $("#load_capital").html(ajax_cont);



            }
        });

    }

    listarMovimientos(inicio,fin){

        var mov_ingresos = 0;
        var mov_egresos = 0;

        reporte.fecha = "";
        reporte.diaSemanaIniFin(inicio);
        
        reporte.fecha = "";
        reporte.diaSemanaIniFin(fin);
  

        $.ajax({
            url: "../backend/panel/reportes/ajax_movimientos.php",
            type: "GET",
            data: {consulta: "buscar", inicio:inicio, fin:fin},
            beforeSend: function(){
                $("#load_data_reporte_mov").html('');
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                //console.log(datos);

                contenido_ajax += `
                        <br>
                        <center><h3 style="margin:20px 0px; text-transform: UPPERCASE;">REPORTE DE MOVIMIENTOS DEL <br> ${reporte.fecha} AL ${reporte.fecha_fin}</h3></center>
                        <br>
                        
                        <table class="table table-striped table-bordered tablas_rep_mov">
                                <thead class="thead-dark text-center">
                                    <th scope="col" colspan="6"><h5>MOVIMIENTOS</h5></th>
                                </thead>
                                <thead class="thead-dark text-center">
                                        <th scope="col">N°</th>
                                        <th scope="col">CAJA</th>
                                        <th scope="col">TIPO</th>
                                        <th scope="col">MONTO</th>
                                        <th scope="col">CONCEPTO</th>
                                        <th scope="col">FECHA</th>
                                </thead>
                                <tbody>
                `;

                datos.forEach( datos => {
                 
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.caja_nombre}</td>
                                        `;
                    
                    if(datos.tipo_mov=="INGRESO"){
                        mov_ingresos += parseFloat(datos.monto);
                        contenido_ajax += `
                            <td><center><span class="badge badge-pill badge-success">${datos.tipo_mov}</span></center></td>
                        `;
                    }else{
                        mov_egresos += parseFloat(datos.monto);
                        contenido_ajax += `
                            <td><center><span class="badge badge-pill badge-danger">${datos.tipo_mov}</span></center></td>
                        `;
                    }

                    contenido_ajax += `
                    
                                                
                                                <td>S/. ${datos.monto}</td>
                                                <td>${datos.concepto}</td>
                                                <td>${datos.fecha_mov}</td>
                                              
                                    `;
                     
                    contenido_ajax += `
                                            </tr>
                    `;
                    
                             
                });

                contenido_ajax += `
                            </tbody>
                        </table>

                        <div class="w-100"><br><br></div>

                        <table class="col-5 table table-striped table-bordered tablas_rep_mov">
                            <thead class="thead-dark text-center">
                                <th scope="col" colspan="2"><h5>INGRESOS</h5></th>
                            </thead>
                            <tbody>
                                <tr class="text-center font-weight-bold">
                                    <td>TOTAL</td>
                                    <td>S/. ${Math.ceil10(mov_ingresos,-1)}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="col-5 table table-striped table-bordered tablas_rep_mov">
                            <thead class="thead-dark text-center">
                                <th scope="col" colspan="2"><h5>EGRESOS</h5></th>
                            </thead>
                            <tbody>
                                <tr class="text-center font-weight-bold">
                                    <td>TOTAL</td>
                                    <td>S/. ${Math.ceil10(mov_egresos,-1)}</td>
                                </tr>
                            </tbody>
                        </table>
                `;
            
                $("#loader_reporte").html('');
                $("#load_data_reporte_mov").html(contenido_ajax);
                //console.log("listando")                 
            }
        });
    }

    listarPaga(inicio){

        var cuotas_ingresos = 0;

        reporte.fecha = "";
        reporte.diaSemana(inicio);
  

        $.ajax({
            url: "../backend/panel/reportes/ajax_paga.php",
            type: "GET",
            data: {consulta: "buscar", inicio:inicio},
            beforeSend: function(){
                $("#load_data_reporte_paga").html('');
                $("#loader_reporte").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;

                if(datos!="" && datos!=null){
                    if(datos[0].privilegios=="ROOT" || datos[0].privilegios=="ADMINISTRADOR"){
                        contenido_ajax += `
                            <div class="col-10">
                            <br>
                            <center><h3 style="margin:20px 0px; text-transform: UPPERCASE;">REPORTE DE CLIENTES QUE LES TOCA PAGAR EL <br> ${reporte.fecha}</h3></center>
                            <br>
                            
                            <table class="table table-striped table-bordered tablas_rep_mov">
                                    <thead class="thead-dark text-center">
                                        <th scope="col" colspan="6"><h5>REPORTE DE PAGA</h5></th>
                                    </thead>
                                    <thead class="thead-dark text-center">
                                            <th scope="col">N°</th>
                                            <th scope="col">CLIENTE</th>
                                            <th scope="col">ASESOR</th>
                                            <th scope="col">CUOTA</th>
                                            <!--<th scope="col">DEUDAS ANTERIORES</th>-->
                                    </thead>
                                    <tbody class="text-center">
                        `;
                    }else{
                        contenido_ajax += `
                            <div class="col-10">
                            <br>
                            <center><h3 style="margin:20px 0px; text-transform: UPPERCASE;">REPORTE DE CLIENTES QUE LES TOCA PAGAR EL <br> ${reporte.fecha}</h3></center>
                            <br>
                            
                            <table class="table table-striped table-bordered tablas_rep_mov">
                                    <thead class="thead-dark text-center">
                                        <th scope="col" colspan="6"><h5>REPORTE DE PAGA</h5></th>
                                    </thead>
                                    <thead class="thead-dark text-center">
                                            <th scope="col">N°</th>
                                            <th scope="col">CLIENTE</th>
                                            <th scope="col">CUOTA</th>
                                            <!--<th scope="col">DEUDAS ANTERIORES</th>-->
                                    </thead>
                                    <tbody class="text-center">
                        `;
                    }
                }else{
                    contenido_ajax += `
                            <div class="col-10">
                            <br>
                            <center><h3 style="margin:20px 0px; text-transform: UPPERCASE;">REPORTE DE CLIENTES QUE LES TOCA PAGAR EL <br> ${reporte.fecha}</h3></center>
                            <br>
                            
                            <table class="table table-striped table-bordered tablas_rep_mov">
                                    <thead class="thead-dark text-center">
                                        <th scope="col" colspan="6"><h5>REPORTE DE PAGA</h5></th>
                                    </thead>
                                    <thead class="thead-dark text-center">
                                            <th scope="col">N°</th>
                                            <th scope="col">CLIENTE</th>
                                            <th scope="col">CUOTA</th>
                                            <!--<th scope="col">DEUDAS ANTERIORES</th>-->
                                    </thead>
                                    <tbody class="text-center">
                        `;
                }  

                datos.forEach( datos => {
                 
                    conteo++;
                    cuotas_ingresos += parseFloat(datos.cuota_programada);

                    if(datos.privilegios=="ROOT" || datos.privilegios=="ADMINISTRADOR"){
                        contenido_ajax += `
                                <tr>
                                    <th scope="row">${conteo}</th>
                                    <td>${datos.cli_apellido_pat} ${datos.cli_apellido_mat} ${datos.cli_nombre}</td>
                                    <td>${datos.usu_apellido_pat} ${datos.usu_apellido_mat} ${datos.usu_nombre}</td>
                                    <td>S/. ${datos.cuota_programada}</td>
                                    <!--<td></td>-->
                                </tr>
                        `;     
                    }else{
                        contenido_ajax += `
                                <tr>
                                    <th scope="row">${conteo}</th>
                                    <td>${datos.cli_apellido_pat} ${datos.cli_apellido_mat} ${datos.cli_nombre}</td>
                                    <td>S/. ${datos.cuota_programada}</td>
                                    <!--<td></td>-->
                                </tr>
                        `;     
                    }
                     
                });

                contenido_ajax += `
                            </tbody>
                        </table>

                        <div class="w-100"><br><br></div>
                        <center>
                        <table class="col-5 table table-striped table-bordered tablas_rep_mov">
                            <thead class="thead-dark text-center">
                                <th scope="col" colspan="2"><h5>INGRESOS ESTIMADOS</h5></th>
                            </thead>
                            <tbody>
                                <tr class="text-center font-weight-bold">
                                    <td>TOTAL</td>
                                    <td>S/. ${Math.ceil10(cuotas_ingresos,-1)}</td>
                                </tr>
                            </tbody>
                        </table>
                        </center>
                </div>
                `;
            
                $("#loader_reporte").html('');
                $("#load_data_reporte_paga").html(contenido_ajax);
                //console.log("listando")                 
            }
        });
    }

    diaSemana() {
        var x = document.getElementById("reporte_fecha");

        if($("#reporte_fecha").val()==""){
            var f = new Date();
            var y = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
            $("#reporte_fecha").val(y);  
        }


        let date = new Date(x.value.replace(/-+/g, '/'));
      
        let options = {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        };


        reporte.fecha = date.toLocaleDateString('es-PE', options);
        //console.log(date.toLocaleDateString('es-MX', options));
      
    }

    diaSemanaIniFin() {
        var x = document.getElementById("flujo_inicio");
        var x2 = document.getElementById("flujo_fin");

        if($("#flujo_inicio").val()==""){
            var f = new Date();
            var y = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
            $("#flujo_inicio").val(y);  
        }
        if($("#flujo_fin").val()==""){
            var f = new Date();
            var y = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
            $("#flujo_fin").val(y);  
        }


        let date = new Date(x.value.replace(/-+/g, '/'));
        let date2 = new Date(x2.value.replace(/-+/g, '/'));
      
        let options = {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        };


        reporte.fecha = date.toLocaleDateString('es-PE', options);
        reporte.fecha_fin = date2.toLocaleDateString('es-PE', options);
        //console.log(date.toLocaleDateString('es-MX', options));
      
    }
}

class Cuenta{
    constructor(){
        this.idEdit = 0;
        this.metodo = 0; //1: guardar; 2: modificar
        this.formulario;
    }

    listar(){
        $.ajax({
            url: "../backend/panel/cuentas/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_cuenta_corriente").html('');
                $("#load_table_cuenta_corriente").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td class="text-center">S/. ${datos.monto}</td>
                                    `; 
                    
                    if(datos.estado=="HABILITADO"){
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 20px;">${datos.estado}</span></td>
                                    `;
                    }else{
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 20px;">${datos.estado}</span></td>
                                    `;
                    }
                     
                    
                    contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit_cuenta("corriente",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                        <!--<button style="width:110px;" type="button" class="btn btn-danger" onclick="modalsDelete('slide',${datos.id},'${datos.url_foto}');"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                }); 
            
                $("#load_table_cuenta_corriente").html('');
                $("#load_data_cuenta_corriente").html(contenido_ajax);     
            }
        });
    }
    listarPF(){
        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_cuenta_pf").html('');
                $("#load_table_cuenta_pf").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td class="text-center">${datos.fecha_inicio}</td>
                                                <td class="text-center">${datos.fecha_fin}</td>
                                                <td class="text-center">S/. ${datos.monto_inicio}</td>
                                                <td class="text-center">S/. ${datos.monto_fin}</td>
                                                <td class="text-center">${datos.interes}%</td>
                                    `; 
                    
                    switch(datos.estado){
                        case "HABILITADO":      contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-info" style="padding:4px 10px;">HABILITADO</span></td>`; break;
                        case "DESHABILITADO":   contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-warning" style="padding:4px 10px;">CONGELADO</span></td>`; break;
                        case "CUMPLIDO":        contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 10px;">CUMPLIDO</span></td>`; break;
                        case "VENCIDO":         contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 10px;">VENCIDO</span></td>`; break;
                    }
                
                     
                    
                    contenido_ajax += `
                                                <!--
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit_cuenta("pf",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                    </div>
                                                </td>
                                                -->
                                                <td><center><button type="button" class="btn btn-primary" onclick='btn_cuenta_print("pf",${datos.id});'><i class="fas fa-lg fa-ticket-alt"></i></button></center></td>
                                            </tr>
                    `;   
                }); 
            
                $("#load_table_cuenta_pf").html('');
                $("#load_data_cuenta_pf").html(contenido_ajax);     
            }
        });
    }
    listarPF_retiro(){
        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo_retiro/ajax_ver.php",
            type: "GET",
            data: {consulta: "buscar"},
            beforeSend: function(){
                $("#load_data_cuenta_pf_retiro").html('');
                $("#load_table_cuenta_pf_retiro").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th class="text-center" scope="row">${datos.id}</th>
                                                <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td class="text-center">${datos.fecha_inicio}</td>
                                                <td class="text-center">${datos.fecha_fin}</td>
                                                <td class="text-center">S/. ${datos.monto_inicio}</td>
                                                <td class="text-center">S/. ${datos.monto_fin}</td>
                                                <td class="text-center">${datos.interes}%</td>
                                    `; 
                    
                    switch(datos.estado){
                        case "HABILITADO":      contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-info" style="padding:4px 10px;">HABILITADO</span></td>
                                                        <td>
                                                            <div class="col text-center"> 
                                                                <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_retiro_cuenta("pf",${datos.id});'><i class="fas fa-donate"></i> Retirar</button>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                `; break;

                        case "DESHABILITADO":   contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-warning" style="padding:4px 10px;">CONGELADO</span></td>
                                                        <td></td>
                                                        <td></td>
                                                `; break;

                        case "CUMPLIDO":        contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 10px;">CUMPLIDO</span></td>
                                                        <td>
                                                            <div class="col text-center"> 
                                                                <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_retiro_cuenta("pf",${datos.id});'><i class="fas fa-donate"></i> Retirar</button>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                `; break;

                        case "VENCIDO":         contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 10px;">VENCIDO</span></td>
                                                        <td></td>
                                                        <td><center><button type="button" class="btn btn-primary" onclick='btn_cuenta_print("pf_retiro",${datos.id});'><i class="fas fa-lg fa-ticket-alt"></i></button></center></td>
                                                `; break;

                    }
                
                     
                    
                    contenido_ajax += `             
                                            </tr>
                    `;   

                }); 
            
                $("#load_table_cuenta_pf_retiro").html('');
                $("#load_data_cuenta_pf_retiro").html(contenido_ajax);     
            }
        });
    }

    registrar(){
        
        this.formulario.append("iduser",$("#inputCAJA-hidden").val()); 

        $.ajax({
            type: 'POST',
            url: '../backend/panel/cuentas/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        cuenta.listar();
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }
    registrarPF(){
        
        this.formulario.append("iduser",$("#inputCAJA-hidden").val()); 

        $.ajax({
            type: 'POST',
            url: '../backend/panel/cuentas/plazo_fijo/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response==200){                      
                    $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Registro Correcto!
                            </div>
                    `);
                    setTimeout(()=>{
                        cuenta.listarPF();
                        $('#modal-add').modal('hide');
                        $('.btn_modals').prop('disabled', false);
                        setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                    },600);
                }else{
                    $('.btn_modals').prop('disabled', false);
                    if(response==301){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                Se produjo un error al subir el archivo al servidor!
                            </div>
                        `);
                    }else{
                        if(response==302){    
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error con la base de datos!
                                </div>
                            `);
                        }else{
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    `+response+`
                                </div>
                            `);
                        }
                    }     
                }
                       
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }
    registrarPF_retiro(){
        
        this.formulario.append("iduser",$("#inputCAJA-hidden").val()); 
        this.formulario.append("idcuenta",cuenta.idEdit);

        $.ajax({
            type: 'POST',
            url: '../backend/panel/cuentas/plazo_fijo_retiro/ajax_registrar.php',
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                //console.log(response);
                if(response=="600"){
                    $("#msg-ajax-result").html(`
                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                            No hay fondos suficientes en la Caja!.
                        </div>
                    `);
                    setTimeout(()=>{
                        $('.btn_modals').prop('disabled', false);
                    },1000);
                }else{
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Registro Correcto!
                                </div>
                        `);
                        setTimeout(()=>{
                            cuenta.listarPF_retiro();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }     
                    }
                }      
            },
            timeout: 30000,
            error: function(xhr, status){
                $('.btn_modals').prop('disabled', false);
                $("#msg-ajax-result").html(`
                                            <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                                Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                            </div>
                `);      
            }
        });
    }

    editar(id){
        document.getElementById("formulario-cuenta_corriente").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("EDITAR CUENTA CORRIENTE");
        
        $.ajax({
            url: "../backend/panel/cuentas/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $('#inputCLIENT').val(datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat + " " + datos[0].cli_nombre);
                $('#inputCLIENT-hidden').val(datos[0].id);    

                if(datos[0].estado=='HABILITADO'){
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-danger btn_modals" onclick="cuenta.habilitar(${id},0);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Bloquear</button>
                    `);
                }else{
                    $(".modal-btn-cont").html(`
                        <button type="button" class="btn btn-primary btn_modals" onclick="cuenta.habilitar(${id},1);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Desbloquear</button>
                    `);
                }


            }
        });

    }
    editarPF(id){
        document.getElementById("formulario-cuenta_pf").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("EDITAR CUENTA A PLAZO FIJO");
        
        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $('#inputCLIENT').val(datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat + " " + datos[0].cli_nombre);
                $('#inputCLIENT-hidden').val(datos[0].id);
                
                $("#pf_MONTO_INI").val(datos[0].monto_inicio);
                $("#pf_MONTO_FIN").val(datos[0].monto_fin);
                $("#pf_FECHA_INI").val(datos[0].fecha_inicio_EDT);
                $("#pf_FECHA_FIN").val(datos[0].fecha_fin_EDT);
                $("#pf_INTERES").val(datos[0].interes);

                switch(datos[0].estado){
                    case "HABILITADO": 
                                        $(".modal-btn-cont").html(`
                                            <button type="button" class="btn btn-danger btn_modals" onclick="cuenta.habilitarPF(${id},0);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Congelar</button>
                                        `);
                                        break;

                    case "DESHABILITADO":
                                        $(".modal-btn-cont").html(`
                                            <button type="button" class="btn btn-primary btn_modals" onclick="cuenta.habilitarPF(${id},1);" style="width:155px;"><i class="fas fa-lg fa-user-lock"></i> Habilitar</button>
                                        `);
                                        break;
                }

            }
        });

    }
    editarPF_retiro(id){
        document.getElementById("formulario-cuenta_pf_retiro").reset();
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("RETIRAR CAPITAL DE CUENTA A PLAZO FIJO");
        
        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo_retiro/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $('#inputCLIENT').val(datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat + " " + datos[0].cli_nombre);
                $('#inputCLIENT-hidden').val(datos[0].id);
                
                $("#pf_MONTO_INI").val(datos[0].monto_inicio);
                $("#pf_MONTO_FIN").val(datos[0].monto_fin);
                $("#pf_FECHA_INI").val(datos[0].fecha_inicio_EDT);
                $("#pf_FECHA_FIN").val(datos[0].fecha_fin_EDT);
                $("#pf_INTERES").val(datos[0].interes);

                $("#pf_MONTO_FIN").addClass('is-valid');

            }
        });

    }

    editarDeposito(idcuenta,idcliente){
  
        $('#modal-add').modal('show'); 
        $('#modal-add h4').html("Modulo de Deposito");
            
        $.ajax({
            url: "../backend/panel/cuentas/depositos/ajax_movimientos_cc.php",
            type: "GET",
            data: {consulta: "editar", id: idcuenta},
            beforeSend: function(){
                $("#load_data_modal").html(`
                    <tr>
                        <th scope="row"></th><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <th scope="row"></th><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <th scope="row"></th><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <th scope="row"></th><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <th scope="row"></th><td></td><td></td><td></td>
                    </tr>
                `);
                $("#load_table_modal1").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var cont_ajax;

                datos.forEach( datos => {
                    cont_ajax_02 += `
                                    <tr>
                                        <th scope="row">${datos.id}</th>
                                        <td>${datos.fecha_mov}</td>
                                        <td>S/.${datos.monto_mov}</td>
                                        <td><button type="button" class="btn btn-primary" onclick='btn_cuenta_print("deposito",${datos.id});'><i class="fas fa-lg fa-ticket-alt"></i></button></td>
                                    `; 
                });

                $("#load_table_modal1").html('');
                $("#load_data_modal").html(cont_ajax);
                
            }
        });
    
    }

    editarSave(id){
     
        this.formulario.append("id",id);   
        this.formulario.append("editURLimg",this.editURLimg);   
        this.formulario.append("editURLimg2",this.editURLimg2);

        $.ajax({
            url: "backend/panel/clientes/ajax_editar.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Actualización Correcta!
                            </div>
                        `);
                        setTimeout(()=>{
                            cliente.listar();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            cliente.editURLimg = 0;
                            cliente.editURLimg2 = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }


    deposito(id){
        this.formulario.append("id",id);   

        $.ajax({
            url: "../backend/panel/cuentas/depositos/ajax_deposito.php",
            type: "POST",
            data: this.formulario,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                Se registro el pago correctamente!
                            </div>
                        `);
                        setTimeout(()=>{
                            cuenta.buscar_cliente_cobranza_refresh($("#inputCLIENT-hidden").val());
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            cuenta.idEdit = 0;
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },600);
                    }else{
                        $('.btn_modals').prop('disabled', false);
                        if(response==301){                      
                            $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Se produjo un error al subir el archivo al servidor!
                                </div>
                            `);
                        }else{
                            if(response==302){    
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        Se produjo un error con la base de datos!
                                    </div>
                                `);
                            }else{
                                $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                                `);
                            }
                        }
                    }   
            },
            timeout: 30000,
            error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
            }
        });
    }


    habilitar(id,operacion){
        $.ajax({
            url: "../backend/panel/cuentas/ajax_habilitar.php",
            type: "POST",
            data: {id: id, operacion:operacion},
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        setTimeout(()=>{
                            cuenta.listar();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },700);
                    }else{
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }
    habilitarPF(id,operacion){
        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo/ajax_habilitar.php",
            type: "POST",
            data: {id: id, operacion:operacion},
            beforeSend: function(){
                $('.btn_modals').prop('disabled', true);
                $("#msg-ajax-result").html(`
                    <div style="">
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `); 
            },
            success: function(response){
                    //console.log(response);
                    if(response==200){                      
                        $("#msg-ajax-result").html(`
                            <div class="alert alert-warning" role="alert"  style="margin-bottom: 10px;">
                                Se completo la operación!
                            </div>
                        `);
                        setTimeout(()=>{
                            cuenta.listarPF();
                            $('#modal-add').modal('hide');
                            $('.btn_modals').prop('disabled', false);
                            setTimeout(()=>{$("#msg-ajax-result").html("");},700);
                        },700);
                    }else{
                        $("#msg-ajax-result").html(`
                                    <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                        `+response+`
                                    </div>
                        `);
                    }   
                },
                timeout: 30000,
                error: function(xhr, status){
                    $('.btn_modals').prop('disabled', false);
                    $("#msg-ajax-result").html(`
                                <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                    Disculpe, existió un problema - `+xhr.status+` `+xhr.statusText+`
                                </div>
                    `);
                    
                }
        });
    }

    voucherPF(id){
        $("#voucher-datos01").html("");
        $('#modal-ticket').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $("#voucher-titulo").html(`VOUCHER DE DEPÓSITO`);
                $("#voucher-datos01").html(`
                    <tr>
                        <td>FECHA DEPÓSITO</td>
                        <td>:</td>
                        <td>${datos[0].fecha_inicio}</td>
                    </tr>
                    <tr>
                        <td>FECHA PACTADA</td>
                        <td>:</td>
                        <td>${datos[0].fecha_fin}</td>
                    </tr>
                    <!--
                    <tr>
                        <td>DIRECCIÓN</td>
                        <td>:</td>
                        <td>Jr. Parra del Riego 585</td>
                    </tr>
                    -->
             
                    <tr>
                        <td>INTERES</td>
                        <td>:</td>
                        <td>${datos[0].interes} %</td>
                    </tr>
                    <tr>
                        <td>MONTO DEPOSITADO</td>
                        <td>:</td>
                        <td>S/. ${datos[0].monto_inicio}</td>
                    </tr>
                    <tr>
                        <td>MONTO AL FINAL DEL PLAZO</td>
                        <td>:</td>
                        <td>S/. ${datos[0].monto_fin}</td>
                    </tr>
                    <tr>
                        <td>CONCEPTO</td>
                        <td>:</td>
                        <td>DEPOSITO A PLAZO FIJO</td>
                    </tr>
                    <tr>
                        <td>NRO DE CUENTA</td>
                        <td>:</td>
                        <td>${datos[0].id}</td>
                    </tr>
                    <tr>
                        <td>AUTORIZA</td>
                        <td>:</td>
                        <td>CAJERO</td>
                    </tr>
                    <tr>
                        <td>CLIENTE</td>
                        <td>:</td>
                        <td>${datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat + " " + datos[0].cli_nombre}</td>
                    </tr>
                   
                    <tr>
                        <td>CAJERO</td>
                        <td>:</td>
                        <td>${datos[0].usu_nombre + " " + datos[0].usu_apellido_pat + " " + datos[0].usu_apellido_mat}</td>
                    </tr>
                `);

                $("#voucher-datos02").html(`
                   
                `);

            }
        });
    }
    voucherPF_retiro(id){
        $("#voucher-datos01").html("");
        $('#modal-ticket').modal('show'); 
        
        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo_retiro/ajax_ver.php",
            type: "GET",
            data: {consulta: "editar", id: id},
            success: function(response){
                var datos = JSON.parse(response);
                //console.log(datos[0]);
                
                $("#voucher-titulo").html(`VOUCHER DE RETIRO`);
                $("#voucher-datos01").html(`
                    <tr>
                        <td>FECHA RETIRO</td>
                        <td>:</td>
                        <td>${datos[0].fecha_retiro}</td>
                    </tr>
                    <tr>
                        <td>FECHA DEPÓSITO</td>
                        <td>:</td>
                        <td>${datos[0].fecha_inicio}</td>
                    </tr>
                    <tr>
                        <td>FECHA PACTADA</td>
                        <td>:</td>
                        <td>${datos[0].fecha_fin}</td>
                    </tr>
                    <!--
                    <tr>
                        <td>DIRECCIÓN</td>
                        <td>:</td>
                        <td>Jr. Parra del Riego 585</td>
                    </tr>
                    -->
             
                    <tr>
                        <td>INTERES</td>
                        <td>:</td>
                        <td>${datos[0].interes} %</td>
                    </tr>
                    <tr>
                        <td>MONTO INICIAL</td>
                        <td>:</td>
                        <td>S/. ${datos[0].monto_inicio}</td>
                    </tr>
                    <tr>
                        <td>MONTO RETIRADO</td>
                        <td>:</td>
                        <td>S/. ${datos[0].monto_fin}</td>
                    </tr>
                    <tr>
                        <td>CONCEPTO</td>
                        <td>:</td>
                        <td>RETIRO DE CUENTA A PLAZO FIJO</td>
                    </tr>
                    <tr>
                        <td>NRO DE CUENTA</td>
                        <td>:</td>
                        <td>${datos[0].id}</td>
                    </tr>
                    <tr>
                        <td>AUTORIZA</td>
                        <td>:</td>
                        <td>CAJERO</td>
                    </tr>
                    <tr>
                        <td>CLIENTE</td>
                        <td>:</td>
                        <td>${datos[0].cli_apellido_pat + " " + datos[0].cli_apellido_mat + " " + datos[0].cli_nombre}</td>
                    </tr>
                   
                    <tr>
                        <td>CAJERO</td>
                        <td>:</td>
                        <td>${datos[0].usu_nombre + " " + datos[0].usu_apellido_pat + " " + datos[0].usu_apellido_mat}</td>
                    </tr>
                `);

                $("#voucher-datos02").html(`
                   
                `);

            }
        });
    }


    buscar_pf(clave){

        var tipo_bus = $("#cuenta_buscar_tipo").val();

        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo/ajax_buscar_cuenta.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_cuenta_pf").html('');
                $("#load_table_cuenta_pf").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td class="text-center">${datos.fecha_inicio}</td>
                                                <td class="text-center">${datos.fecha_fin}</td>
                                                <td class="text-center">S/. ${datos.monto_inicio}</td>
                                                <td class="text-center">S/. ${datos.monto_fin}</td>
                                                <td class="text-center">${datos.interes}%</td>
                                    `; 
                    
                    switch(datos.estado){
                        case "HABILITADO":      contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-info" style="padding:4px 10px;">HABILITADO</span></td>`; break;
                        case "DESHABILITADO":   contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-warning" style="padding:4px 10px;">CONGELADO</span></td>`; break;
                        case "CUMPLIDO":        contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 10px;">CUMPLIDO</span></td>`; break;
                        case "VENCIDO":         contenido_ajax += `<td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 10px;">VENCIDO</span></td>`; break;
                    }
                
                     
                    
                    contenido_ajax += `
                                                <!--
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_edit_cuenta("pf",${datos.id});'><i class="fas fa-edit"></i> Editar</button>
                                                    </div>
                                                </td>
                                                -->
                                                <td><center><button type="button" class="btn btn-primary" onclick='btn_cuenta_print("pf",${datos.id});'><i class="fas fa-lg fa-ticket-alt"></i></button></center></td>
                                            </tr>
                    `;   
                }); 
            
                $("#load_table_cuenta_pf").html('');
                $("#load_data_cuenta_pf").html(contenido_ajax);     
            }
        });
    }
    buscar_pf_retiro(clave){

        var tipo_bus = $("#cuenta_buscar_tipo").val();

        $.ajax({
            url: "../backend/panel/cuentas/plazo_fijo_retiro/ajax_buscar_cuenta.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_cuenta_pf_retiro").html('');
                $("#load_table_cuenta_pf_retiro").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th class="text-center" scope="row">${datos.id}</th>
                                                <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td class="text-center">${datos.fecha_inicio}</td>
                                                <td class="text-center">${datos.fecha_fin}</td>
                                                <td class="text-center">S/. ${datos.monto_inicio}</td>
                                                <td class="text-center">S/. ${datos.monto_fin}</td>
                                                <td class="text-center">${datos.interes}%</td>
                                    `; 
                    
                    switch(datos.estado){
                        case "HABILITADO":      contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-info" style="padding:4px 10px;">HABILITADO</span></td>
                                                        <td>
                                                            <div class="col text-center"> 
                                                                <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_retiro_cuenta("pf",${datos.id});'><i class="fas fa-donate"></i> Retirar</button>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                `; break;

                        case "DESHABILITADO":   contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-warning" style="padding:4px 10px;">CONGELADO</span></td>
                                                        <td></td>
                                                        <td></td>
                                                `; break;

                        case "CUMPLIDO":        contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 10px;">CUMPLIDO</span></td>
                                                        <td>
                                                            <div class="col text-center"> 
                                                                <button style="width:110px;" type="button" class="btn btn-primary" onClick='btn_retiro_cuenta("pf",${datos.id});'><i class="fas fa-donate"></i> Retirar</button>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                `; break;

                        case "VENCIDO":         contenido_ajax += `
                                                        <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 10px;">VENCIDO</span></td>
                                                        <td></td>
                                                        <td><center><button type="button" class="btn btn-primary" onclick='btn_cuenta_print("pf",${datos.id});'><i class="fas fa-lg fa-ticket-alt"></i></button></center></td>
                                                `; break;

                    }
                
                     
                    
                    contenido_ajax += `             
                                            </tr>
                    `;   

                }); 
            
                $("#load_table_cuenta_pf_retiro").html('');
                $("#load_data_cuenta_pf_retiro").html(contenido_ajax);     
            }
        });
    }

    buscarUserCaja(){
        $.ajax({
            url: "../backend/panel/cuentas/ajax_buscar_cajero.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
        
                if(datos!="" && datos!=null){
                    $("#inputCAJA").removeClass("is-invalid");
                    $("#inputCAJA").addClass("is-valid");
                    $("#inputCAJA-hidden").val(datos[0].idcajero);
                    $("#inputCAJA").val(datos[0].nombre + " " + datos[0].apellido_pat + " " + datos[0].apellido_mat);
                }else{
                    $("#inputCAJA").removeClass("is-valid");
                    $("#inputCAJA").addClass("is-invalid");
                }
            }
        });
    }
    buscarFechaHora(){
        $.ajax({
            url: "../backend/panel/solicitud_fecha_hora.php",
            type: "GET",
            success: function(response){
                var datos = JSON.parse(response);
                $('#pf_FECHA_INI').val(datos[0].fecha);
            }
        });
    }

    buscar_cliente_deposito(clave){

        var tipo_bus = $("#cuenta_buscar_tipo").val();

        $.ajax({
            url: "../backend/panel/cuentas/depositos/ajax_buscar_cuenta.php",
            type: "GET",
            data: {clave: clave,tipo:tipo_bus},
            beforeSend: function(){
                $("#load_data_cuenta").html('');
                $("#load_table_cuenta").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td class="text-center">S/. ${datos.monto}</td>
                                    `; 
                    
                    if(datos.estado=="HABILITADO"){
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 20px;">${datos.estado}</span></td>
                                    `;
                    }else{
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 20px;">${datos.estado}</span></td>
                                    `;
                    }
                     
                    
                    contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:160px;" type="button" class="btn btn-primary" onClick="btn_edit_deposito(${datos.id},${datos.idcliente});"><i class="fas fa-lg fa-donate"></i> Depositar</button>
                                                        <!--<button style="width:110px;" type="button" class="btn btn-danger" onclick="modalsDelete('slide',${datos.id},'${datos.url_foto}');"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                }); 
            
                $("#load_table_cuenta").html('');
                $("#load_data_cuenta").html(contenido_ajax);     
            }
        });
    }
    buscar_cliente_deposito_autocomplete(clave){
        $.ajax({
            url: "../backend/panel/cuentas/ajax_buscar_cliente_id.php",
            type: "GET",
            data: {clave: clave},
            success: function(response){
                var resultados = JSON.parse(response);
                //console.log(resultados[0].nombre);    
                $("#inputCLIENT").addClass("is-valid");
                $("#inputCLIENT").val(resultados[0].nombre + " " + resultados[0].apellido_pat + " " + resultados[0].apellido_mat);
                $("#inputCLIENT-hidden").val(resultados[0].id);
              
            }
        });
    }
    buscar_cliente_cobranza_refresh(clave){
        $.ajax({
            url: "../backend/panel/cuentas/depositos/ajax_buscar_cuenta_refresh.php",
            type: "GET",
            data: {clave: clave},
            beforeSend: function(){
                $("#load_data_cuenta").html('');
                $("#load_table_cuenta").html(`
                    <div style="">
                        <br>
                        <div class="spinner-border text-info" role="status" style="position:relative;left:50%;float:left;">
                            <span class="sr-only">Loading...</span>
                        </div><br>
                        <span style="position:relative;left:50%;float:left;transform:translateX(-67%);margin-top:15px;">Loading...</span>
                    </div>
                `); 
            },
            success: function(response){
                var datos = JSON.parse(response);
                var contenido_ajax = "";
                var conteo = 0;
                datos.forEach( datos => {
                    conteo++;
                    contenido_ajax += `
                                            <tr>
                                                <th scope="row">${conteo}</th>
                                                <td>${datos.cli_apellido_pat + " " + datos.cli_apellido_mat + " " + datos.cli_nombre}</td>
                                                <td class="text-center">S/. ${datos.monto}</td>
                                    `; 
                    
                    if(datos.estado=="HABILITADO"){
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-success" style="padding:4px 20px;">${datos.estado}</span></td>
                                    `;
                    }else{
                        contenido_ajax += `
                                                <td class="text-center"><span class="badge badge-pill badge-danger" style="padding:4px 20px;">${datos.estado}</span></td>
                                    `;
                    }
                     
                    
                    contenido_ajax += `
                                                <td>
                                                    <div class="col text-center"> 
                                                        <button style="width:160px;" type="button" class="btn btn-primary" onClick="btn_edit_deposito(${datos.id},${datos.idcliente});"><i class="fas fa-lg fa-donate"></i> Depositar</button>
                                                        <!--<button style="width:110px;" type="button" class="btn btn-danger" onclick="modalsDelete('slide',${datos.id},'${datos.url_foto}');"><i class="fas fa-times-circle"></i> Eliminar</button>-->
                                                    </div>
                                                </td>
                                            </tr>
                    `;   
                }); 
            
                $("#load_table_cuenta").html('');
                $("#load_data_cuenta").html(contenido_ajax);     
            }
        });
    }

    calcular_pf_interes(){
        var monto = parseFloat($("#pf_MONTO_INI").val());
        var interes = parseFloat($("#pf_INTERES").val());
        var monto_final = monto + ((monto*interes)/100);

        $("#pf_MONTO_FIN").val(Math.ceil10(monto_final,-1));

    }
}




var solicitud_monto;
var solicitud_cuotas;
var solicitud_frecuencia;
var solicitud_interes;
var solicitud_inicio;

var interes_cuota_final;

var datalist_id_cliente;
var datalist_id_conyugue;
var datalist_id_aval;
var datalist_id_cajero;
var datalist_id_resp_trans;

var user;
var cliente;
var conyugue;
var negocio;
var credito;
var caja;
var reporte;
var cuenta;




$(document).ready(()=>{

    setInterval(()=>{
        var menuY = $("body")[0].offsetHeight;
        var screemY = window.innerHeight;
        var Yheader = $("header").height();  
        if(menuY<screemY){
            $(".menu_nav").css("height", screemY-Yheader);
        }else{
            $(".menu_nav").css("height", menuY-Yheader);
        }
    },200);

    user = new Usuario();
    cliente = new Cliente();
    conyugue = new Conyugue();
    negocio = new Negocio();
    credito = new Credito();
    caja = new Caja();
    reporte = new Reporte();
    cuenta = new Cuenta();


    user.listar();
    cliente.listar();
    credito.listarSolicitudes();
    credito.listarAprobaciones();
    credito.listarDesembolsos();
    caja.listarCajas();
    caja.listarAperturas();
    caja.listarMovimientos(0);
    caja.listarTransferencias(0);

    reporte.buscarCajas();
    reporte.listarCapital("TODOS");

    cuenta.listarPF();
    cuenta.listarPF_retiro();



    $("#inputCLIENT").change(()=>{
        datalist_id_cliente = $("#clientes option[value='" + $('#inputCLIENT').val() + "']").attr('data-id');
        $("#inputCLIENT-hidden").val(datalist_id_cliente);
        $("#inputCONY_AJAX").attr("readonly","readonly");
        $("#inputCONY_AJAX").val("");
        $("#inputCONY_AJAX").removeClass("is-valid");
        $("#inputCONY_AJAX").removeClass("is-invalid");
        $("#inputCONY_AJAX-hidden").val("");
        $("#inputAVAL_AJAX").attr("readonly","readonly");
        $("#inputAVAL_AJAX").val("");
        $("#inputAVAL_AJAX").removeClass("is-valid");
        $("#inputAVAL_AJAX").removeClass("is-invalid");
        $("#inputAVAL_AJAX-hidden").val("");
        $("#inputCONY").prop('checked',false);
        $("#inputAVAL").prop('checked',false);

        if($("#inputCLIENT-hidden").val()==""){
            $("#inputCLIENT").removeClass("is-valid");
            $("#inputCLIENT").addClass("is-invalid");

            $("#inputCONY_AJAX").attr("readonly","readonly");
            $("#inputCONY_AJAX").val("");
            $("#inputCONY_AJAX").removeClass("is-valid");
            $("#inputCONY_AJAX").removeClass("is-invalid");
            $("#inputCONY_AJAX-hidden").val("");
            $("#inputAVAL_AJAX").attr("readonly","readonly");
            $("#inputAVAL_AJAX").val("");
            $("#inputAVAL_AJAX").removeClass("is-valid");
            $("#inputAVAL_AJAX").removeClass("is-invalid");
            $("#inputAVAL_AJAX-hidden").val("");
            $("#inputCONY").prop('checked',false);
            $("#inputAVAL").prop('checked',false);

        }else{
            $("#inputCLIENT").removeClass("is-invalid");
            $("#inputCLIENT").addClass("is-valid");
        }
    });

    $("#inputCONY_AJAX").change(()=>{
        datalist_id_conyugue = $("#conyugue-list-ajax option[value='" + $('#inputCONY_AJAX').val() + "']").attr('data-id');
        $("#inputCONY_AJAX-hidden").val(datalist_id_conyugue);

        if($("#inputCONY_AJAX-hidden").val()==""){
            $("#inputCONY_AJAX").removeClass("is-valid");
            $("#inputCONY_AJAX").addClass("is-invalid");
        }else{
            $("#inputCONY_AJAX").removeClass("is-invalid");
            $("#inputCONY_AJAX").addClass("is-valid");
        }
    });
    $("#inputAVAL_AJAX").change(()=>{
        datalist_id_aval = $("#aval-list-ajax option[value='" + $('#inputAVAL_AJAX').val() + "']").attr('data-id');
        $("#inputAVAL_AJAX-hidden").val(datalist_id_aval);

        if($("#inputAVAL_AJAX-hidden").val()==""){
            $("#inputAVAL_AJAX").removeClass("is-valid");
            $("#inputAVAL_AJAX").addClass("is-invalid");
        }else{
            $("#inputAVAL_AJAX").removeClass("is-invalid");
            $("#inputAVAL_AJAX").addClass("is-valid");
        }
    });

    $("#caja_autor").change(()=>{
        datalist_id_cajero = $("#cajeros_resp option[value='" + $('#caja_autor').val() + "']").attr('data-id');
        $("#caja_autor-hidden").val(datalist_id_cajero);

        if($("#caja_autor-hidden").val()==""){
            $("#caja_autor").removeClass("is-valid");
            $("#caja_autor").addClass("is-invalid");
        }else{
            $("#caja_autor").removeClass("is-invalid");
            $("#caja_autor").addClass("is-valid");
        }
    });
    $("#caja_autor-edt").change(()=>{
        datalist_id_cajero = $("#cajeros_resp-edt option[value='" + $('#caja_autor-edt').val() + "']").attr('data-id');
        $("#caja_autor-hidden-edt").val(datalist_id_cajero);

        if($("#caja_autor-hidden-edt").val()==""){
            $("#caja_autor-edt").removeClass("is-valid");
            $("#caja_autor-edt").addClass("is-invalid");
        }else{
            $("#caja_autor-edt").removeClass("is-invalid");
            $("#caja_autor-edt").addClass("is-valid");
        }
    });
  

    $("#movimiento_autoriza").change(()=>{
        datalist_id_resp_trans = $("#admins-list option[value='" + $('#movimiento_autoriza').val() + "']").attr('data-id');
        $("#movimiento_autoriza-hidden").val(datalist_id_resp_trans);

        if($("#movimiento_autoriza-hidden").val()==""){
            $("#movimiento_autoriza").removeClass("is-valid");
            $("#movimiento_autoriza").addClass("is-invalid");
        }else{
            $("#movimiento_autoriza").removeClass("is-invalid");
            $("#movimiento_autoriza").addClass("is-valid");
        }
    });


    $("#inputCONY").change(()=>{
        if($("#inputCONY").is(':checked')){
            $("#inputCONY_AJAX").removeAttr("readonly");
        }else{
            $("#inputCONY_AJAX").attr("readonly","readonly");
            $("#inputCONY_AJAX").val("");
            $("#inputCONY_AJAX").removeClass("is-valid");
            $("#inputCONY_AJAX").removeClass("is-invalid");
            $("#inputCONY_AJAX-hidden").val("");
        }
    });
    $("#inputAVAL").change(()=>{
        if($("#inputAVAL").is(':checked')){
            $("#inputAVAL_AJAX").removeAttr("readonly");
        }else{
            $("#inputAVAL_AJAX").attr("readonly","readonly");
            $("#inputAVAL_AJAX").val("");
            $("#inputAVAL_AJAX").removeClass("is-valid");
            $("#inputAVAL_AJAX").removeClass("is-invalid");
            $("#inputAVAL_AJAX-hidden").val("");
        }
    });



    $("#input_trans_SOAT").change(()=>{
        if($("#input_trans_SOAT").val()=="SI"){
            $("#input_trans_SOAT_CAD").removeAttr("readonly");
            $("#input_trans_SOAT_CAD").prop('required',true);
        }else{
            $("#input_trans_SOAT_CAD").attr("readonly","readonly");
            $("#input_trans_SOAT_CAD").prop('required',false);
            $("#input_trans_SOAT_CAD").val('');
        }
    });
    $("#input_trans_TARJETA").change(()=>{
        if($("#input_trans_TARJETA").val()=="SI"){
            $("#input_trans_TARJETA_CAD").removeAttr("readonly");
            $("#input_trans_TARJETA_CAD").prop('required',true);
        }else{
            $("#input_trans_TARJETA_CAD").attr("readonly","readonly");
            $("#input_trans_TARJETA_CAD").prop('required',false);
            $("#input_trans_TARJETA_CAD").val('');
        }
    });




    $('#formulario-usuarios').on('submit', function (event) {
        event.preventDefault();
        user.formulario = new FormData(this);
        switch(user.metodo){
            case 1: user.registrar(); break;
            case 2: user.editarSave(user.idEdit); break;
        }     
    });
    $('#formulario-clientes').on('submit', function (event) {
        event.preventDefault();
        cliente.formulario = new FormData(this);
        switch(cliente.metodo){
            case 1: cliente.registrar(); break;
            case 2: cliente.editarSave(cliente.idEdit); break;
        }     
    });
    $('#formulario-conyugue').on('submit', function (event) {
        event.preventDefault();
        conyugue.formulario = new FormData(this);
        switch(conyugue.metodo){
            case 1: conyugue.registrar(cliente.idEdit); break;
            case 2: conyugue.editarSave(conyugue.idEdit,conyugue.tipo); break;
        }     
    });
    $('#formulario-negocio').on('submit', function (event) {
        event.preventDefault();
        negocio.formulario = new FormData(this);
        switch(negocio.metodo){
            case 1: negocio.registrar(cliente.idEdit); break;
            case 2: negocio.editarSave(negocio.idEdit); break;
        }     
    });
    $('#formulario-transporte').on('submit', function (event) {
        event.preventDefault();
        negocio.formulario = new FormData(this);
        switch(negocio.metodo){
            case 1: negocio.registrar(cliente.idEdit); break;
            case 2: negocio.editarSave(negocio.idEdit); break;
        }     
    });
    $('#formulario-consumo').on('submit', function (event) {
        event.preventDefault();
        negocio.formulario = new FormData(this);
        switch(negocio.metodo){
            case 1: negocio.registrarConsumo(cliente.idEdit); break;
            case 2: negocio.editarSaveConsumo(negocio.idEdit); break;
        }     
    });
    $('#formulario-solicitud').on('submit', function (event) {
        event.preventDefault();
        credito.formulario = new FormData(this);
        switch(credito.metodo){
            case 1: credito.registrarSolicitud(); break;
            case 2: credito.editarSaveSolicitud(credito.idEdit); break;
        }     
    });
    $('#formulario-aprobacion').on('submit', function (event) {
        event.preventDefault();
        credito.formulario = new FormData(this);
        switch(credito.metodo){
            case 1: break;
            case 2: credito.editarSaveAprobacion(credito.idEdit); break;
        }     
    });
    $('#formulario-desembolso').on('submit', function (event) {
        event.preventDefault();
        credito.formulario = new FormData(this);
        credito.desembolsar(credito.idEdit,1);
    });
    $('#formulario-cobranza').on('submit', function (event) {
        event.preventDefault();
        credito.formulario = new FormData(this);
        credito.cobranza(credito.idEdit);
    });
    $('#formulario-condonar').on('submit', function (event) {
        event.preventDefault();
        credito.formulario = new FormData(this);
        credito.condonar(credito.idEdit);
    });
    $('#formulario-caja').on('submit', function (event) {
        event.preventDefault();
        caja.formulario = new FormData(this);
        switch(caja.metodo){
            case 1: caja.crearCaja(); break;
            case 2: caja.editarSaveCaja(caja.idEdit); break;
        }     
    });
    $('#formulario-caja-edt').on('submit', function (event) {
        event.preventDefault();
        caja.formulario = new FormData(this);
        switch(caja.metodo){
            case 1: caja.crearCaja(); break;
            case 2: caja.editarSaveCaja(caja.idEdit); break;
        }     
    });
    $('#formulario-movimientos').on('submit', function (event) {
        event.preventDefault();
        caja.formulario = new FormData(this);
        switch(caja.metodo){
            case 1: caja.registrarMovimiento(); break;
            //case 2: caja.editarSaveCaja(caja.idEdit); break;
        }     
    });
    $('#formulario-transferencias').on('submit', function (event) {
        event.preventDefault();
        caja.formulario = new FormData(this);
        switch(caja.metodo){
            case 1: caja.registrarTransferencia(); break;
            //case 2: caja.editarSaveCaja(caja.idEdit); break;
        }     
    });

    $('#formulario-cuenta_pf').on('submit', function (event) {
        event.preventDefault();
        cuenta.formulario = new FormData(this);
        switch(cuenta.metodo){
            case 1: cuenta.registrarPF(); break;
            case 2: cuenta.editarSavePF(cuenta.idEdit); break;
        }     
    });

    $('#formulario-cuenta_pf_retiro').on('submit', function (event) {
        event.preventDefault();
        cuenta.formulario = new FormData(this);
        switch(cuenta.metodo){
            case 1: cuenta.registrarPF_retiro(); break;
            case 2: cuenta.editarSavePF_retiro(cuenta.idEdit); break;
        }     
    });

    $('#formulario-deposito_cc').on('submit', function (event) {
        event.preventDefault();
        cuenta.formulario = new FormData(this);
        cuenta.deposito(cuenta.idEdit);
    });




    user.btn_img = document.getElementById('inputIMG');
    user.btn_img.addEventListener('change', (event) => {
        user.editURLimg = 1;
    });

    cliente.btn_img = document.getElementById('inputIMG');
    cliente.btn_img2 = document.getElementById('inputCROQ');
    cliente.btn_img.addEventListener('change', (event) => {
        cliente.editURLimg = 1;
    });
    cliente.btn_img2.addEventListener('change', (event) => {
        cliente.editURLimg2 = 1;
    });

    negocio.btn_img = document.getElementById('input_neg_CROQUIS');
    negocio.btn_img2 = document.getElementById('input_trans_CROQUIS');
    negocio.btn_img.addEventListener('change', (event) => {
        negocio.editURLimg = 1;
    });
    negocio.btn_img2.addEventListener('change', (event) => {
        negocio.editURLimg2 = 1;
    });






}); 
  







function btn_add(modulo){
    switch(modulo){
        case "usuarios":    $(".nav-item").removeClass("active");
                            $("#nav-general-tab").addClass("active");
                            $(".tab-pane").removeClass("active show");
                            $("#nav-general").addClass("active show");
                            document.getElementById("formulario-usuarios").reset(); 
                            $("#modal-add h4").html("Nuevo Usuario"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            $("#load_foto_modal").html(`<img src="img/user.png" width="100%">`); 
                            user.idEdit = 0;
                            user.metodo = 1; 
                            user.editURLimg = 0;
                            break;

        case "clientes":    $("#nav-conyugue-tab").addClass("disabled");
                            $("#nav-negocio-tab").addClass("disabled");
                            $(".nav-item").removeClass("active");
                            $("#nav-general-tab").addClass("active");
                            $(".tab-pane").removeClass("active show");
                            $("#nav-general").addClass("active show");
                            document.getElementById("formulario-clientes").reset(); 
                            $("#modal-add h4").html("REGISTRAR CLIENTE"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            $("#load_foto_modal").html(`<img src="img/user.png" width="100%">`); 
                            cliente.idEdit = 0;
                            cliente.metodo = 1; 
                            cliente.editURLimg = 0; 
                            cliente.editURLimg2 = 0;
                            break;

        case "conyugue":   
                            document.getElementById("formulario-conyugue").reset(); 
                            $("#modal-add-conyugue h4").html("REGISTRAR CONYUGUE"); 
                            $("#conyugue-ajax-result").html(""); 
                            $(".modal-btn-cont-2").html("");
                            $("#input_con_CA1").attr("disabled",false);
                            $("#input_con_CA2").attr("disabled",false);
                            conyugue.idEdit = 0;
                            conyugue.metodo = 1; 
                            break;

        case "negocio":    
                            document.getElementById("formulario-negocio").reset(); 
                            $("#modal-add-negocio h4").html("Nuevo Negocio"); 
                            $("#negocio-ajax-result").html(""); 
                            $(".modal-btn-cont-2").html("");
                            negocio.idEdit = 0;
                            negocio.metodo = 1; 
                            negocio.editURLimg = 0;
                            negocio.editURLimg2 = 0;
                            negocio.tipo = 'NEGOCIO';
                            break;

        case "transporte":    
                            document.getElementById("formulario-transporte").reset(); 
                            $("#modal-add-transporte h4").html("Nuevo Negocio de transporte"); 
                            $("#transporte-ajax-result").html(""); 
                            $(".modal-btn-cont-2").html("");

                            $("#input_trans_SOAT_CAD").attr("readonly","readonly");
                            $("#input_trans_SOAT_CAD").prop('required',false);
                            $("#input_trans_TARJETA_CAD").attr("readonly","readonly");
                            $("#input_trans_TARJETA_CAD").prop('required',false);

                            negocio.idEdit = 0;
                            negocio.metodo = 1; 
                            negocio.editURLimg = 0;
                            negocio.editURLimg2 = 0;
                            negocio.tipo = 'TRANSPORTE';
                            break;

        case "consumo":    
                            document.getElementById("formulario-consumo").reset(); 
                            $("#modal-add-consumo h4").html("Nuevo Credito de Consumo"); 
                            $("#consumo-ajax-result").html(""); 
                            $(".modal-btn-cont-2").html("");
                            negocio.idEdit = 0;
                            negocio.metodo = 1; 
                            break;
    }
}

function btn_edit(modulo,id,tipo){
    switch(modulo){
        case "usuarios":    $(".nav-item").removeClass("active");
                            $("#nav-general-tab").addClass("active");
                            $(".tab-pane").removeClass("active show");
                            $("#nav-general").addClass("active show");
                            user.metodo = 2; 
                            user.idEdit = id; 
                            user.editURLimg = 0;
                            user.editar(id); 
                            break;

        case "clientes":    $("#nav-conyugue-tab").removeClass("disabled");
                            $("#nav-negocio-tab").removeClass("disabled");
                            $(".nav-item").removeClass("active");
                            $("#nav-general-tab").addClass("active");
                            $(".tab-pane").removeClass("active show");
                            $("#nav-general").addClass("active show");
                            cliente.metodo = 2; 
                            cliente.idEdit = id; 
                            cliente.editURLimg = 0;
                            cliente.editURLimg2 = 0;
                            cliente.editar(id); 
                            break;

        case "conyugue":    conyugue.metodo = 2; 
                            conyugue.idEdit = id; 
                            //$("#input_con_CA1").attr("disabled",true);
                            //$("#input_con_CA2").attr("disabled",true);
                            conyugue.editar(id,tipo); 
                            break;

        case "negocio":    
                            document.getElementById("formulario-negocio").reset();
                            $('#modal-add-negocio').modal('show'); 
                            $('#modal-add-negocio h4').html("Editar Negocio");
                            negocio.metodo = 2; 
                            negocio.idEdit = id; 
                            negocio.editURLimg = 0;
                            negocio.editURLimg2 = 0;
                            negocio.tipo = "NEGOCIO";
                            negocio.editar(id); 
                            break;

        case "transporte":    
                            document.getElementById("formulario-transporte").reset();
                            $('#modal-add-transporte').modal('show'); 
                            $('#modal-add-transporte h4').html("Editar Negocio de Transporte");

                            $("#input_trans_SOAT_CAD").attr("readonly","readonly");
                            $("#input_trans_SOAT_CAD").prop('required',false);
                            $("#input_trans_TARJETA_CAD").attr("readonly","readonly");
                            $("#input_trans_TARJETA_CAD").prop('required',false);

                            negocio.metodo = 2; 
                            negocio.idEdit = id; 
                            negocio.editURLimg = 0;
                            negocio.editURLimg2 = 0;
                            negocio.tipo = "TRANSPORTE";
                            negocio.editar(id); 
                            break;

        case "consumo":    
                            document.getElementById("formulario-consumo").reset();
                            $('#modal-add-consumo').modal('show'); 
                            $('#modal-add-consumo h4').html("Editar Credito de Consumo");
                            negocio.metodo = 2; 
                            negocio.idEdit = id; 
                            negocio.editarConsumo(id); 
                            break;
    }
}


function btn_add_credito(modulo){
    switch(modulo){
        case "solicitud":
                            $("#load_data_modal").html(`
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                            `);
                            solicitud_monto = "";
                            solicitud_cuotas = "";
                            solicitud_frecuencia = "";
                            solicitud_interes = "";
                            solicitud_inicio = "";
                            datalist_id_cliente = null;
                            datalist_id_conyugue = null;
                            datalist_id_aval = null;


                            $("#inputCLIENT").removeClass("is-invalid");
                            $("#inputCLIENT").removeClass("is-valid");
                            $("#inputASES").removeClass("is-invalid");
                            $("#inputASES").removeClass("is-valid");
                            $("#inputCONY_AJAX").removeClass("is-valid");
                            $("#inputCONY_AJAX").removeClass("is-invalid");
                            $("#inputAVAL_AJAX").removeClass("is-valid");
                            $("#inputAVAL_AJAX").removeClass("is-invalid");
                            $("#inputCONY_AJAX").attr("readonly","readonly");
                            $("#inputAVAL_AJAX").attr("readonly","readonly");
                            $("#inputCONY").prop('checked',false);
                            $("#inputAVAL").prop('checked',false);

                            document.getElementById("formulario-solicitud").reset(); 
                            $("#modal-add h4").html("Nueva Solicitud de Crédito"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            credito.idEdit = 0;
                            credito.metodo = 1;
                            credito.buscarUsuario();
                            break;


    }
}

function btn_edit_credito(modulo,id){
    switch(modulo){
        case "solicitud":
                            $("#load_data_modal").html(`
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                            `);
                            solicitud_monto = "";
                            solicitud_cuotas = "";
                            solicitud_frecuencia = "";
                            solicitud_interes = "";
                            solicitud_inicio = "";


                            $("#inputCLIENT").removeClass("is-invalid");
                            $("#inputCLIENT").removeClass("is-valid");
                            $("#inputASES").removeClass("is-invalid");
                            $("#inputASES").removeClass("is-valid");
                            $("#inputCONY_AJAX").removeClass("is-valid");
                            $("#inputCONY_AJAX").removeClass("is-invalid");
                            $("#inputAVAL_AJAX").removeClass("is-valid");
                            $("#inputAVAL_AJAX").removeClass("is-invalid");
                            $("#inputCONY_AJAX").attr("readonly","readonly");
                            $("#inputAVAL_AJAX").attr("readonly","readonly");
                            $("#inputCONY").prop('checked',false);
                            $("#inputAVAL").prop('checked',false);

                            document.getElementById("formulario-solicitud").reset(); 
                            $("#modal-add h4").html("Modificar Solicitud"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            credito.idEdit = id;
                            credito.metodo = 2;
                            credito.editar(id);
                            break;

        case "aprobacion":
                            $("#load_data_modal").html(`
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                            `);
                            solicitud_monto = "";
                            solicitud_cuotas = "";
                            solicitud_frecuencia = "";
                            solicitud_interes = "";
                            solicitud_inicio = "";


                            $("#inputADMIN").removeClass("is-invalid");
                            $("#inputADMIN").removeClass("is-valid");
                            $("#inputCLIENT").removeClass("is-invalid");
                            $("#inputCLIENT").removeClass("is-valid");
                            $("#inputASES").removeClass("is-invalid");
                            $("#inputASES").removeClass("is-valid");
                            $("#inputCONY_AJAX").removeClass("is-valid");
                            $("#inputCONY_AJAX").removeClass("is-invalid");
                            $("#inputAVAL_AJAX").removeClass("is-valid");
                            $("#inputAVAL_AJAX").removeClass("is-invalid");
                            $("#inputCONY_AJAX").attr("readonly","readonly");
                            $("#inputAVAL_AJAX").attr("readonly","readonly");
                            $("#inputCONY").prop('checked',false);
                            $("#inputAVAL").prop('checked',false);

                            document.getElementById("formulario-aprobacion").reset(); 
                            $("#modal-add h4").html("Aprobar/Desaprobar solicitud"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            credito.idEdit = id;
                            credito.metodo = 2;
                            credito.editarAprobacion(id);
                            credito.buscarAdmin();
                            break;

        case "desembolso":
                                $("#load_data_modal").html(`
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                `);
                                solicitud_monto = "";
                                solicitud_cuotas = "";
                                solicitud_frecuencia = "";
                                solicitud_interes = "";
                                solicitud_inicio = "";

                                
                                $("#inputCAJA").removeClass("is-invalid");
                                $("#inputCAJA").removeClass("is-valid");
                                $("#inputADMIN").removeClass("is-invalid");
                                $("#inputADMIN").removeClass("is-valid");
                                $("#inputCLIENT").removeClass("is-invalid");
                                $("#inputCLIENT").removeClass("is-valid");
                                $("#inputASES").removeClass("is-invalid");
                                $("#inputASES").removeClass("is-valid");
                                $("#inputCONY_AJAX").removeClass("is-valid");
                                $("#inputCONY_AJAX").removeClass("is-invalid");
                                $("#inputAVAL_AJAX").removeClass("is-valid");
                                $("#inputAVAL_AJAX").removeClass("is-invalid");
                                $("#inputCONY_AJAX").attr("readonly","readonly");
                                $("#inputAVAL_AJAX").attr("readonly","readonly");
                                $("#inputCONY").prop('checked',false);
                                $("#inputAVAL").prop('checked',false);
    
                                document.getElementById("formulario-desembolso").reset(); 
                                $("#modal-add h4").html("Desembolsar Crédito"); 
                                $("#msg-ajax-result").html(""); 
                                $(".modal-btn-cont").html("");
                                credito.idEdit = id;
                                credito.metodo = 2;
                                caja.buscarCajas();
                                credito.editarDesembolso(id);
                                credito.buscarCaja();
                                break;

        case "extornar":
                                $("#load_data_modal").html(`
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                `);
                                solicitud_monto = "";
                                solicitud_cuotas = "";
                                solicitud_frecuencia = "";
                                solicitud_interes = "";
                                solicitud_inicio = "";

                                
                                $("#inputCAJA").removeClass("is-invalid");
                                $("#inputCAJA").removeClass("is-valid");
                                $("#inputADMIN").removeClass("is-invalid");
                                $("#inputADMIN").removeClass("is-valid");
                                $("#inputCLIENT").removeClass("is-invalid");
                                $("#inputCLIENT").removeClass("is-valid");
                                $("#inputASES").removeClass("is-invalid");
                                $("#inputASES").removeClass("is-valid");
                                $("#inputCONY_AJAX").removeClass("is-valid");
                                $("#inputCONY_AJAX").removeClass("is-invalid");
                                $("#inputAVAL_AJAX").removeClass("is-valid");
                                $("#inputAVAL_AJAX").removeClass("is-invalid");
                                $("#inputCONY_AJAX").attr("readonly","readonly");
                                $("#inputAVAL_AJAX").attr("readonly","readonly");
                                $("#inputCONY").prop('checked',false);
                                $("#inputAVAL").prop('checked',false);
    
                                document.getElementById("formulario-desembolso").reset(); 
                                $("#modal-add h4").html("Extornar Desembolso"); 
                                $("#msg-ajax-result").html(""); 
                                $(".modal-btn-cont").html("");
                                credito.idEdit = id;
                                credito.metodo = 2;
                                caja.buscarCajas();
                                credito.editarExtorno(id);
                                credito.buscarCaja();
                                break;


    }
}

function btn_ver_credito(modulo,id){
    switch(modulo){
        case "solicitud":
                            $("#load_data_modal-w").html(`
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                            `);
                            solicitud_monto = "";
                            solicitud_cuotas = "";
                            solicitud_frecuencia = "";
                            solicitud_interes = "";
                            solicitud_inicio = "";


                            $("#inputCLIENT-w").removeClass("is-invalid");
                            $("#inputCLIENT-w").removeClass("is-valid");
                            $("#inputASES-w").removeClass("is-invalid");
                            $("#inputASES-w").removeClass("is-valid");
                            $("#inputCONY_AJAX-w").removeClass("is-valid");
                            $("#inputCONY_AJAX-w").removeClass("is-invalid");
                            $("#inputAVAL_AJAX-w").removeClass("is-valid");
                            $("#inputAVAL_AJAX-w").removeClass("is-invalid");
                            $("#inputCONY_AJAX-w").attr("readonly","readonly");
                            $("#inputAVAL_AJAX-w").attr("readonly","readonly");
                            $("#inputCONY-w").prop('checked',false);
                            $("#inputAVAL-w").prop('checked',false);

                            document.getElementById("formulario-solicitud-view").reset(); 
                            $("#modal-add-view h4").html("Detalles de la Solicitud"); 
                            $("#msg-ajax-result-w").html(""); 
                            $(".modal-btn-cont").html("");
                            credito.idEdit = 0;
                            credito.metodo = 0;
                            credito.verDetalles(id);
                            break;

        case "aprobacion":
                            $("#load_data_modal-w").html(`
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                                    <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
                            `);
                            solicitud_monto = "";
                            solicitud_cuotas = "";
                            solicitud_frecuencia = "";
                            solicitud_interes = "";
                            solicitud_inicio = "";


                            $("#inputADMIN-w").removeClass("is-invalid");
                            $("#inputADMIN-w").removeClass("is-valid");
                            $("#inputCLIENT-w").removeClass("is-invalid");
                            $("#inputCLIENT-w").removeClass("is-valid");
                            $("#inputASES-w").removeClass("is-invalid");
                            $("#inputASES-w").removeClass("is-valid");
                            $("#inputCONY_AJAX-w").removeClass("is-valid");
                            $("#inputCONY_AJAX-w").removeClass("is-invalid");
                            $("#inputAVAL_AJAX-w").removeClass("is-valid");
                            $("#inputAVAL_AJAX-w").removeClass("is-invalid");
                            $("#inputCONY_AJAX-w").attr("readonly","readonly");
                            $("#inputAVAL_AJAX-w").attr("readonly","readonly");
                            $("#inputCONY-w").prop('checked',false);
                            $("#inputAVAL-w").prop('checked',false);

                            document.getElementById("formulario-aprobacion-view").reset(); 
                            $("#modal-add-view h4").html("Detalles de la Aprobación"); 
                            $("#msg-ajax-result-w").html(""); 
                            $(".modal-btn-cont").html("");
                            credito.idEdit = 0;
                            credito.metodo = 0;
                            credito.verDetallesADM(id);
                            break;
    }
}

function btn_desembolso_print(modulo,id){
    switch(modulo){
        case "voucher": credito.voucher(id);
                        break;

        case "cronograma": credito.cronograma(id);
                        break;

        case "contrato": credito.contrato(id);
                        break;
    }
}

function btn_pago_print(modulo,id){
    switch(modulo){
        case "voucher": credito.voucherPago(id);
                        break;
    }
}

function btn_movimientos_print(modulo,id){
    switch(modulo){
        case "voucher": caja.voucher(id);
                        break;
    }
}
function btn_transferencias_print(modulo,id){
    switch(modulo){
        case "voucher": caja.voucherTransferencia(id);
                        break;
    }
}
function btn_cuenta_print(modulo,id){
    switch(modulo){
        case "pf":  cuenta.voucherPF(id);
                    break;

        case "pf_retiro": cuenta.voucherPF_retiro(id);
                    break;
    }
}


function btn_edit_cobranza(idcredito,idcliente){
    
    $("#load_data_modal").html(`
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
    `);
                                
    solicitud_monto = "";
    solicitud_cuotas = "";
    solicitud_frecuencia = "";
    solicitud_interes = "";
    solicitud_inicio = "";
   
    $("#inputCAJA").removeClass("is-invalid");
    $("#inputCAJA").removeClass("is-valid");
    $("#inputCLIENT").removeClass("is-invalid");
    $("#inputCLIENT").removeClass("is-valid");
    
    document.getElementById("formulario-cobranza").reset(); 
    $("#modal-add h4").html("Modulo de Cobranza"); 
    $("#msg-ajax-result").html(""); 
    $(".modal-btn-cont").html("");
    credito.idEdit = idcredito;
    credito.metodo = 2;
    caja.buscarCajas();
    credito.buscarCaja();
    credito.buscar_cliente_cobranza_autocomplete(idcliente);
    credito.editarCobranza(idcredito,idcliente);
    credito.listarVoucherPago(idcredito);
}
function btn_condonar_cobranza(idcredito,idcliente){
    
    $("#load_data_modal-c").html(`
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
    `);
                                
    solicitud_monto = "";
    solicitud_cuotas = "";
    solicitud_frecuencia = "";
    solicitud_interes = "";
    solicitud_inicio = "";
   
    $("#inputCAJA-c").removeClass("is-invalid");
    $("#inputCAJA-c").removeClass("is-valid");
    $("#inputCLIENT-c").removeClass("is-invalid");
    $("#inputCLIENT-c").removeClass("is-valid");
    
    document.getElementById("formulario-condonar").reset(); 
    $("#modal-condonar h4").html("Modulo de Condonaciones"); 
    $("#msg-ajax-result-c").html(""); 
    $(".modal-btn-cont").html("");
    credito.idEdit = idcredito;
    credito.metodo = 2;

    credito.buscarResponsable();
    credito.buscar_cliente_condonacion_autocomplete(idcliente);
    credito.editarCondonacion(idcredito,idcliente);
    credito.listarVoucherPagoCondonacion(idcredito);
}


function btn_add_caja(modulo){
    switch(modulo){
        case "CREAR":
                        document.getElementById("formulario-caja").reset(); 
                        $("#modal-add h4").html("Nueva Caja"); 
                        $("#msg-ajax-result").html(""); 
                        $("#caja_autor").removeClass("is-invalid");
                        $("#caja_autor").removeClass("is-valid");
                        caja.metodo = 1;
                        break;

        case "APERTURA":


        case "MOVIMIENTOS":
    }
}

function btn_edt_caja(id,modulo){
    switch(modulo){
        case "CREAR":
                        document.getElementById("formulario-caja-edt").reset(); 
                        $("#modal-add-edt h4").html("Modificar Caja"); 
                        $("#msg-ajax-result-edt").html(""); 
                        $("#caja_autor-edt").removeClass("is-invalid");
                        $("#caja_autor-edt").removeClass("is-valid");
                        $(".modal-btn-cont-edt").html('');
                        caja.metodo = 2;
                        caja.idEdit = id;
                        caja.editCaja(id);
                        break;

        case "APERTURA":
                        document.getElementById("formulario-apertura").reset(); 
                        $("#modal-add h4").html("Aperturar Caja"); 
                        $("#msg-ajax-result").html(""); 
                        $("#monto_tipo").text("Monto de Apertura*");

                        $(".caja_billetaje").attr("readonly","readonly");

                        caja.metodo = 0;
                        caja.idEdit = id;
                        caja.buscarFechaHora();
                        caja.buscarUserCaja();
                        caja.editApertura(id);
                        break;

        case "CIERRE":
                        document.getElementById("formulario-apertura").reset(); 
                        $("#modal-add h4").html("Cerrar Caja"); 
                        $("#msg-ajax-result").html("");
                        $("#monto_tipo").text("Monto de Cierre*"); 

                        $(".caja_billetaje").removeAttr("readonly");

                        caja.metodo = 0;
                        caja.idEdit = id;
                        caja.buscarFechaHora();
                        caja.buscarUserCaja();
                        caja.editApertura(id);
                        break;
    }
}

function btn_add_movimientos(){
    document.getElementById("formulario-movimientos").reset(); 
    $("#modal-add h4").html("Registrar Movimiento de Caja"); 
    $("#msg-ajax-result").html("");
    $("#modal-add").modal("show");
    caja.metodo = 1;
    caja.buscarFechaHora();
    caja.buscarCajas();
    caja.buscarUserCaja();
}

function btn_add_transferencias(){
    document.getElementById("formulario-transferencias").reset(); 
    $("#movimiento_autoriza").removeClass("is-valid");
    $("#movimiento_autoriza").removeClass("is-invalid");
    $("#modal-add h4").html("Registrar Transferencia de Caja"); 
    $("#msg-ajax-result").html("");
    $("#modal-add").modal("show");
    caja.metodo = 1;
    caja.buscarFechaHora();
    caja.buscarCajasTransferencias();
    caja.buscarUserCaja();
}


function btn_add_cuenta(modulo){
    switch(modulo){
        case "corriente":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            document.getElementById("formulario-cuenta_corriente").reset(); 
                            $("#modal-add h4").html("REGISTRAR CUENTA CORRIENTE"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = 0;
                            cuenta.metodo = 1; 
                            cuenta.buscarUserCaja();
                            break;

        case "pf":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            document.getElementById("formulario-cuenta_pf").reset(); 
                            $("#modal-add h4").html("REGISTRAR CUENTA A PLAZO FIJO"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = 0;
                            cuenta.metodo = 1; 
                            caja.buscarCajas();
                            cuenta.buscarUserCaja();
                            cuenta.buscarFechaHora();
                            break;

        case "pp":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            document.getElementById("formulario-cuenta_pp").reset(); 
                            $("#modal-add h4").html("REGISTRAR CUENTA A PLAZO PROGRAMADO"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = 0;
                            cuenta.metodo = 1; 
                            caja.buscarCajas();
                            cuenta.buscarUserCaja();
                            cuenta.buscarFechaHora();
                            break;
    }
}

function btn_edit_cuenta(modulo,id){
    switch(modulo){
        case "corriente":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            document.getElementById("formulario-cuenta_corriente").reset(); 
                            $("#modal-add h4").html("MODIFICAR CUENTA CORRIENTE"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = id;
                            cuenta.metodo = 2; 
                            cuenta.buscarUserCaja();
                            cuenta.editar(id);
                            break;

        case "pf":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            document.getElementById("formulario-cuenta_pf").reset(); 
                            $("#modal-add h4").html("MODIFICAR CUENTA A PLAZO FIJO"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = id;
                            cuenta.metodo = 2; 
                            cuenta.buscarUserCaja();
                            cuenta.editarPF(id);
                            break;

        case "pp":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            document.getElementById("formulario-cuenta_pp").reset(); 
                            $("#modal-add h4").html("MODIFICAR CUENTA A PLAZO PROGRAMADO"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = id;
                            cuenta.metodo = 2; 
                            cuenta.buscarUserCaja();
                            cuenta.editarPF(id);
                            break;
    }
}

function btn_edit_deposito(idcuenta,idcliente){
    
    $("#load_data_modal").html(`
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
        <tr><th scope="row" style="height:25px;"></th><td></td><td></td><td></td></tr>
    `);
                                
   
    $("#inputCAJA").removeClass("is-invalid");
    $("#inputCAJA").removeClass("is-valid");
    $("#inputCLIENT").removeClass("is-invalid");
    $("#inputCLIENT").removeClass("is-valid");
    
    document.getElementById("formulario-deposito_cc").reset(); 
    $("#modal-add h4").html("Modulo de Deposito"); 
    $("#msg-ajax-result").html(""); 
    $(".modal-btn-cont").html("");
    cuenta.idEdit = idcuenta;
    cuenta.metodo = 2;
    caja.buscarCajas();
    cuenta.buscarUserCaja();
    cuenta.buscar_cliente_deposito_autocomplete(idcliente);
    cuenta.editarDeposito(idcuenta,idcliente);
}

function btn_retiro_cuenta(modulo,id){
    switch(modulo){
        case "corriente":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            document.getElementById("formulario-cuenta_corriente").reset(); 
                            $("#modal-add h4").html("MODIFICAR CUENTA CORRIENTE"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = id;
                            cuenta.metodo = 2; 
                            caja.buscarCajas();
                            cuenta.buscarUserCaja();
                            cuenta.editar(id);
                            break;

        case "pf":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            $("#pf_MONTO_FIN").removeClass('is-valid');
                            document.getElementById("formulario-cuenta_pf_retiro").reset(); 
                            $("#modal-add h4").html("RETIRAR CAPITAL DE CUENTA A PLAZO FIJO"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = id;
                            cuenta.metodo = 1; 
                            caja.buscarCajas();
                            cuenta.buscarUserCaja();
                            cuenta.editarPF_retiro(id);
                            break;

        case "pp":   
                            $("#inputCAJA").removeClass("is-invalid");
                            $("#inputCAJA").removeClass("is-valid");
                            $("#pf_MONTO_FIN").removeClass('is-valid');
                            document.getElementById("formulario-cuenta_pp_retiro").reset(); 
                            $("#modal-add h4").html("RETIRAR CAPITAL DE CUENTA A PLAZO PROGRAMADO"); 
                            $("#msg-ajax-result").html(""); 
                            $(".modal-btn-cont").html("");
                            cuenta.idEdit = id;
                            cuenta.metodo = 1; 
                            caja.buscarCajas();
                            cuenta.buscarUserCaja();
                            cuenta.editarPP_retiro(id);
                            break;
    }
}


function printDiv(nombreDiv) {
    
    var contenido = document.getElementById(nombreDiv).innerHTML;
    
    /*
    var contenidoOriginal= document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
    */


    // data es el HTML a imprimir (el contenido del elemento)
    var pw = window.open('', 'my div', 'height=700,width=1100');
    pw.document.write('<html><head>');
    pw.document.write('<link rel="stylesheet" href="../css/bootstrap.css"></link>');
    pw.document.write('<link rel="stylesheet" href="../css/print.css"></link>');
    //pw.document.write('<style type="text/css" media="print">@page { size: landscape; }</style>');

    pw.document.write('</head><body>');
    pw.document.write(contenido);
    pw.document.write('</body></html>');
    pw.document.close();
    pw.focus();
    pw.onload = function() {
        pw.print();
        pw.close();
    };

    return true;
    
}

function printDivH(nombreDiv) {
    
    var contenido = document.getElementById(nombreDiv).innerHTML;
    
    /*
    var contenidoOriginal= document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
    */


    // data es el HTML a imprimir (el contenido del elemento)
    var pw = window.open('', 'my div', 'height=700,width=1100');
    pw.document.write('<html><head>');
    pw.document.write('<link rel="stylesheet" href="../css/bootstrap.css"></link>');
    pw.document.write('<link rel="stylesheet" href="../css/print.css"></link>');
    pw.document.write('<style type="text/css" media="print">@page { size: landscape; }</style>');

    pw.document.write('</head><body>');
    pw.document.write(contenido);
    pw.document.write('</body></html>');
    pw.document.close();
    pw.focus();
    pw.onload = function() {
        pw.print();
        pw.close();
    };

    return true;
    
}





function solicitud_calendario(){
    //console.log("calculando...")
    var monto = solicitud_monto;
    var cuotas = solicitud_cuotas;
    var frecuencia = solicitud_frecuencia;
    var interes = solicitud_interes;
    var inicio = solicitud_inicio;



    var cal_cuota;
    var cal_interes;
    var cal_total;
    var cal_fecha_dias;
    var ajax_fechas;

    monto = parseFloat(monto);
    cuotas = parseFloat(cuotas);
    interes = parseFloat(interes);

    if(monto!=null && monto!="" && cuotas!=null && cuotas!="" && frecuencia!=null && frecuencia!="" && interes!=null && interes!="" &&inicio!=null && inicio!=""){
        
        cal_interes = monto*interes/100;
        cal_cuota = (monto + cal_interes)/cuotas;
        cal_total = monto + cal_interes;
        switch(frecuencia){
            case 'DIARIO': cal_fecha_dias = 1; break;
            case 'SEMANAL': cal_fecha_dias = 7; break;
            case 'QUINCENAL': cal_fecha_dias = 15; break;
            case 'MENSUAL': cal_fecha_dias = 30; break;
        }



        $("#sol_cal_CUOTAS").val(Math.ceil10(cal_cuota,-1));
        $("#sol_cal_INTERES").val(Math.ceil10(cal_interes,-1));
        $("#sol_cal_TOTAL").val(Math.ceil10(cal_total,-1));

        $("#load_data_modal").html(`
            
        `);
        $("#load_data_modal-w").html(`
            
        `);



        $.ajax({
            url: "../backend/panel/solicitud_fechas.php?fecha="+inicio+"&frecuencia="+cal_fecha_dias+"&cuotas="+cuotas,
            type: "GET",
            success: function(response){
                ajax_fechas = JSON.parse(response);
                var contenido_ajax;
                var cont = 0;
                //console.log(ajax_fechas);

                ajax_fechas.forEach( ajax_fechas => {
                    contenido_ajax += `
                            <tr>
                                <th scope="row">${cont+1}</th>
                                <td>${ajax_fechas.cuota}</td>
                                <td>${Math.ceil10(cal_cuota,-1)}</td>
                                <td>${Math.ceil10(cal_total-((cont+1)*cal_cuota),-1)}</td>
                            </tr>
                    
                        `;
                        cont ++;
                });

                $("#load_data_modal").html(``);
                $("#load_data_modal-w").html(``);
                $("#load_data_modal").append(contenido_ajax);
                $("#load_data_modal-w").append(contenido_ajax);
      

            }
        });


        

        

    }

    
}

function solicitud_calendario_adm(){
    //console.log("calculando...")
    var monto = solicitud_monto;
    var cuotas = solicitud_cuotas;
    var frecuencia = solicitud_frecuencia;
    var interes = solicitud_interes;
    var inicio = solicitud_inicio;


    $("#load_data_modal").html(``);
    $("#load_data_modal-w").html(``);


    var cal_cuota;
    var cal_interes;
    var cal_total;
    var cal_fecha_dias;
    var ajax_fechas;

    monto = parseFloat(monto);
    cuotas = parseFloat(cuotas);
    interes = parseFloat(interes);

    if(monto!=null && monto!="" && cuotas!=null && cuotas!="" && frecuencia!=null && frecuencia!="" && interes!=null && interes!="" &&inicio!=null && inicio!=""){
        
        cal_interes = monto*interes/100;
        cal_cuota = (monto + cal_interes)/cuotas;
        cal_total = monto + cal_interes;
        switch(frecuencia){
            case 'DIARIO': cal_fecha_dias = 1; break;
            case 'SEMANAL': cal_fecha_dias = 7; break;
            case 'QUINCENAL': cal_fecha_dias = 15; break;
            case 'MENSUAL': cal_fecha_dias = 30; break;
        }



        $("#sol_cal_CUOTAS_APRO").val(Math.ceil10(cal_cuota,-1));
        $("#sol_cal_INTERES_APRO").val(Math.ceil10(cal_interes,-1));
        $("#sol_cal_TOTAL_APRO").val(Math.ceil10(cal_total,-1));

        



        $.ajax({
            url: "../backend/panel/solicitud_fechas.php?fecha="+inicio+"&frecuencia="+cal_fecha_dias+"&cuotas="+cuotas,
            type: "GET",
            success: function(response){
                ajax_fechas = JSON.parse(response);
                var contenido_ajax;
                var cont = 0;
                //console.log(ajax_fechas);

                ajax_fechas.forEach( ajax_fechas => {
                    contenido_ajax += `
                            <tr>
                                <th scope="row">${cont+1}</th>
                                <td>${ajax_fechas.cuota}</td>
                                <td>${Math.ceil10(cal_cuota,-1)}</td>
                                <td>${Math.ceil10(cal_total-((cont+1)*cal_cuota),-1)}</td>
                            </tr>
                    
                        `;
                        cont ++;
                });

                $("#load_data_modal").html(``);
                $("#load_data_modal-w").html(``);
                $("#load_data_modal").append(contenido_ajax);
                $("#load_data_modal-w").append(contenido_ajax);
      

            }
        });


        

        

    }

    
}

function solicitud_calendario_cronograma(){
    //console.log("calculando...")
    var monto = solicitud_monto;
    var cuotas = solicitud_cuotas;
    var frecuencia = solicitud_frecuencia;
    var interes = solicitud_interes;
    var inicio = solicitud_inicio;



    var cal_cuota;
    var cal_interes;
    var cal_total;
    var cal_fecha_dias;
    var ajax_fechas;

    monto = parseFloat(monto);
    cuotas = parseFloat(cuotas);
    interes = parseFloat(interes);

    if(monto!=null && monto!="" && cuotas!=null && cuotas!="" && frecuencia!=null && frecuencia!="" && interes!=null && interes!="" &&inicio!=null && inicio!=""){
        
        cal_interes = monto*interes/100;
        cal_cuota = (monto + cal_interes)/cuotas;
        cal_total = monto + cal_interes;
        switch(frecuencia){
            case 'DIARIO': cal_fecha_dias = 1; break;
            case 'SEMANAL': cal_fecha_dias = 7; break;
            case 'QUINCENAL': cal_fecha_dias = 15; break;
            case 'MENSUAL': cal_fecha_dias = 30; break;
        }



        //$("#sol_cal_CUOTAS").val(Math.ceil10(cal_cuota,-1));
        //$("#sol_cal_INTERES").val(Math.ceil10(cal_interes,-1));
        //$("#sol_cal_TOTAL").val(Math.ceil10(cal_total,-1));


        $("#load_data_modal-cronograma").html(`
            
        `);


        $.ajax({
            url: "../backend/panel/solicitud_fechas.php?fecha="+inicio+"&frecuencia="+cal_fecha_dias+"&cuotas="+cuotas,
            type: "GET",
            success: function(response){
                ajax_fechas = JSON.parse(response);
                var contenido_ajax;
                var cont = 0;
                //console.log(ajax_fechas);

                ajax_fechas.forEach( ajax_fechas => {
                    contenido_ajax += `
                            <tr>
                                <th scope="row">${cont+1}</th>
                                <td>${ajax_fechas.cuota}</td>
                                <td>${Math.ceil10(cal_cuota,-1)}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    
                        `;
                        cont ++;
                });

                $("#load_data_modal-cronograma").html(``);
                $("#load_data_modal-cronograma").append(contenido_ajax);
      

            }
        });


        

        

    }

    
}

function solicitud_calendario_contrato(){
    //console.log("calculando...")
    var monto = solicitud_monto;
    var cuotas = solicitud_cuotas;
    var frecuencia = solicitud_frecuencia;
    var interes = solicitud_interes;
    var inicio = solicitud_inicio;



    var cal_cuota;
    var cal_interes;
    var cal_total;
    var cal_fecha_dias;
    var ajax_fechas;

    monto = parseFloat(monto);
    cuotas = parseFloat(cuotas);
    interes = parseFloat(interes);

    if(monto!=null && monto!="" && cuotas!=null && cuotas!="" && frecuencia!=null && frecuencia!="" && interes!=null && interes!="" &&inicio!=null && inicio!=""){
        
        cal_interes = monto*interes/100;
        cal_cuota = (monto + cal_interes)/cuotas;
        cal_total = monto + cal_interes;
        switch(frecuencia){
            case 'DIARIO': cal_fecha_dias = 1; break;
            case 'SEMANAL': cal_fecha_dias = 7; break;
            case 'QUINCENAL': cal_fecha_dias = 15; break;
            case 'MENSUAL': cal_fecha_dias = 30; break;
        }


        $.ajax({
            url: "../backend/panel/solicitud_fechas.php?fecha="+inicio+"&frecuencia="+cal_fecha_dias+"&cuotas="+cuotas,
            type: "GET",
            success: function(response){
                ajax_fechas = JSON.parse(response);
                var contenido_ajax;
                var cont = 0;
                //console.log(ajax_fechas);
                ajax_fechas.forEach( ajax_fechas => {
                   
                    $("#fecha_vencimiento").html(ajax_fechas.cuota);
                          
                });
            }
        });

        
  

    }


    
}

function solicitud_calendario_pagos(id){
    //console.log("calculando...")
    var monto = solicitud_monto;
    var cuotas = solicitud_cuotas;
    var frecuencia = solicitud_frecuencia;
    var interes = solicitud_interes;
    var inicio = solicitud_inicio;

    var pagos_info = [];


    var cal_cuota;
    var cal_interes;
    var cal_total;
    var cal_fecha_dias;
    var ajax_fechas;

    monto = parseFloat(monto);
    cuotas = parseFloat(cuotas);
    interes = parseFloat(interes);

    if(monto!=null && monto!="" && cuotas!=null && cuotas!="" && frecuencia!=null && frecuencia!="" && interes!=null && interes!="" &&inicio!=null && inicio!=""){
        
        cal_interes = monto*interes/100;
        cal_cuota = (monto + cal_interes)/cuotas;
        cal_total = monto + cal_interes;
        switch(frecuencia){
            case 'DIARIO': cal_fecha_dias = 1; break;
            case 'SEMANAL': cal_fecha_dias = 7; break;
            case 'QUINCENAL': cal_fecha_dias = 15; break;
            case 'MENSUAL': cal_fecha_dias = 30; break;
        }

        //$("#sol_cal_CUOTAS").val(Math.ceil10(cal_cuota,-1));
        //$("#sol_cal_INTERES").val(Math.ceil10(cal_interes,-1));
        //$("#sol_cal_TOTAL").val(Math.ceil10(cal_total,-1));

        $.ajax({
            url: "../backend/panel/solicitud_fechas.php?fecha="+inicio+"&frecuencia="+cal_fecha_dias+"&cuotas="+cuotas,
            type: "GET",
            success: function(response){
                ajax_fechas = JSON.parse(response);
                var cont = 0;
                
                ajax_fechas.forEach( ajax_fechas => {
                    pagos_info.push({"n_cuota": cont+1, "fecha": ajax_fechas.cuota, "cuota": Math.ceil10(cal_cuota,-1), "id":id});
                    cont ++;
                });
                //console.log(pagos_info);

      
                $.ajax({
                    url: "../backend/panel/creditos/desembolsos/ajax_pagos.php",
                    type: "POST",
                    data: {array: JSON.stringify(pagos_info)},
                    success: function(response){   
                        //console.log(response);
                        if(response==200){ 
                            $("#msg-ajax-result").append(`
                                <div class="alert alert-success" role="alert"  style="margin-bottom: 10px;">
                                    Se creo el cronograma de pagos satisfactoriamente!
                                </div>
                            `);
                            
                            setTimeout(()=>{
                                $('#modal-add').modal('hide');
                                $('.btn_modals').prop('disabled', false);
                                $("#msg-ajax-result").html("");
                            },1000);
                        }else{
                            $("#msg-ajax-result").html(`
                                        <div class="alert alert-danger" role="alert"  style="margin-bottom: 10px;">
                                            No se pudo crear el cronograma de pagos! <br>`+response+`
                                        </div>
                            `);
                        }   
                    }
                });

            }
        });


        

        

    }

    
}

// Closure
(function() {
    /**
     * Ajuste decimal de un número.
     *
     * @param {String}  type  El tipo de ajuste.
     * @param {Number}  value El número.
     * @param {Integer} exp   El exponente (El logaritmo de ajuste en base 10).
     * @returns {Number} El valor ajustado.
     */
    function decimalAdjust(type, value, exp) {
      // Si exp es undefined o cero...
      if (typeof exp === 'undefined' || +exp === 0) {
        return Math[type](value);
      }
      value = +value;
      exp = +exp;
      // Si el valor no es un número o exp no es un entero...
      if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
        return NaN;
      }
      // Shift
      value = value.toString().split('e');
      value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
      // Shift back
      value = value.toString().split('e');
      return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }
  
    // Decimal round
    if (!Math.round10) {
      Math.round10 = function(value, exp) {
        return decimalAdjust('round', value, exp);
      };
    }
    // Decimal floor
    if (!Math.floor10) {
      Math.floor10 = function(value, exp) {
        return decimalAdjust('floor', value, exp);
      };
    }
    // Decimal ceil
    if (!Math.ceil10) {
      Math.ceil10 = function(value, exp) {
        return decimalAdjust('ceil', value, exp);
      };
    }
})();

























function ajax_load_DE(id){
    $.ajax({
        url: "backend/panel/ajax_de.php",
        type: "GET",
        data: {id: id},
        success: function(response){
            var direccionEJ = JSON.parse(response);
            var contenido_ajax = "";
        
            direccionEJ.forEach( direccionEJ => {
                
                contenido_ajax += `
                        <option value="${direccionEJ.id}">${direccionEJ.direccion}</option>
                    `;
            
            });

            $("#direccionEjecutiva").html(contenido_ajax);
            $("#direccionEjecutiva").attr("disabled",false);                 
        }
    });
}







